<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   //table name
   protected $table = 'tasks';
   //primary key
   protected $primaryKey ='id';
   //Timestamps
   public $timestamps = true;

   protected $fillable = ['title', 'body'];

   public function receiver(){
       return $this->belongsTo('App\User', 'receiver_id');
   }
   public function created_by(){
       return $this->belongsTo('App\User', 'created_by_id');
   }
}
