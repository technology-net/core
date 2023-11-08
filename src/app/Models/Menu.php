<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Menu extends BaseModel
{
    use HasFactory, Notifiable;

    public const TYPE_IS_SIDE_BAR = 'sidebar';

    protected $table = 'menus';

    protected $fillable = [
        'menu_type',
    ];
}
