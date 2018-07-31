<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customers extends Authenticatable
{
    protected $table = "customers";
    public $timestamps = false;
    
    function billDetails(){
        return $this->hasManyThrough(
            'App\BillDetail',
            'App\Bills',
            'id_customer',
            'id_bill',
            'id',
            'id'
        );
    }
    function customer(){
        return $this->belongsTo('App\Customers','id_customer','id','username','email');
    }
}
