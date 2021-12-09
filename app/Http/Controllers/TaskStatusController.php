<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class TaskStatusController extends Controller
{
    /**
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
     * @return View
     */
    public function index()
    {
        $taskStatus = TaskStatus::paginate(5);
        return view('taskStatus.index', compact('taskStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('taskStatus.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
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
     * Show the form for editing the specified resource.
     *
     * @param TaskStatus $taskStatus
     * @return View
     */
    public function edit(TaskStatus $taskStatus): View
    {
        return view('taskStatus.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TaskStatus $taskStatus
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $this->validate($request, ['name' => 'required|unique:task_statuses'], $messages = [
            'unique' => __('messages.statusUnique'),
        ]);
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('messages.statusSuccessUpdated'))->success();
        return redirect(route('task_statuses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TaskStatus $taskStatus
     * @return RedirectResponse|Redirector
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
