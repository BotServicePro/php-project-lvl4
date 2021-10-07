<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $tasks = Task::paginate(55);

        foreach ($tasks as $task) {
            //dump($task->getStatusData->name);
            $result[] = array_merge($task->toArray(), [
                'task_author_name' => $task->getAuthorData->name,
                'status_name' => $task->getStatusData ? $task->getStatusData->name : null,
                'executor_name' => $task->getExecutorData ? $task->getExecutorData->name : null
            ]);
        }

        return view('taskPages.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        $usersList = [];
        foreach (User::select('id', 'name')->get()->toArray() as $user) {
            $usersList[$user['id']] = $user['name'];
        }
        $taskStatusesList = [];
        foreach (TaskStatus::select('id', 'name')->get()->toArray() as $status) {
            $taskStatusesList[$status['id']] = $status['name'];
        }
        return view('taskPages.add', compact('task', 'usersList', 'taskStatusesList'));
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
            'name' => 'required|unique:tasks',
            'status_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('tasks.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $newTask = new Task();
        $newTask->name = $request->name;
        $newTask->description = $request->description;
        $newTask->status_id = $request->status_id;
        $newTask->assigned_to_id = $request->assigned_to_id;
        $newTask->created_by_id = Auth::user()->id;
//        dump($newTask);
//        exit;
        $newTask->save();
        flash(__('messages.taskSuccessAdded'))->success();
        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $task = Task::findOrFail($task->id);
        return view('taskPages.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
