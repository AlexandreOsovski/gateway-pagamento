<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;

use Illuminate\{
    Support\Facades\Validator,
    Http\Request
};
use App\Models\ClientModel;

class RegisterController extends Controller
{

    private $client;

    public function __construct(ClientModel $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        return view("authentication/register");
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3',
            'email' => 'required|string',
            'password' => 'required|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string',
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.min' => 'O campo nome deve ter pelo menos 3 caracteres.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

            $errors = $validator->errors()->all();
            $errorMessage = implode('<br>', $errors);

            toastr($errorMessage, 'error', 'Erro');
            return redirect()->back();
        }

        if (!$request->has('terms_use')) {
            toastr('Você precisa aceitar os termos de uso', 'error', 'Erro');
            return redirect()->back();
        }

        $client = $this->client;
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->password = $request->input('password');
        $client->document_number = $request->input('document_number');
        $client->document_type = $request->input('document_type');
        $client->status = 'active';
        $client->save();

        if ($client) {
            toastr('Cadastro criado com sucesso', 'success', 'Sucesso');
            return redirect()->route('login.get');
        } else {
            toastr('Houve um erro ao realizar o cadastro, tente novamente', 'error', 'Erro');
            return redirect()->back();
        }
    }
}
