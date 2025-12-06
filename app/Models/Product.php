<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount',
        'category_id',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Зв'язок: Товар належить до однієї категорії.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Зв'язок: Товар має багато відгуків.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    /**
     * Аксесор: Отримати середній рейтинг товару.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Аксесор: Отримати ціну зі знижкою.
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price * (1 - $this->discount / 100);
        }
        return $this->price;
    }
    
    /**
     * Scope: Пошук за назвою або описом.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Scope: Фільтрація за категорією.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: Фільтрація за ціною.
     */
    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
}