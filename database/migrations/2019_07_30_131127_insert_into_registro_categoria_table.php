<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\RegistroCategoria;
use App\RegistroTipo;

class InsertIntoRegistroCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RegistroCategoria::forceCreate([
            'id'               => 1,
            'registro_tipo_id' => RegistroTipo::ENTRADA_CAIXA,
            'nome'             => 'Consulta',
            'imagem'           => '<i class="far fa-hospital"></i>'
        ]);

        RegistroCategoria::forceCreate([
            'id'               => 2,
            'registro_tipo_id' => RegistroTipo::ENTRADA_CAIXA,
            'nome'             => 'Exame',
            'imagem'           => '<i class="fas fa-medkit"></i>'
        ]);

        RegistroCategoria::forceCreate([
            'id'               => 3,
            'registro_tipo_id' => RegistroTipo::SAIDA_CAIXA,
            'nome'             => 'Salário',
            'imagem'           => '<i class="fas fa-money-bill-alt"></i>'
        ]);

        RegistroCategoria::forceCreate([
            'id'               => 4,
            'registro_tipo_id' => RegistroTipo::SAIDA_CAIXA,
            'nome'             => 'Luz',
            'imagem'           => '<i class="fas fa-lightbulb"></i>'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RegistroCategoria::whereIn('id', [1, 2, 3, 4])->delete();
    }
}
