<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageUrl extends Model
{
    protected $table = "page_url";

    function products(){
        return $this->hasOne('App\Products','id_url','id');
        //id : PK of page_url : local key
        
    }
    
}
