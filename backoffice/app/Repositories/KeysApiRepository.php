<?php

namespace App\Repositories;

use App\Repositories\Interfaces\KeysApiInterface;
use App\Models\KeysApiModel;
use Illuminate\Database\Eloquent\Model;

class KeysApiRepository implements KeysApiInterface
{

    /**
     * The model instance.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create a new ClientRepository instance.
     *
     * @param Model $model The model instance to be used.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a client based on ID.
     *
     * @param string $id The ID of the client to retrieve.
     * @return KeysApiModel|null The found client or null if not found.
     */
    public function get(string $id): ?KeysApiModel
    {
        return $this->model->find($id);
    }

    /**
     * Get all keys APIs associated with a specific user.
     *
     * @param int $userId The ID of the user whose keys APIs are to be fetched.
     * @return array Array of keys APIs associated with the user.
     */
    public function getAll(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Get the last four keys APIs created by a specific user.
     *
     * @param int $userId The ID of the user whose last four keys APIs are to be fetched.
     * @return array Array of the last four keys APIs created by the user.
     */
    public function getLastFourKeysApi(int $userId): array
    {
        return $this->model
            ->where('client_id', $userId)
            ->latest()
            ->take(4)
            ->get()
            ->toArray();
    }


    /**
     * Create a new client.
     *
     * @param KeysApiModel $keyApi The client model instance to be created.
     * @return KeysApiModel The created client model.
     */
    public function create(KeysApiModel $keyApi): KeysApiModel
    {
        $this->model->create($keyApi->toArray());
        return $keyApi;
    }

    /**
     * Update an existing client based on ID.
     *
     * @param KeysApiModel $keyApi The updated client model instance.
     * @param string $id The ID of the client to be updated.
     * @return KeysApiModel|null The updated client model or null if not found.
     */
    public function update(KeysApiModel $keyApi, string $id): ?KeysApiModel
    {
        $existingClient = $this->model->find($id);

        if ($existingClient) {
            return $existingClient->update($keyApi->toArray());
        }

        return null;
    }

    /**
     * Delete a client based on ID.
     *
     * @param string $id The ID of the client to be deleted.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(string $id): bool
    {
        $keyApi = $this->model->find($id);

        if ($keyApi) {
            return $keyApi->delete();
        }

        return false;
    }

    /**
     * Find a client based on ID.
     *
     * @param string $id The ID of the client to be found.
     * @return KeysApiModel|null The found client or null if not found.
     */
    public function find(string $id): ?KeysApiModel
    {
        return $this->model->find($id);
    }
}
