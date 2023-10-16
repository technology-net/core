<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Menu extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'menus';

    protected $fillable = [
        'menu_type',
    ];
}
