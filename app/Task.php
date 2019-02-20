<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'active' => true,
        'hours' => 0,
        'minutes' => 0,
        'seconds' => 0,
        'shouldEndAt' => 0,
    ];
    
}