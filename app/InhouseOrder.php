<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InhouseOrder extends Model
{
    public function meals(){
        return $this->belongsToMany('App\Meal')->withPivot('qty');
    }

    public function table(){
        return $this->belongsTo('App\Table');
    }

    public function employee(){
        return $this->belongsTo('App\Employee');
    }

    public function branch(){
        return $this->belongsTo('App\Branch');
    }
}
