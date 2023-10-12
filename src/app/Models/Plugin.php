<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property string name_package
 * @property string version
 * @property string status
 * @property string scripts
 * @property string icon
 * @property int order
 */
class Plugin extends Model
{
    use HasFactory, Notifiable;
    public const STATUS_INSTALLED = 'Installed';
    public const STATUS_UNINSTALLED = 'Uninstalled';
    public const IS_DEFAULT = true;
    public const IS_NOT_DEFAULT = false;
    public const IS_PARENT = true;
    public const IS_NOT_PARENT = false;

    protected $table = 'plugins';

    protected $fillable = [
        'name_package',
        'version',
        'status',
        'is_default',
        'is_parent',
        'child_of',
        'scripts',
        'icon',
        'order',
        'route',
        'image',
        'description',
    ];

//    protected $casts = [
//        'is_default' => 'boolean',
//        'is_parent' => 'boolean',
//    ];
}
