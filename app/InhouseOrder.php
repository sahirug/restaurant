<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InhouseOrder extends Model
{
    protected $primaryKey = ['order_id', 'branch_id'];
    public $incrementing = false;

    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach($this->primaryKey as $pk) {
            $query = $query->where($pk, $this->attributes[$pk]);
        }
        return $query;
    }

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
