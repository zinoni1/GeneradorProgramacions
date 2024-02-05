<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trimestre;
use App\Models\Festiu;

class Curs extends Model
{
    use HasFactory;

    protected $fillable = ['nom','data_inici', 'data_final'];

    public function trimestre()
    {
        return $this->hasMany(Trimestre::class);
    }
    public function festiu()
    {
        return $this->hasMany(Festiu::class);
    }
}
