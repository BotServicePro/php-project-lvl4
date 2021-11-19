<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View | \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        $usersList = User::all()->pluck('name', 'id');
        $taskStatusesList = TaskStatus::all()->pluck('name', 'id');
        $data = QueryBuilder::for(Task::class)
            ->addSelect([
                'task_author_name' => User::select('name')
                    ->whereColumn('id', 'tasks.created_by_id'),
                'status_name' => TaskStatus::select('name')
                    ->whereColumn('id', 'tasks.status_id'),
                'executor_name' => User::select('name')
                    ->whereColumn('id', 'tasks.assigned_to_id')
            ])
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')])
            ->paginate(10);

        return view('taskPages.index', compact('data', 'taskStatusesList', 'usersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $task = new Task();
        $usersList = User::all()->pluck('name', 'id');
        $taskStatusesList = TaskStatus::all()->pluck('name', 'id');
        $labels = Label::all();

        return view('taskPages.create', compact('task', 'usersList', 'taskStatusesList', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks|max:255',
            'description' => 'max:1000',
            'status_id' => 'required',
            'created_by_id' => '',
            'assigned_to_id' => '',
        ], $messages = [
            'unique' => __('messages.taskUnique'),
        ]);

        $newTask = new Task();
        $newTask->fill($data);
        $newTask->created_by_id = Auth::id();
        $newTask->save();

        if ($request->labels !== null) {
            foreach ($request->labels as $labelId) {
                $newTaskLabel = new LabelTask();
                $newTaskLabel->fill([
                    'task_id' => $newTask->id,
                    'label_id' => $labelId
                ]);
                $newTaskLabel->save();
            }
        }

        flash(__('messages.taskSuccessAdded'))->success();
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Task $task)
    {
        $taskData = Task::find($task->id);
        $statusData = $task->getStatusData;
        $labelsData =  LabelTask::where('task_id', '=', $task->id)->addSelect([
            'label_name' => Label::select('name')
                ->whereColumn('id', 'label_tasks.label_id')
        ])->get();

        return view('taskPages.show', compact('taskData', 'statusData', 'labelsData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Task $task)
    {
        $labels = Label::all();
        $task = Task::findOrFail($task->id);
        $selectedLabels = LabelTask::where('task_id', $task->id)->get();
        $usersList = User::all()->pluck('name', 'id');
        $taskStatusesList = TaskStatus::all()->pluck('name', 'id');

        return view('taskPages.edit', compact('task', 'usersList', 'taskStatusesList', 'labels', 'selectedLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $newTask = Task::findOrFail($task->id);
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'max:1000',
            'status_id' => 'required',
            'created_by_id' => '',
            'assigned_to_id' => '',
        ], $messages = [
            'required' => __('messages.taskRequired'),
            'unique' => __('messages.taskUnique'),
        ]);

        try {
            DB::beginTransaction();
            LabelTask::where('task_id', '=', $task->id)->delete();
            if ($request->labels !== null) {
                foreach ($request->labels as $labelId) {
                    $newTaskLabel = new LabelTask();
                    $newTaskLabel->fill([
                        'task_id' => $newTask->id,
                        'label_id' => $labelId
                    ]);
                    $newTaskLabel->save();
                }
            }

            $newTask->fill($data);
            $newTask->save();
            DB::commit();
            flash(__('messages.taskSuccessUpdated'))->success();
            return redirect(route('tasks.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            flash('Something went wrong - ' . $e)->error();
            return redirect(route('tasks.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Task $task)
    {
        $taskAuthorId = (int) $task->created_by_id;
        $authorizedUserId = Auth::id();
        if ($taskAuthorId !== $authorizedUserId) {
            flash(__('messages.taskUnsuccessDelete'))->error();
            return redirect(route('tasks.index'));
        }

        if (LabelTask::where('task_id', '=', $task->id)->count() > 0) {
            LabelTask::where('task_id', '=', $task->id)->delete();
        }

        flash(__('messages.taskSuccessDeleted'))->success();
        $task->delete();
        return redirect(route('tasks.index'));
    }
}
