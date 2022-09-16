<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gifts extends Model
{
    protected $table = 'gifts';

    public $timestamps = false;

    protected $fillable = ['product_name','message','delivery'];
}
