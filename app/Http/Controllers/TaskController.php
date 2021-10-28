<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelTask;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        // Метод authorizeResource принимает имя класса модели в качестве своего первого аргумента и
        // имя параметра маршрута / запроса, который будет содержать идентификатор модели, в качестве второго аргумента
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View | \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(Request $request)
    {
        $usersList = User::All();
        $taskStatusesList = TaskStatus::All();

        // проверяем, если что-то в запросе из фильтра
        if ($request->filter !== null) {
            $validator = Validator::make($request->filter, [
                'status_id' => 'nullable|int',
                'created_by_id' => 'nullable|int',
                'assigned_to_id' => 'nullable|int',
            ]);

            if ($validator->fails()) {
                return redirect(route('tasks.index'))
                    ->withErrors($validator)
                    ->withInput();
            }

            // используем библиотеку laravel-query-builder с дополнительной выборкой
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

        $data =  Task::addSelect([
                'task_author_name' => User::select('name')
                    ->whereColumn('id', 'tasks.created_by_id'),
                'status_name' => TaskStatus::select('name')
                    ->whereColumn('id', 'tasks.status_id'),
                'executor_name' => User::select('name')
                    ->whereColumn('id', 'tasks.assigned_to_id')
            ])->paginate(10);

//        dump($data);
//        exit;

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
        $usersList = [];
        $labels = Label::all();
        foreach (User::select('id', 'name')->get()->toArray() as $user) {
            $usersList[$user['id']] = $user['name'];
        }
        $taskStatusesList = [];
        foreach (TaskStatus::select('id', 'name')->get()->toArray() as $status) {
            $taskStatusesList[$status['id']] = $status['name'];
        }

        return view('taskPages.add', compact('task', 'usersList', 'taskStatusesList', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tasks',
            'description' => '',
            'status_id' => 'required',
            'created_by_id' => '',
            'assigned_to_id' => '',
            'labels' => '',
        ], $messages = [
            'unique' => __('messages.taskUnique'),
        ]);

        if ($validator->fails()) {
            return redirect(route('tasks.create'))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            $newTask = new Task();
            $newTask->name = $request->name;
            $newTask->description = $request->description;
            $newTask->status_id = $request->status_id;
            $newTask->assigned_to_id = $request->assigned_to_id;
            $newTask->created_by_id = Auth::user()->id;
            $newTask->timestamps = Carbon::now();
            $newTask->save();

            // были ли добавлены метки
            if ($request->labels !== null) {
                foreach ($request->labels as $labelId) {
                    $newTaskLabel = new LabelTask();
                    $newTaskLabel->task_id = $newTask->id;
                    $newTaskLabel->label_id = $labelId;
                    $newTaskLabel->timestamps = Carbon::now();
                    $newTaskLabel->save();
                }
            }

            DB::commit();
            /* Transaction successful. */
            flash(__('messages.taskSuccessAdded'))->success();
            return redirect(route('tasks.index'));
        } catch (\Exception $e) {
            DB::rollback();
            /* Transaction failed. */
            flash('Something went wrong')->error();
            return redirect(route('tasks.create'));
        }
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

        // дополнительные данные типа label_name можно прикрепить комбинированным сложным запросом,
        // либо во view в цикле через метод getLabelName определенный в модели LabelTask
        $labelsData =  LabelTask::where('task_id', '=', $task->id)->addSelect([
            'label_name' => Label::select('name')
                ->whereColumn('id', 'label_tasks.label_id')
        ])->get();

        //$labelsData = LabelTask::where('task_id', '=', $task->id)->get();
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
        $usersList = [];
        $taskStatusesList = [];
        foreach (User::select('id', 'name')->get()->toArray() as $user) {
            $usersList[$user['id']] = $user['name'];
        }
        foreach (TaskStatus::select('id', 'name')->get()->toArray() as $status) {
            $taskStatusesList[$status['id']] = $status['name'];
        }

        return view('taskPages.edit', compact('task', 'usersList', 'taskStatusesList', 'labels', 'selectedLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Task $task)
    {
        $newTask = Task::findOrFail($task->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => '',
            'status_id' => 'required',
            'updated_at' => Carbon::now(),
            'assigned_to_id' => '',
            'created_by_id' => '',
            'labels' => ''
        ], $messages = [
        'required' => __('messages.taskRequired'),
        'unique' => __('messages.taskUnique'),
            ]);

        if ($validator->fails()) {
            return redirect(route('tasks.create'))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // удаляем старые метки
            LabelTask::where('task_id', '=', $task->id)->delete();

            // если есть метки то добавляем их
            if ($request->labels !== null) {
                // добавляем новые метки
                foreach ($request->labels as $labelId) {
                    $newLabel = new LabelTask();
                    $newLabel->task_id = $task->id;
                    $newLabel->label_id = $labelId;
                    $newLabel->save();
                }
            }

            // обновляем задачу
            $newTask->name = $request->name;
            $newTask->description = $request->description;
            $newTask->created_by_id = $request->created_by_id;
            $newTask->assigned_to_id = $request->assigned_to_id;
            $newTask->status_id = $request->status_id;
            $newTask->updated_at = Carbon::now();
            $newTask->save();

            DB::commit();
            /* Transaction successful. */
            flash(__('messages.taskSuccessUpdated'))->success();
            return redirect(route('tasks.index'));
        } catch (\Exception $e) {
            DB::rollback();
            /* Transaction failed. */
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
        $authorizedUserId = (int) Auth::user()->id;
        if ($taskAuthorId !== $authorizedUserId) {
            flash(__('messages.taskUnsuccessDelete'))->error();
            return redirect(route('tasks.index'));
        }

        // проверяем есть ли у задачи метки
        if (LabelTask::where('task_id', '=', $task->id)->count() > 0) { // если меток больше чем 0
            LabelTask::where('task_id', '=', $task->id)->delete();
        }

        flash(__('messages.taskSuccessDeleted'))->success();
        $task->delete();
        return redirect(route('tasks.index'));
    }
}
