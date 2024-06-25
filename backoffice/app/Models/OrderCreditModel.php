<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCreditModel extends Model
{
    use HasFactory;

    protected $table = 'order_credit';

    protected $fillable = [
        'client_id',
        'external_reference',
        'order_id',
        'amount',
        'purchase_info',
        'response',
        'status',
        'is_approved',
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
