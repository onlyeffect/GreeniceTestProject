<?php

namespace App\Interfaces;

interface PlaceRepositoryInterface
{
    /**
     * Return all placess
     *
     * @return mixed
     */
    public function all();

    /**
     * Create a new place
     *
     * @param array $places
     * @return mixed
     */
    public function create(array $place);

    /**
     * Find place by id
     *
     * @param string $id
     * @return mixed
     */
    public function find(string $id);

    /**
     * Update place with id
     *
     * @param string $id
     * @param array $places
     * @return mixed
     */
    public function update(string $id, array $place);

    /**
     * Delete place with id
     *
     * @param string $id
     * @return mixed
     */
    public function delete(string $id);
}
