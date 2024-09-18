<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class user_token extends Model
{
    use HasFactory;
    protected $table="user_token";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
