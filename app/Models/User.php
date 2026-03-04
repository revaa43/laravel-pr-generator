<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'avatar_path',
        'signature_path',
        'phone',        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    // NEW: Avatar URL accessor
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return Storage::url($this->avatar_path);
        }
        
        // Default avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=f97316&background=fff5f0&bold=true';
    }

    // NEW: Signature URL accessor
    public function getSignatureUrlAttribute()
    {
        if ($this->signature_path && Storage::disk('public')->exists($this->signature_path)) {
            return Storage::url($this->signature_path);
        }
        
        return null;
    }

    // NEW: Has signature checker
    public function hasSignature(): bool
    {
        return !empty($this->signature_path) && Storage::disk('public')->exists($this->signature_path);
    }

    // Existing relationships
    public function createdPRs()
    {
        return $this->hasMany(PurchaseRequisition::class, 'created_by');
    }

    public function approvedPRs()
    {
        return $this->hasMany(PurchaseRequisition::class, 'approved_by');
    }
}