<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dimenision extends Model
{   protected $table="dimension";
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(product::class);
    }

}
