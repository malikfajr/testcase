<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'picture',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'hire_date',
        'end_date',
        'position_id',
        'salary',
        'status',
    ];
}
