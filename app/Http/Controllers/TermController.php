<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Http\Requests\StoreTermRequest;
use App\Http\Requests\UpdateTermRequest;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms_and_conditions = Term::latest()->get();
        return view('dashboard.term.index', compact('terms_and_conditions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $terms_and_condition = null;
        return view('dashboard.term.form', compact('terms_and_condition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermRequest $request)
    {
        Term::create($request->all());

        return redirect('/terms-and-conditions')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $terms_and_condition = Term::findOrFail($id);
        return view('dashboard.term.show', compact('terms_and_condition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $terms_and_condition = Term::findOrFail($id);
        return view('dashboard.term.form', compact('terms_and_condition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermRequest  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermRequest $request, $id)
    {
        $terms_and_condition = Term::findOrFail($id);
        $terms_and_condition->fill($request->all());
        $terms_and_condition->save();

        return redirect('/terms-and-conditions')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $terms_and_condition = Term::findOrFail($id);
        $terms_and_condition->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }
}
