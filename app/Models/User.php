<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var mixed|string
     */
    private $name;
    /**
     * @var mixed|string
     */
    private $email;
    /**
     * @var mixed|string
     */
    private $password;
    /**
     * @var \Carbon\Carbon|mixed
     */
    private $created_at;
    /**
     * @var \Carbon\Carbon|mixed
     */
    private $updated_at;

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by_id');
    }

    public function executors(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }
}
