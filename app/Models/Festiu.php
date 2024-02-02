<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cursos;

class Festiu extends Model
{
    use HasFactory;

    protected $fillable = ['data_inici', 'data_final','tipus'];

    public function curs()
    {
        return $this->belongsTo(Cursos::class);
    }
}
