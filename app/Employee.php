<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'tb_employees';

    protected $fillable = ['firstName', 'lastName', 'email', 'phone', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
