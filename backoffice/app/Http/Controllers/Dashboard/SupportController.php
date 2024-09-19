<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SupportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SupportController extends Controller
{
    private $supportService;
    public function __construct(SupportService $support)
    {
        $this->supportService = $support;
    }

    public function index()
    {
        return view('dashboard.support');
    }

    public function store(Request $request)
    {

        $user = Auth::guard('client')->user();
        $result = $this->supportService->create($user->id, $user->email, $request->phone, $request->title, $request->body);

        if($result){
            toastr('Suporte solicitado com sucesso, aguarde contato pelo e-mail.', 'success');
            return redirect()->route('dashboard.get');
        }else{
            toastr('Houve um erro ao solicitar o suporte.', 'success');
            return redirect()->route('dashboard.get');
        }
    }
}
