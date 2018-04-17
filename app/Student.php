<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['studentID', 'userID'];


    public function notifications()

    {
        return $this->hasMany(\App\Student::class);
    }



}


