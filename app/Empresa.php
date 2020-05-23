<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Grupo;
use App\Colaborador;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'endereco'];

    public function grupos() {
        return $this::belongsToMany(Grupo::class);
    }

    public function colaboradores() {
        return $this::hasMany(Colaborador::class);
    }
}
