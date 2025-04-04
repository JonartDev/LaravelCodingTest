<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'del_flag',
        'quantity',
        'image_path',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notDeleted', function (Builder $builder) {
            $builder->where('del_flag', 0);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAvailable(Builder $query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Image URL Accessor
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    // Business Logic: Check stock availability
    public function isInStock()
    {
        return $this->quantity > 0;
    }

    // Business Logic: Update stock
    public function updateStock($quantity)
    {
        $this->quantity += $quantity;
        return $this->save();
    }
}