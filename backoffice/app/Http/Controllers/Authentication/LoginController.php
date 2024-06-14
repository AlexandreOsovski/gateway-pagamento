<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\ClientModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private readonly ClientModel $client;
    public function __construct()
    {
        $this->client = new ClientModel();
    }
    public function index()
    {
        return view("authentication/login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (empty($credentials['email']) || empty($credentials['password'])) {
            toastr("Digite o email e a senha corretamente", 'warning', 'Aviso');
            return redirect()->route('login.get');
        }

        $client = $this->client::where('email', $credentials['email'])->first();

        if (!$client) {
            toastr('Email não encontrado.', 'error', 'Erro');
            return redirect()->back();
        }

        if ($client->status !== 'active') {
            toastr('Usuário inativado, entre em contato com a horiizom.', 'error', 'Erro');
            return redirect()->back();
        }

        if (!password_verify($credentials['password'], $client->password)) {

            toastr('Senha incorreta.', 'error', 'Erro');
            return redirect()->back();
        }

        if (Auth::guard('client')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return redirect()->route('dashboard.get');
        }

        toastr('Houve um erro ao tentar realizar o login', 'error', 'Erro');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        Auth::guard('web')->logout();

        toastr('Você saiu com sucesso. Até logo!', 'success');

        return redirect()->route('login.get');
    }
}
