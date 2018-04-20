<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['student_id', 'user_id'];


    public function notifications()

    {
        return $this->hasMany(\App\Notification::class);
    }



}


