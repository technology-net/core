<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public const STATUS_ACTIVATED = 'Activated';
    public const STATUS_DEACTIVATED = 'Deactivated';
    const SUPER_HIGH = 1;
    const HIGH = 2;
    const MEDIUM = 3;
    const NORMAL = 4;
    protected $guard_name = "web";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'name',
        'status',
        'level',
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

    /**
     * @return MorphToMany
     */
    public function medias(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'media_able');
    }
}
