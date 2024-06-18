<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\{
    KeysApiService,
    NotificationService,
};

class KeysApiController extends Controller
{

    private $keysApiService;
    private $notificationService;
    public function __construct(KeysApiService $keysApiService, NotificationService $notificationService)
    {
        $this->keysApiService = $keysApiService;
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        return view("dashboard.api", ["data" => $this->keysApiService->getAll(Auth::guard("client")->user()->id)]);
    }

    public function store(Request $request)
    {
        $client_id = Auth::guard('client')->user()->id;
        $result = $this->keysApiService->create($request->all());
        if ($result) {

            $this->notificationService->create($client_id, 'fa-solid fa-key', 'Chave de API criada com sucesso', "Foi criada uma nova chave de API com o título: $request->title");


            toastr('Chave de Api cadastrada com sucesso', 'success', 'Sucesso');
            return redirect()->route('keysapi.get');
        } else {
            toastr('Houve um erro ao tentar cadastrar a chave da api', 'error', 'Erro');
            return redirect()->route('keysapi.get');
        }
    }
}
