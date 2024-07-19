<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Class1 extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable=[
      'classname',
      'capacity',
      'isfilled',
      'price',
      'timefrom',
      'timeto',

    ];
}
