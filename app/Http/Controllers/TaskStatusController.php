<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TaskStatusController extends Controller
{
    /**
     *
     * @return void
     */
    public function __construct()
    {
        // Метод authorizeResource принимает имя класса модели в качестве своего первого аргумента и
        // имя параметра маршрута / запроса, который будет содержать идентификатор модели, в качестве второго аргумента
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatus = TaskStatus::paginate(5);
        // возможно добавить сортировку надо
        return view('taskStatusePages.index', compact('taskStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus;
        return view('taskStatusePages.add', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:task_statuses'
        ]);

        if ($validator->fails()) {
            return redirect(route('task_statuses.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $newTaskStatus = new TaskStatus();
        $newTaskStatus->name = $request->name;
        $newTaskStatus->timestamps = Carbon::now();
        $newTaskStatus->save();
        flash(__('messages.statusSuccessAdded'))->success();
        return redirect(route('task_statuses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        // статусы показывать не будем, а так же запретим всем в политиках
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        $taskStatus = TaskStatus::findOrFail($taskStatus->id);
        return view('taskStatusePages.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $newStatus = TaskStatus::findOrFail($taskStatus->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:task_statuses'
        ]);

        if ($validator->fails()) {
            return redirect(route('task_statuses.create'))
                ->withErrors($validator)
                ->withInput();
        }
        $newStatus->name = $request->name;
        $newStatus->updated_at = Carbon::now();
        $newStatus->save();
        flash(__('messages.statusSuccessUpdated'))->success();
        return redirect(route('task_statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        $allTaskStatusesInUsage = Task::where('status_id', $taskStatus->id)->get()->toArray();
        if ($allTaskStatusesInUsage === []) {
            $taskStatus->delete();
            flash(__('messages.statusSuccessDeleted'))->success();
            return redirect()->route('task_statuses.index');
        }
        flash(__('messages.statusUnSuccessDeleted'))->error();
        return redirect()->route('task_statuses.index');
    }
}
