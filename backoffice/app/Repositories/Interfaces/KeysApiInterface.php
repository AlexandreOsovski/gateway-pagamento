<?php

namespace App\Repositories\Interfaces;

use App\Models\KeysApiModel;

/**
 * Interface KeyApiInterface
 *
 * This interface defines methods for interacting with keys APIs in the system.
 */
interface KeysApiInterface
{
    /**
     * Get a key API based on its ID.
     *
     * @param string $id The ID of the key API to retrieve.
     * @return KeysApiModel|null The found key API or null if not found.
     */
    public function get(string $id): ?KeysApiModel;


    /**
     * Get all key APIs.
     *
     * @return array all key APIs.
     */
    public function getAll(int $userId): array;

    public function getLastFourKeysApi(int $userId): array;

    /**
     * Create a new key API.
     *
     * @param KeysApiModel $api The object containing the data of the key API to be created.
     * @return KeysApiModel The newly created key API.
     */
    public function create(KeysApiModel $api): KeysApiModel;

    /**
     * Delete a key API based on its ID.
     *
     * @param string $id The ID of the key API to be deleted.
     * @return bool True if the key API was successfully deleted, false otherwise.

     */
    public function delete(string $id): bool;

    /**
     * Find a key API based on its ID.
     *
     * @param string $id The ID of the key API to be found.
     * @return KeysApiModel|null The found key API or null if not found.
     */
    public function find(string $id): ?KeysApiModel;

    public function getByAppIdAndAppKey(string $appId, string $appKey): array;
}
