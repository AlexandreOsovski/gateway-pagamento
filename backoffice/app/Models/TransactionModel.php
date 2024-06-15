<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'client_id',
        'method_payment',
        'type_key',
        'amount',
        'address',
        'token',
        'status',
        'approved_manual',
        'confirm'
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}