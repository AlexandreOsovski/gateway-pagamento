<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRecoveryCode extends Model
{
    use HasFactory;

    protected $table = 'client_recovery_code';
    protected $fillable = ['client_id', 'code', 'status'];

    public function client(){
        return $this->belongsTo(ClientModel::class, 'client_id');
    }
}
