<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $fillable = ['client_id', 'title', 'body', 'icon'];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }

    protected static function booted()
    {
        static::creating(function ($notification) {
            if (empty($notification->client_id)) {
                $clients = ClientModel::all();

                foreach ($clients as $client) {
                    $newNotification = new static([
                        'title' => $notification->title,
                        'body' => $notification->body,
                        'icon' => 'fa-solid fa-building-columns',
                        'client_id' => $client->id,
                    ]);
                    $newNotification->save();
                }
                return false;
            } else {
                if ($notification->icon == ''){
                    $notification->icon = 'fa-solid fa-user-tie';
                }
            }
        });
    }

}
