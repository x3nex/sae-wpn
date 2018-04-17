<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'body', 'status'];


    public function students()

    {
        return $this->belongsTo(\App\Student::class);
    }


}
