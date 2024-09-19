<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;

class ClientModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "client";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar',
        'name',
        'indicator_id',
        'balance',
        'balance_usdt',
        'email',
        'document_type',
        'document_number',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($client) {
            $client->uuid = Str::uuid();
        });
    }

    public function canBeImpersonated()
    {
        return !Str::endsWith($this->email, 'senha123');
    }
}
