<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalPaymentPixModel extends Model
{
    use HasFactory;

    protected $table = 'external_payment_pix';
    protected $fillable = ['client_uuid', 'external_reference', 'value', 'description', 'status', 'qrcode', 'copy_past','created_at'];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
