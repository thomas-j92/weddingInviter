<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
     
    public function attending($query)
    {
        return $query->where('attending', 1);
    }
}
