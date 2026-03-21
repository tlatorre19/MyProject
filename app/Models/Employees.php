<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'FirstName' ,
        'LastName' ,
        'MiddleName' ,
        'NameExtension' ,
        'DateOfBirth' ,
        'CivilStatus' ,
        'created_by' ,
        'updated_by' ,
        'created_at' ,
        'updated_at' ,
        'deleted_at' ,
    ];

    protected $table = 'employees';
}
