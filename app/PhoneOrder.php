<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PhoneOrder extends Model
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
}
