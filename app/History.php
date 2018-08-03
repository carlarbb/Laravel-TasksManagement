<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //table name
    protected $table = 'history';
    //primary key
    protected $primaryKey ='id';
    //Timestamps
    public $timestamps = true;

}