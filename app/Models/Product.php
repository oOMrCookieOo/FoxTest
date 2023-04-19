<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['image_url'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $term)
    {
        $query
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', "%$term%")
                    ->orWhere('slug', 'like', "%$term%");
            })
            ->orWhereHas('category', function ($query) use ($term) {
                $query->where('name', 'like', "%$term%");
            });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function getImageUrlAttribute()
    {
        //just For seeder it can be changed later to suit more behaviours
        if (str($this->image)->contains('https')) return 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/a42a5d53-2f99-4e78-a081-9d07a2d0774a/air-force-1-07-mens-shoes-xDpsTk.png';

        return $this->image ? asset(Storage::disk('public')->url($this->image))
            : 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/a42a5d53-2f99-4e78-a081-9d07a2d0774a/air-force-1-07-mens-shoes-xDpsTk.png';
    }
}
