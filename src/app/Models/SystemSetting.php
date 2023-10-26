<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SystemSetting extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected $table = 'system_settings';
}
