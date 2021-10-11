<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\LabelTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabelController extends Controller
{
    public function __construct()
    {
        // Метод authorizeResource принимает имя класса модели в качестве своего первого аргумента и
        // имя параметра маршрута / запроса, который будет содержать идентификатор модели, в качестве второго аргумента
        $this->authorizeResource(Label::class, 'label');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::paginate(5);
        return view('labelPages.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $label = new Label();
        return view('labelPages.add', compact('label'));
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
            'name' => 'required|unique:labels',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return redirect(route('labels.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $newLabel = new Label();
        $newLabel->name = $request->name;
        $newLabel->description = $request->description;
        $newLabel->timestamps = Carbon::now();
        $newLabel->save();
        flash(__('messages.labelSuccesAdded'))->success();
        return redirect(route('labels.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('labelPages.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $newLabel = Label::findOrFail($label->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:labels',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return redirect(route('labels.create'))
                ->withErrors($validator)
                ->withInput();
        }
        $newLabel->name = $request->name;
        $newLabel->description = $request->description;
        $newLabel->updated_at = Carbon::now();
        $newLabel->save();
        flash(__('messages.labelSuccessUpdated'))->success();
        return redirect(route('labels.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        if (count(LabelTask::where('label_id', '=', $label->id)->get()) > 0) {
            flash(__('messages.labelUnsuccessDeleted'))->error();
            return redirect(route('labels.index'));
        }
        $label->delete();
        flash(__('messages.labelSuccesDeleted'))->success();
        return redirect(route('labels.index'));
    }
}
