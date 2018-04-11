<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{

    protected $primaryKey = ['meal_id', 'branch_id'];
    public $incrementing = false;

    public function inhouseOrders(){
        return $this->belongsToMany('App\InhouseOrder')->withPivot('qty');
    }

    public function branch(){
        return $this->belongsTo('App\Branch');
    }
}
