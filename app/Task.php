<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tb_tasks';

    protected $fillable = ['title', 'description', 'assignee_id', 'due_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assignee_id');
    }
}
