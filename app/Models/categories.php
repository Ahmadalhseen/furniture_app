<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $table="categorie";
    use HasFactory;
    public function product()
    {
        return $this->hasMany(product::class);
    }
}
