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

    protected $table = 'plugins';

    protected $fillable = [
        'name_package',
        'version',
        'status',
        'scripts',
        'icon',
        'order'
    ];
}
