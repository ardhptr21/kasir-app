<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
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
        'username',
        'email',
        'phone',
        'nik',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function scopeFilter(Builder $query, array $filters)
    {

        $query->when($filters['user'] ?? false, function (Builder $query, string $user) {
            return $query->where('name', 'like', "%{$user}%")
                ->orWhere('username', 'like', "%{$user}%")
                ->orWhere('email', 'like', "%{$user}%");
        });

        $query->when($filters['role'] ?? false, function (Builder $query, string $role) {
            return $query->where('role', $role);
        });
    }
}
