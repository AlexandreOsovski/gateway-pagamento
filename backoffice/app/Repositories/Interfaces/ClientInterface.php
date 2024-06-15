<?php

namespace App\Repositories\Interfaces;

use App\Models\ClientModel;

/**
 * Interface ClientInterface
 *
 * This interface defines methods for CRUD operations related to clients.
 */
interface ClientInterface
{
    /**
     * Get a client based on ID.
     *
     * @param string $id The ID of the client to retrieve.
     * @return ClientModel The found client.
     */
    public function get(string $id): ?ClientModel;

    /**
     * Create a new client.
     *
     * @param ClientModel $client The object containing the data of the client to be created.
     * @return ClientModel The newly created client.
     */
    public function create(ClientModel $client): ClientModel;

    /**
     * Update an existing client based on ID.
     *
     * @param ClientModel $client The object containing the new data of the client.
     * @param string $id The ID of the client to be updated.
     * @return ClientModel The updated client.
     */
    public function update(array $client, string $id): bool;

    /**
     * Delete a client based on ID.
     *
     * @param string $id The ID of the client to be deleted.
     * @return bool
     */
    public function delete(string $id): bool;

    /**
     * Find a client based on ID.
     *
     * @param string $id The ID of the client to be found.
     * @return ClientModel|null The found client or null if not found.
     */
    public function find(string $id): ?ClientModel;

    public function verifyOldPassword(string $oldPassword, int $userId): bool;
}