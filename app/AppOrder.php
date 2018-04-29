<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppOrder extends Model
{
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    public $timestamps = false;    
}
