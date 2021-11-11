<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $taskStatus = TaskStatus::paginate(5);
        return view('taskStatusePages.index', compact('taskStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('taskStatusePages.add', compact('taskStatus'));
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
        $data = $this->validate($request, ['name' => 'required|unique:task_statuses'], $messages = [
            'unique' => __('messages.statusUnique'),
        ]);
        $newTaskStatus = new TaskStatus();
        $newTaskStatus->fill($data);
        $newTaskStatus->save();
        flash(__('messages.statusSuccessAdded'))->success();
        return redirect(route('task_statuses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(TaskStatus $taskStatus)
    {
        return redirect(route('task_statuses.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Contracts\View\View
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $newStatus = TaskStatus::findOrFail($taskStatus->id);
        $data = $this->validate($request, ['name' => 'required|unique:task_statuses'], $messages = [
            'unique' => __('messages.statusUnique'),
        ]);
        $newStatus->fill($data);
        $newStatus->save();
        flash(__('messages.statusSuccessUpdated'))->success();
        return redirect(route('task_statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(TaskStatus $taskStatus)
    {
        if (count($taskStatus->tasks) === 0) {
            $taskStatus->delete();
            flash(__('messages.statusSuccessDeleted'))->success();
            return redirect()->route('task_statuses.index');
        }
        flash(__('messages.statusUnSuccessDeleted'))->error();
        return redirect()->route('task_statuses.index');
    }
}
