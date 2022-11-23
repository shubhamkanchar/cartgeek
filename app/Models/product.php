<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable=[
        'product_name',
        'product_description',
        'product_price',
    ];

    public $timestamp=true;

    public function image()
    {
        return $this->hasMany(image::class,'product_id','id');
    }
}
