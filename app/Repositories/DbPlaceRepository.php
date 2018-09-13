<?php

namespace App\Repositories;

use App\Interfaces\PlaceRepositoryInterface;
use App\Place;

class DbPlaceRepository implements PlaceRepositoryInterface
{
    /**
     * @var Place
     */
    protected $place;

    /**
     * DbPlaceRepository constructor.
     * @param Place $place
     */
    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Return all places
     *
     * @return mixed
     */
    public function all()
    {
        return $this->place->all();
    }

    /**
     * Create a new place
     *
     * @param array $place
     * @return mixed
     */
    public function create(array $place)
    {
        return $this->place->create($place);
    }

    /**
     * Find place by id
     *
     * @param string $id
     * @return mixed
     */
    public function find(string $id)
    {
        return $this->place->find($id);
    }

    /**
     * Update place with id
     *
     * @param string $id
     * @param array $place
     * @return mixed
     */
    public function update(string $id, array $place)
    {
        $placeToUpdate = $this->place->find($id);
        $placeToUpdate->update($place);
        return $placeToUpdate->fresh();
    }

    /**
     * Delete place with id
     *
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->find($id)->delete();
    }
}