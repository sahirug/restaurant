<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function employees(){
        return $this->hasMany('App\Employee');
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function stocks(){
        return $this->hasMany('App\Stock');
    }
    
    public function meals(){
        return $this->hasMany('App\Meal');
    }

    public function inhouseOrders(){
        return $this->hasMany('App\InhouseOrder');
    }
}
