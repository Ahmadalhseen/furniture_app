<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_rate extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(product::class);
    }
}
