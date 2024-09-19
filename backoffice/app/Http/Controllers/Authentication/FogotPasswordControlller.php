<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Illuminate\Http\Request;

use App\Http\Controllers\UtilsController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\ClientRecoveryCode;

class FogotPasswordControlller extends Controller
{
    private $serviceClient;
    private $clientRecoveryCode;
    private $utils;
    public function __construct(ClientService $serviceClient)
    {
        $this->serviceClient = $serviceClient;
        $this->clientRecoveryCode = new ClientRecoveryCode();
        $this->utils = new UtilsController();
    }

    public function index(Request $request)
    {
        if($request->query('token')){
            return view('authentication.recoveryPassword', ['eyJzdWIiOiIxM' => $request->query('token')]);
        }else{
            return view('dashboard.get');
        }
    }


    public function recoveryPassword(Request $request)
    {
        $getUrlToken = $request->F2QT4fwpMe;
        $token = JWT::decode($getUrlToken, new Key(env('APP_JWT_KEY'), 'HS256'));

        if($request->new_password != $request->repete_new_password){
            toastr('As senhas nao sao iguais', 'error');
            return redirect()->back();
        }

        $clientEmail = $this->serviceClient->findByEmail($token->email);

        if($clientEmail){

            $getStatusCode = $this->clientRecoveryCode::where('client_id', $clientEmail->id)->where('code', $token->code)->where('status', 'new')->first();

            if($getStatusCode){

                $updateStatusCode = $getStatusCode;
                $updateStatusCode->status = 'used';
                $updateStatusCode->update();

                $result = $this->serviceClient->update([
                    'password' => $request->new_password,
                ], $getStatusCode->client_id);

                if($result){
                    toastr('Senha alterada com sucesso!', 'success');
                    return redirect()->route('dashboard.get');
                }else{
                    toastr('Houve um erro ao alterar a senha!', 'error');
                    return redirect()->route('dashboard.get');
                }
            }
            toastr('Token nao encontrado', 'error');
            return redirect()->route('dashboard.get');
        }
        toastr('Cliente nao encontrado', 'error');
        return redirect()->route('dashboard.get');
    }

    public function sendCodeToRecoveryPassword(Request $request)
    {

        $codeGenerate = $this->utils->generateCodeTo2FA();
        $result = $this->serviceClient->findByEmail($request->email_recovery);

            if($result)
            {
                $getDataRecoveryData = $this->clientRecoveryCode::where('client_id', $result->id)->first();
                if($getDataRecoveryData)
                {
                    $updateRecoveryData = $getDataRecoveryData;
                    $updateRecoveryData->code = $codeGenerate;
                    $updateRecoveryData->status = 'new';
                    $updateRecoveryData->update();

                }else{
                    $createRecoveryData = $this->clientRecoveryCode;
                    $createRecoveryData->client_id = $result->id;
                    $createRecoveryData->code = $codeGenerate;
                    $createRecoveryData->status = 'new';
                    $createRecoveryData->save();
                }

                $code = [
                    'code' => $codeGenerate,
                    'email' => $result->email
                ];

                $this->utils::sendEmailRecovery(env('APP_URL') . '/recovery-password?token=' . JWT::encode($code, env('APP_JWT_KEY'), 'HS256') , $result->email);

                toastr('Verifique a caixa de entrada do seu email', 'success');
                return view('dashboard.get');
            }else{
                toastr('Verifique a caixa de entrada do seu email', 'success');
                return view('dashboard.get');
            }


    }
}
