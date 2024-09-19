<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    use HasFactory;

    protected $table = "token";

    protected $fillable = [
        'token',
        'appId',
        'appKey',
        'ip_address'
    ];

    public $timestamps = true;

    public function generateToken($ip, $appId, $appKey)
    {
        $existingTokens = self::where('appId', $appId)->get();

        foreach ($existingTokens as $existingToken) {
            $existingToken->delete();
        }

        $token = bin2hex(random_bytes(64));
        $this->token = $token;
        $this->ip_address = $ip;
        $this->appId = $appId;
        $this->appKey = $appKey;
        $this->save();
        return $token;
    }
}
