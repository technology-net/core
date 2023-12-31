<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class MenuItem extends BaseModel
{
    use HasFactory, Notifiable;

    protected $table = 'menu_items';

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();

        static::deleting(function($menuItem) {
            $menuItem->children()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->with('children');
    }

    /**
     * @return BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
