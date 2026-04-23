<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            //'role' => Role::class,
        ];
    }
    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }
    public function isHR(): bool{
        return $this->role ===Role::HR;
    }

    public function isEmployee(): bool{
        return $this->role ===Role::EMPLOYEE;
    }

    protected function accessLevelLabel(): Attribute
    {
        return Attribute::get(fn () => match ($this->role) {
            UserRole::Admin => 'Full Access',
            UserRole::HR => "HR access",
            UserRole::Employee => "Employee access",
            default => 'No Access',
        });
    }
    
    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function payrolls() {
        return $this->hasMany(Payroll::class);
        }
    }