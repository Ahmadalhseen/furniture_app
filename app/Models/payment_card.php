<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_card extends Model
{
    use HasFactory;
    protected $table="payment_card";
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
