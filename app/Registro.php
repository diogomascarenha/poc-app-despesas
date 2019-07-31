<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table    = 'registro';
    protected $fillable = [
        'user_id',
        'registro_tipo_id',
        'registro_categoria_id',
        'vendedor_id',
        'data',
        'valor',
        'descricao',
        'tags'
    ];
    protected $casts    = [
        'data' => 'date',
        'tags' => 'json'
    ];

    public function categoria()
    {
        return $this->belongsTo(RegistroCategoria::class, 'registro_categoria_id','id');
    }

    public function tipo()
    {
        return $this->belongsTo(RegistroTipo::class, 'registro_tipo_id','id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'vendedor_id','id');
    }
}
