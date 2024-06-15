<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferUserToUserModel extends Model
{
    use HasFactory;

    protected $table = 'transfer_user_to_user';

    protected $fillable = [
        'client_id',
        'client_pay_id',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(ClientModel::class);
    }

    public function userPay()
    {
        return $this->hasMany(ClientModel::class, 'id');
    }


    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}