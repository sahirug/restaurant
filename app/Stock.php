<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey = ['stock_id', 'branch_id'];
    public $incrementing = false;

    public function branch(){
        return $this->belongsTo('App\Branch');
    }
}
