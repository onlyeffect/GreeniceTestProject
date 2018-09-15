<?php

namespace App\Http\Controllers;

use App\DistanceManager;
use App\Http\Requests\StorePlace;
use App\Http\Requests\UpdatePlace;
use App\Place;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::all()->sortBy('address');

        return view('places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlace $request)
    {
        $validated = $request->validated();

        $newPlace = Place::create([
            'address' => $validated['address'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
        ]);

        return $newPlace->address;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        return view('places.update', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Place $place, UpdatePlace $request)
    {
        $validated = $request->validated();

        $place->update([
            'address' => $validated['address'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
        ]);

        return $place->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        if ($place->delete()) {
            return redirect('/')->with('success', 'Place Deleted');
        } else {
            return redirect('/')->with('error', 'Something went wrong');
        }
    }

    public function getDistances(Place $place, DistanceManager $distanceManager)
    {
        $otherPlaces = Place::getAllExcept($place);

        return $distanceManager->getDistanceToAll($place, $otherPlaces)->sort();
    }
}
