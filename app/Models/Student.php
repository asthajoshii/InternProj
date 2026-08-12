<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  protected $fillable = [
    'schoolcode',

    'erpid',
    'rollno',

    'fname',
    'mname',
    'lname',

    'class',
    'div',

    'dob',
    'bloodgroup',

    'pname',
    'pcontact',

    'address1',
    'address2',
    'landmark',
    'pincode',

    'photo',
];
}
