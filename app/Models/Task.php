<?php

namespace App\Models;

use App\Http\Traits\TasksTrait;
use App\Http\Traits\TimestampsTrait;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use TimestampsTrait;
    use TasksTrait;

    protected $guarded = [];

    public function getDates() {
        return ['created_at', 'updated_at', 'due_date'];
    }

    // Define the table
    protected $table = 'tasks';

    public function user(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

}
