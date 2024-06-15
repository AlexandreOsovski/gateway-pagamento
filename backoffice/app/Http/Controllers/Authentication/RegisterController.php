<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ClientService;

class RegisterController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index()
    {
        return view("authentication.register");
    }

    public function register(Request $request)
    {

        $result = $this->validateData($request->all());
        if (!$result) {
            return redirect()->back();
        }

        if (!$request->has('terms_use')) {
            toastr('Você precisa aceitar os termos de uso', 'error', 'Erro');
            return redirect()->back();
        }

        $result = $this->clientService->create($request->all());

        if ($result) {
            toastr('Cadastro criado com sucesso', 'success', 'Sucesso');
            return redirect()->route('login.get');
        } else {
            toastr('Houve um erro ao realizar o cadastro, tente novamente', 'error', 'Erro');
            return redirect()->back();
        }
    }

    /**
     * getErrors function
     *
     * @param object $data
     * @return boolean
     */
    private function validateData($dataObject): bool
    {
        $validator = Validator::make($dataObject, [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|unique:clients,email',
            'password' => 'required|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string|unique:clients,document_number',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.min' => 'O campo nome deve ter pelo menos 3 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.string' => 'O campo email deve ser uma string.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está sendo usado em outra conta.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'document_type.required' => 'O campo tipo de documento é obrigatório.',
            'document_type.string' => 'O campo tipo de documento deve ser uma string.',
            'document_number.required' => 'O campo número do documento é obrigatório.',
            'document_number.string' => 'O campo número do documento deve ser uma string.',
            'document_number.unique' => 'Este número de documento já está sendo usado em outra conta.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $value) {
                toastr($value, 'error', 'Erro');
            }
            return false;
        }
        return true;
    }
}
