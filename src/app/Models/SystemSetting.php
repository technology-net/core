<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class SystemSetting extends BaseModel
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected $table = 'system_settings';
}
