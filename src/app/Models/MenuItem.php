<?php

namespace IBoot\Core\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class MenuItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id',
        'name',
        'parent_id',
        'slug',
        'order',
        'icon',
    ];


    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->with('children');
    }
}
