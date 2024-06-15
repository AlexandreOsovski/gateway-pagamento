<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\KeysApiService;
use Illuminate\Support\Facades\Auth;

class KeysApiController extends Controller
{

    private $keysApiService;
    public function __construct(KeysApiService $keysApiService)
    {
        $this->keysApiService = $keysApiService;
    }

    public function index()
    {
        return view("dashboard.api", ["data" => $this->keysApiService->getAll(Auth::guard("client")->user()->id)]);
    }

    public function store(Request $request)
    {
        $result = $this->keysApiService->create($request->all());
        if ($result) {
            toastr('Chave de Api cadastrada com sucesso', 'success', 'Sucesso');
            return redirect()->back();
        } else {
            toastr('Houve um erro ao tentar cadastrar a chave da api', 'error', 'Erro');
            return redirect()->back();
        }
    }
}
