<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status'];

    protected $rules = [
        'title' => 'sometimes|required|max:255',
        'description' => 'sometimes|nullable|string',
        'status' => 'sometimes|required',
    ];
}
