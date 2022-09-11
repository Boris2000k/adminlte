<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $table = 'orders';

    // protected $casts = [
    //     'order_date' => 'datetime:m/d/Y',
    // ];

    public $timestamps = false;

    protected $fillable = ['order_date','channel','sku','item_description','origin','so','total_price','cost','shipping_cost','profit'];
}
