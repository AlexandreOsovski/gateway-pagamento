<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

class UtilsController extends Controller
{
    /**
     * Send email with PIX payment details
     *
     * @param array $data
     * @param string $email
     * @return void
     */
    public static function sendEmailPix($data = [], $email)
    {
        Mail::send(
            'emails.pix',
            ['value' => $data['value'], 'type' => $data['type'], 'name' => $data['name'], 'status' => $data['status']],
            function ($message) use ($email) {
                $message->to($email)->subject('Detalhes do Pagamento');
            }
        );
    }

    /**
     * Send email with recovery account
     *
     * @param string $url
     * @param string $email
     * @return void
     */
    public static function sendEmailRecovery($url, $email)
    {
        Mail::send('emails.recovery', ['url' => $url], function ($message) use ($email) {
            $message->to($email)->subject('Recuperação de Conta');
        });
    }

    /**
     * Send email with withdrawal confirmation
     *
     * @param float $amount
     * @param string $type
     * @param string $url
     * @param string $email
     * @return void
     */
    public static function sendEmailWithdrawalConfirm($amount, $type, $url, $email)
    {
        Mail::send('emails.withdrawal', ['amount' => $amount, 'type' => $type, 'url' => $url], function ($message) use ($email) {
            $message->to($email)->subject('Confirmação de Saque');
        });
    }

    /**
     * Send email with verification code
     *
     * @param string $token
     * @param string $email
     * @return void
     */
    public static function sendEmailCode(string $token, string $email)
    {
        Mail::send('emails.code', ['token' => $token ], function ($message) use ($email) {
            $message->to($email)->subject('Código de Verificação');
        });
    }

    /**
     * Send email with account confirmation
     *
     * @param string $name
     * @param string $email
     * @return void
     */
    public static function sendEmailConfirmation($name, $email)
    {
        Mail::send('emails.confirmation', ['name' => $name], function ($message) use ($email) {
            $message->to($email)->subject('Account Confirmation');
        });
    }

    public function generateCodeTo2FA():string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 7; $i++) {
            $randomString .= $characters[mt_rand(0, $max)];
        }
        return $randomString;
    }

}
