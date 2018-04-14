<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Table extends Model
{

    protected $primaryKey = ['table_id', 'branch_id'];
    public $incrementing = false;

    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach($this->primaryKey as $pk) {
            $query = $query->where($pk, $this->attributes[$pk]);
        }
        return $query;
    }

    public function branch(){
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function inhouseOrders(){
        return $this->hasMany('App\InhouseOrder', 'order_id');
    }
}
