<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Car extends Model
{
    use HasFactory, softDeletes;
    protected $fillable=[
        'cartitle',
        'description',
        'price',
        'published',
        'image',
        'category_id',
    ];
    public function category(){
        return $this->belongsTo(category::class);

    }
}
