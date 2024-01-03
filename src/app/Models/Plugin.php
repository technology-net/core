<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Plugin extends BaseModel
{
    use HasFactory, Notifiable;
    public const STATUS_INSTALLED = 1;
    public const STATUS_UNINSTALLED = 0;
    public const IS_DEFAULT = true;
    public const IS_NOT_DEFAULT = false;

    public const PACKAGE_CMS = 'package/cms';

    protected $table = 'plugins';

    protected $fillable = [
        'name_package',
        'composer_name',
        'menu_items',
        'version',
        'status',
        'is_default',
        'scripts',
        'image',
        'description',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'menu_items' => 'array'
    ];
}
