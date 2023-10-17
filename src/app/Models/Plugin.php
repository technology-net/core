<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Plugin extends Model
{
    use HasFactory, Notifiable;
    public const STATUS_INSTALLED = 'Installed';
    public const STATUS_UNINSTALLED = 'Uninstalled';
    public const IS_DEFAULT = true;
    public const IS_NOT_DEFAULT = false;

    protected $table = 'plugins';

    protected $fillable = [
        'name_package',
        'composer_name',
        'version',
        'status',
        'is_default',
        'scripts',
        'image',
        'description',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}
