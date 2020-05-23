<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Empresa;

class Grupo extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable
     * 
     * @var array
     * 
     */
    protected $fillable = ['nome'];

    public function empresas() {
        return $this::belongsToMany(Empresa::class);
    }
}
