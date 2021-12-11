<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $labels = Label::paginate(5);
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $label = new Label();
        return view('label.create', compact('label'));
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
        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
            'description' => '',
        ], [
            'unique' => __('messages.labelUnique')
        ]);
        $newLabel = new Label();
        $newLabel->fill($data);
        $newLabel->save();
        flash(__('messages.labelSuccessAdded'))->success();
        return redirect(route('labels.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return View
     */
    public function edit(Label $label): View
    {
        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Label $label
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Label $label)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
            'description' => 'nullable',
            ], [
            'unique' => __('messages.labelUnique'),
        ]);
        $label->fill($data);
        $label->save();
        flash(__('messages.labelSuccessUpdated'))->success();
        return redirect(route('labels.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Label $label
     * @return RedirectResponse|Redirector
     */
    public function destroy(Label $label)
    {
        if ($label->getLabelDataInUsage()->exists()) {
            flash(__('messages.labelUnsuccessDeleted'))->error();
            return redirect(route('labels.index'));
        }

        $label->delete();
        flash(__('messages.labelSuccessDeleted'))->success();
        return redirect(route('labels.index'));
    }
}
