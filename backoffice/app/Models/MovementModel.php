<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementModel extends Model
{
    use HasFactory;

    protected $table = "movement";

    protected $fillable = [
        'client_id',
        'type',
        'type_movement',
        'amount',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(ClientModel::class);
    }
}