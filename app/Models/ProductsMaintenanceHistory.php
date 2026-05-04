<?php

namespace App\Models;

use App\Traits\hasMeta;
use App\Traits\Histories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsMaintenanceHistory extends Model
{
    use HasFactory, hasMeta, SoftDeletes, Histories;

    private $reservedKeys = ['id', 'product_item_id', 'title', 'description', 'amount', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    protected $casts = ['meta' => 'array'];

    public function productitem()
    {
        return $this->belongsTo(ProductItem::class, 'product_item_id');
    }
}
