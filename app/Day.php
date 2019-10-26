<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    //
    // PROPERTIES
    //

    protected $fillable = [
      'date',
    ];

    protected $dates = [
        'date',
    ];
}
