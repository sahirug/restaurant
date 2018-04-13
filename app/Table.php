<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    protected $primaryKey = ['table_id', 'branch_id'];
    public $incrementing = false;

    public function branch(){
        return $this->belongsTo('App\Branch', 'branch_id');
    }

    public function inhouseOrders(){
        return $this->hasMany('App\InhouseOrder', 'order_id');
    }
}
