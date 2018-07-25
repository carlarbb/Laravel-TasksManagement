<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //table name
    protected $table = 'projects';
    //primary key
    protected $primaryKey ='id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = ['title', 'description'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function task(){
        return $this->hasMany('App\Task');
    }
}
