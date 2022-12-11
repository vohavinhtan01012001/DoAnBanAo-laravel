<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable =[
        'category_id',
        'name',
        'price',
        'promotion_id',
        'quantityM',
        'quantityL',
        'quantityXL',
        'image',
        'image2',
        'image3',
        'image4',
        'description'
    ];

    protected $with = ['categorys','promotion'];
    public function categorys(){
        return $this->belongsTo(Categorys::class, 'category_id','id');
    }
    public function promotion(){
        return $this->belongsTo(Promotion::class, 'promotion_id','id');
    }
}
