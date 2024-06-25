<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositPixModel extends Model
{
    use HasFactory;

    protected $table = "deposit_pix";

    protected $fillable = [
        'id',
        'client_id',
        'order_id',
        'amount',
        'status',
        'qrcode',
        'created_at',
        'updated_at',
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
