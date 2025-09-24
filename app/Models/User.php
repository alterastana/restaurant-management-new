<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi User ke Role (Many-to-One)
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Cek apakah user punya permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        return $this->role?->permissions()->where('name', $permission)->exists() ?? false;
    }

    /**
     * Cek apakah user punya role tertentu
     */
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    // Helper untuk role check cepat
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isWaiter(): bool
    {
        return $this->hasRole('waiter');
    }

    public function isCashier(): bool
    {
        return $this->hasRole('cashier');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }
}
