<?php

namespace App\Http\Controllers;

use App\Models\Neighborhood;
use App\Http\Requests\StoreNeighborhoodRequest;
use App\Http\Requests\UpdateNeighborhoodRequest;
use Illuminate\Support\Str;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $neighborhoods = Neighborhood::latest()->get();
        return view('dashboard.neighborhood.index', compact('neighborhoods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $neighborhood = null;
        return view('dashboard.neighborhood.form', compact('neighborhood'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNeighborhoodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNeighborhoodRequest $request)
    {
        $neighborhood_name = get_neighborhood_name_multi_language($request->lat, $request->lng);
        $neighborhood_slug = Str::slug($neighborhood_name['en']);

        //check if neighborhood already exists
        $neighborhood = Neighborhood::where('slug', $neighborhood_slug)->first();
        if ($neighborhood) {
            return redirect()->route('neighborhoods.index')->withErrors(__('dashboard.neighborhood_already_exists'));
        }

        Neighborhood::create(array_merge($request->only('lat', 'lng', 'status'), ['name' => $neighborhood_name, 'slug' => $neighborhood_slug]));

        return redirect('/neighborhoods')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function show(Neighborhood $neighborhood)
    {
        return view('dashboard.neighborhood.show', compact('neighborhood'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function edit(Neighborhood $neighborhood)
    {
        return view('dashboard.neighborhood.form', compact('neighborhood'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNeighborhoodRequest  $request
     * @param  \App\Models\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNeighborhoodRequest $request, $id)
    {
        $neighborhood_name = get_neighborhood_name_multi_language($request->lat, $request->lng);
        $neighborhood_slug = Str::slug($neighborhood_name['en']);

        //check if neighborhood already exists
        $neighborhood = Neighborhood::where('id', '!=', $id)->where('slug', $neighborhood_slug)->first();
        if ($neighborhood) {
            return redirect()->route('neighborhoods.index')->withErrors(__('dashboard.neighborhood_already_exists'));
        }

        $neighborhood = Neighborhood::find($id);
        $neighborhood->update(array_merge($request->only('lat', 'lng', 'status'), ['name' => $neighborhood_name, 'slug' => $neighborhood_slug]));

        return redirect('/neighborhoods')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Neighborhood $neighborhood)
    {
        $neighborhood->slug = $neighborhood->slug . '-deleted';
        $neighborhood->save();

        $neighborhood->delete();
        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }
}
