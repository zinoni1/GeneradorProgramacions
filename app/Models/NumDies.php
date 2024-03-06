<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumDies extends Model
{
    use HasFactory;
    protected $fillable = ['dia', 'num_sessio', 'nombre_modul'];

    public function moduls(){
        return $this->belongsTo(Modul::class);
    }
}