<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferUserToUserModel extends Model
{
    use HasFactory;

    protected $table = 'transfer_user_to_user';

    protected $fillable = [
        'amount',
        'movement_entry_id',
        'movement_exit_id'
    ];

    public function movementEntry()
    {
        return $this->belongsTo(MovementModel::class, 'movement_entry_id');
    }

    public function movementExit()
    {
        return $this->belongsTo(MovementModel::class, 'movement_exit_id');
    }

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
