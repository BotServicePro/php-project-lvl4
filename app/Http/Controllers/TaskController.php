<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

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
     * @return View | RedirectResponse|Redirector
     */
    public function index(Request $request)
    {
        $usersList = User::pluck('name', 'id');
        $taskStatusesList = TaskStatus::pluck('name', 'id');
        $tasks = QueryBuilder::for(Task::class)
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

        return view('task.index', compact('tasks', 'taskStatusesList', 'usersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $task = new Task();
        $usersList = User::pluck('name', 'id');
        $taskStatusesList = TaskStatus::pluck('name', 'id');
        $labels = Label::all();
        return view('task.create', compact('task', 'usersList', 'taskStatusesList', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks|max:255',
            'description' => 'max:1000',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
        ], $messages = [
            'unique' => __('messages.taskUnique'),
        ]);

        $newTask = new Task();
        $newTask->fill($data);
        $newTask->created_by_id = Auth::id();
        $newTask->save();

        $labelsCollection = collect($request->labels) ?: [];
        $labelsCollection->filter(function ($label) use ($newTask) {
            $newTaskLabel = new LabelTask();
            $newTaskLabel->fill([
                'task_id' => $newTask->id,
                'label_id' => $label
            ]);
            $newTaskLabel->save();
        });
        flash(__('messages.taskSuccessAdded'))->success();
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return View
     */
    public function show(Task $task): View
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        $labels = Label::all();
        $selectedLabels = LabelTask::where('task_id', $task->id)->get();
        $usersList = User::pluck('name', 'id');
        $taskStatusesList = TaskStatus::pluck('name', 'id');

        return view('task.edit', compact('task', 'usersList', 'taskStatusesList', 'labels', 'selectedLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $newTask = Task::findOrFail($task->id);
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'max:1000',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
        ], $messages = [
            'required' => __('messages.taskRequired'),
            'unique' => __('messages.taskUnique'),
        ]);

        LabelTask::where('task_id', '=', $task->id)->delete();
        $labelsCollection =  collect($request->labels) ?: [];
        $labelsCollection->filter(function ($label) use ($newTask) {
            $newTaskLabel = new LabelTask();
            $newTaskLabel->fill([
                'task_id' => $newTask->id,
                'label_id' => $label
            ]);
            $newTaskLabel->save();
        });

        $newTask->fill($data);
        $newTask->save();
        flash(__('messages.taskSuccessUpdated'))->success();
        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse|Redirector
     */
    public function destroy(Task $task)
    {
        $task->getLabelData()->detach();
        $task->delete();
        flash(__('messages.taskSuccessDeleted'))->success();
        return redirect(route('tasks.index'));
    }
}
