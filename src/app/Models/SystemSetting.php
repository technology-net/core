<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class SystemSetting extends BaseModel
{
    use HasFactory, Notifiable;

    const FILE_SYSTEM = 'File System';
    protected $guarded = [];

    protected $table = 'system_settings';
}
