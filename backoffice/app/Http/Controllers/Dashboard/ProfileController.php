<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\ClientService;
use App\Models\ClientModel;

class ProfileController extends Controller
{
    private $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return view("dashboard.profile");
    }

    public function update(Request $request)
    {
        $result = $this->clientService->update($request->all(), Auth::guard("client")->user()->id);
        if ($result) {
            toastr("Dado alterado com sucesso", "success");
            return redirect()->route("profile.get");
        } else {
            toastr("Erro ao tentar alterar os dados", "error");
            return redirect()->route("profile.get");
        }
    }
}
