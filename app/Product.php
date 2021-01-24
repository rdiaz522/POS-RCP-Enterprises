<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function stocks()
    {
        return $this->hasOne('App\Stocks', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }
}
