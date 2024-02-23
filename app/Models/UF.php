<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;
    protected $fillable = ['nom','num_setmanes', 'ordre'];


    public function modul(){
        return $this->belongsTo(Modul::class);
    }
    

}
