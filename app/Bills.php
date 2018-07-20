<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $table = "bills";
    public $timestamps = false;

    function products(){
        return $this->belongsToMany('App\Products','bill_detail','id_bill','id_product');
    }
    function customer(){
        return $this->belongsTo('App\Customers','id_customer','id');
    }
    function billDetail(){
        return $this->hasMany('App\BillDetail','id_bill','id');
    }
    
}
