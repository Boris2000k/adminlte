<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class refunds extends Model
{
    protected $table = 'refunds';

    public $timestamps = false;

    protected $fillable = ['order_num','reason','status'];

}
