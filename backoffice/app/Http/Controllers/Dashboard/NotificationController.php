<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $service;

    public function __construct(NotificationService $notificationService)
    {
        $this->service = $notificationService;
    }

    public function index()
    {

        $client_id = Auth::guard('client')->user()->id;

        return view(
            'dashboard.notifications',
            [
                'notification' => $this->service->getNotificationByUserId($client_id)
            ]
        );
    }

    public function readNotification(Request $request)
    {
        // dd($request);
        $client_id = Auth::guard('client')->user()->id;
        $this->service->readNotification($request->notification_id, $client_id);
    }

    public function delete(Request $request)
    {
        $client_id = Auth::guard('client')->user()->id;
        $result = $this->service->delete($request->notification_id, $client_id);
        if ($result) {
            toastr('Notificação deletada com sucesso.', 'success');
            return redirect()->route('notification.get');
        } else {
            toastr('Houve um erro ao deletar a notificação', 'error');
            return redirect()->route('notification.get');
        }
    }
}
