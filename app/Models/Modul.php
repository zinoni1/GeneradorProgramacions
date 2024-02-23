<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;
    protected $fillable = ['nom'];

    public function ufs(){
        return $this->hasMany(Uf::class);
    }

    public function numdies(){
        return $this->hasMany(NumDies::class);
    }

    public function cicles(){
        return $this->belongsTo(Cicle::class);
    }
    
}
