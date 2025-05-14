<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        // When a user is deleted, cascade delete their orders
        static::deleting(function ($user) {
            $user->orders()->each(function ($order) {
                $order->orderItems()->delete(); // Delete order items first
            });
            $user->orders()->delete(); // Then delete the orders
        });
    }

    /**
     * Get all orders for this user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get total spent by this user
     */
    public function getTotalSpentAttribute(): float
    {
        return $this->orders()
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    /**
     * Get total number of orders by this user
     */
    public function getTotalOrdersAttribute(): int
    {
        return $this->orders()
            ->where('status', 'completed')
            ->count();
    }
}
