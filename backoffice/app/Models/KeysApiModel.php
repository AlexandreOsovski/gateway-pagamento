<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class KeysApiModel extends Model
{
    use HasFactory;

    protected $table = 'keys_api';

    protected $fillable = [
        'client_id',
        'title',
        'appId',
        'appKey',
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->client_id)) {
                $model->client_id = Auth::guard('client')->user()->id;
            }
            $response = self::generateKey();
            $model->appId = $response['appId'];
            $model->appKey = $response['appKey'];
        });
    }

    public static function generateKey()
    {
        $appId = uniqid();
        $appKey = md5(uniqid(rand(), true));

        return [
            'appId' => $appId,
            'appKey' => $appKey,
        ];
    }
}
