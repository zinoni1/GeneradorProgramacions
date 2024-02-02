<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curs;

class Trimestre extends Model
{
    use HasFactory;


    protected $fillable = ['data_inici', 'data_final'];

    public function curs()
    {
        return $this->belongsTo(Curs::class);
    }
}
