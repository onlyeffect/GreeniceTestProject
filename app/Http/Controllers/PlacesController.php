<?php

namespace App\Http\Controllers;

use App\DistanceManager;
use App\Interfaces\PlaceRepositoryInterface;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * @var PlaceRepositoryInterface
     */
    protected $places;

    /**
     * @var DistanceManager
     */
    protected $distanceManager;

    /**
     * PlacesController constructor.
     * @param UserRepository $repository
     */
    public function __construct(PlaceRepositoryInterface $places, DistanceManager $distanceManager)
    {
        $this->places = $places;
        $this->distanceManager = $distanceManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = $this->places->all()->sortBy('address');

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
    public function store(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'lat' => 'required',
            'lat' => 'required',
        ]);

        $newPlace = $this->places->create([
            'address' => $request['address'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ]);

        return $newPlace->address;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = $this->places->find($id);

        return view('places.update', compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'address' => 'required',
            'lat' => 'required',
            'lat' => 'required',
        ]);

        $newPlace = $this->places->update($id, [
            'address' => $request['address'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ]);

        return $newPlace->address;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->places->delete($id)) {
            return redirect('/')->with('success', 'Place Deleted');
        } else {
            return redirect('/')->with('error', 'Something went wrong');
        }
    }

    public function getDistances($id)
    {
        $selectedPlace = $this->places->find($id);

        $allPlaces = $this->places->all()->toArray();

        return $this->distanceManager->getDistanceToAll($selectedPlace, $allPlaces)->sort();
    }
}
