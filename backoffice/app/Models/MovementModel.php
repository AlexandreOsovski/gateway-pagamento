<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

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

    protected static function booted()
    {
        static::creating(function ($movement) {
            $movement->uuid = Str::uuid();
        });
    }
}
