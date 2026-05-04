<?php

namespace App\Models;

use App\Contracts\BrandInterface;
use App\Scopes\BrandScope;
use App\Traits\hasMeta;
use App\Traits\Histories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, hasMeta, SoftDeletes, Histories;

    private $reservedKeys = ['id', 'title', 'description', 'department_id', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    protected $fillable = ['title', 'description', 'department_id'];

    protected $casts = ['meta' => 'array'];


    public static function MyGlobalScope()
    {
        static::addGlobalScope(new BrandScope());
    }


    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

}


