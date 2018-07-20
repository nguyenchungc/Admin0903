<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customers extends Authenticatable
{
    protected $table = "customers";
    
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
}
