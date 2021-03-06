<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $primaryKey = 'branch_id';
    public $incrementing = false;

    public function employees(){
        return $this->hasMany('App\Employee', 'branch_id');
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

    public function manager(){
        return $this->belongsTo('App\Employee');
    }

    public function tables(){
        return $this->hasMany('App\Table', 'branch_id');
    }
}
