<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model {
    protected $guarded = [];
    protected function casts(): array { return ['images'=>'array','specs'=>'array','featured'=>'boolean','price'=>'decimal:2','old_price'=>'decimal:2']; }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function getPrimaryImageAttribute(): string { return $this->images[0] ?? '/app-icon.jpg'; }
}
