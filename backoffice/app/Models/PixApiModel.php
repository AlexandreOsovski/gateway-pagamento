<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KeysApiModel;

class PixApiModel extends Model
{
    use HasFactory;

    protected $table = 'pix_api';

    protected $fillable = [
        'client_uuid',
        'txId',
        'order_id',
        'appId',
        'token',
        'amount',
        'external_reference',
        'status',
        'qrcode'
    ];

    public static function getOrders($user, $status = null)
    {
        if (!$user) {
            return false;
        }

        $orders = [];

        $keys = KeysApiModel::where('client_id', $user->id)
            ->get();

        foreach ($keys as $key) {
            if ($status == null) {
                $orders = KeysApiModel::where('appId', $key->appId)
                    ->orderBy('created_at', 'asc')
                    ->paginate(5);
            } else {
                $orders = KeysApiModel::where('appId', $key->appId)
                    ->where('status', $status)
                    ->orderBy('created_at', 'asc')
                    ->paginate(5);
            }

            return $orders;
        }

        return false;
    }

    public static function getCalc($user)
    {
        if (!$user) {
            return false;
        }

        $orders = [];

        $keys = KeysApiModel::where('client_id', $user->id)
            ->get();

        foreach ($keys as $key) {
            $orders = KeysApiModel::where('appId', $key->appId)
                ->orderBy('created_at', 'asc')
                ->get();
            return $orders;
        }

        return false;
    }
}
