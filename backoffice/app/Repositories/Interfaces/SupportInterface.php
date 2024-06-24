<?php

namespace App\Repositories\Interfaces;
use App\Models\SupportModel;

interface SupportInterface{
    public function create(SupportModel $supportModel): SupportModel;

}
