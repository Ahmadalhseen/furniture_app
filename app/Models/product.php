<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{ protected $table="product";
    use HasFactory;
    public function favorites()
    {
        return $this->hasMany(favorite::class);
    }

    // Relationship with the 'category' table (one-to-one or belongs-to)
    public function category()
    {
        return $this->belongsTo(categories::class);
    }
   public function dimenision(): HasOne
   {
       return $this->hasOne(User::class);
   }

   public function discount(): HasMany
   {
       return $this->hasMany(discount::class);
   }
   public function product_multimedia(): HasMany
   {
       return $this->hasMany(product_multimedia::class);

   }

   public function product_rate(): HasOne
   {
       return $this->hasOne(product_rate::class);
   }

   public function cart(): HasOne
   {
       return $this->hasOne(cart::class);
   }
}
