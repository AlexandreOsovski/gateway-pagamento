<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\MovementService;
use Illuminate\Http\Request;

class MovementDetail extends Controller
{
    private $movementService;
    public function __construct(MovementService $movementService)
    {
        $this->movementService = $movementService;
    }

    public function index(Request $request){
        $uuid = $request->query(str_replace('base64:', '', env('APP_KEY')));
        return view("dashboard.movement-details", ['movement_detail' => $this->movementService->findByUuid($uuid)]);
    }
}
