<?php

namespace App\Models;

use App\Traits\Histories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes, Histories;

    protected $fillable = ['title', 'price', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productitems()
    {
        return $this->hasMany(ProductItem::class, 'variation_id');
    }

    public function invoice_items()
    {
        return $this->hasMany(Variation::class, 'variation_id');
    }
}
