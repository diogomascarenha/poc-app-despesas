<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroTipo extends Model
{
    const ENTRADA_CAIXA = 1;
    const SAIDA_CAIXA = 2;

    protected $table = 'registro_tipo';
}
