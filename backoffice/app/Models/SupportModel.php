<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportModel extends Model
{
    use HasFactory;

    protected $table = 'support';
    protected $fillable = ['uuid', 'client_id', 'email', 'phone', 'title', 'body', 'status'];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}
