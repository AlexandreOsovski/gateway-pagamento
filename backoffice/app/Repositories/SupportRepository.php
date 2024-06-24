<?php
namespace App\Repositories;
use App\Models\SupportModel;
use App\Repositories\Interfaces\SupportInterface;
use Illuminate\Database\Eloquent\Model;

class SupportRepository implements SupportInterface{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function create(SupportModel $support): SupportModel
    {
        return $this->model->create($support->toArray());
    }
}
