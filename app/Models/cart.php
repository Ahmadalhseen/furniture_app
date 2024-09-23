<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{   protected $table="cart";
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany(product::class);
    }
}
