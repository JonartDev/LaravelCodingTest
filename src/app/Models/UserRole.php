<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const CUSTOMER = 2;

    protected $fillable = ['name'];
}