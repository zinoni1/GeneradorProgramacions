<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicle extends Model
{
    use HasFactory;
    protected $fillable = ['nom','num_modul'];

    public function moduls(){
        return $this->hasMany(Modul::class);
    }
    public function ufs()
    {
        return $this->hasManyThrough(Uf::class, Modul::class);
    }
}
