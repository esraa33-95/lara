<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class Class1 extends Model
{
    use HasFactory;
    use softDeletes;
    protected $table = 'classes';
    
    protected $fillable=[
      'classname',
      'capacity',
      'isfilled',
      'price',
      'timefrom',
      'timeto',
      'image',

    ];
}
