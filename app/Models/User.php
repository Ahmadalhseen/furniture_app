<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function payment_card(): HasMany
    {
        return $this->hasMany(payment_card::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(cart::class);
    }

    public function delivery_location(): HasOne
    {
        return $this->hasOne(delivery_location::class);
    }

    public function favorite(): HasOne
    {
        return $this->hasOne(favorite::class);
    }

    public function user_token(): HasOne
    {
        return $this->hasOne(user_token::class);
    }
}
