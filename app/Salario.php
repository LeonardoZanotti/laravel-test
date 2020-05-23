<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Colaborador;

class Salario extends Model
{
    use SoftDeletes;

    protected $fillable = ['valor', 'colaborador_id'];

    public function colaborador() {
        return $this::belongsTo(Colaborador::class);
    }
}
