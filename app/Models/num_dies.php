<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class num_dies extends Model
{
    use HasFactory;
    protected $fillable = ['dia','num_sessio'];
}
