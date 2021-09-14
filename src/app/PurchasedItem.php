<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasedItem extends Model
{
    //
    protected $table = 'purchased';

    protected $fillable = ['user_id','product_sku'];
}
