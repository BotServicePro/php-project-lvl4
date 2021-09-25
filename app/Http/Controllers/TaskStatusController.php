<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TaskStatusController extends Controller
{
    /**
     * Создать экземпляр контроллера.
     *
     * @return void
     */
    public function __construct()
    {
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
        return view('taskStatusePages.index', compact('taskStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', TaskStatus::class);
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
        //$this->authorize('store', TaskStatus::class);
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
        $newTaskStatus->save();
        flash('Статус успешно создан')->success();
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
        //
        //TaskStatus::findOrFail($taskStatus->id);
        //dump($taskStatus);
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        //$this->authorize('edit', TaskStatus::class);
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
        //$this->authorize('update', $taskStatus);

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
        $newStatus->save();
        flash('Статус успешно изменён')->success();
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

    }
}
