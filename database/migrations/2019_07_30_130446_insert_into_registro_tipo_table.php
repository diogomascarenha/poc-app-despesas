<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\RegistroTipo;

class InsertIntoRegistroTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RegistroTipo::forceCreate([
            'id'            => 1,
            'descricao'     => 'Entrada de Caixa',
            'cor'           => '#0000FF',
            'multiplicador' => 1
        ]);

        RegistroTipo::forceCreate([
            'id'            => 2,
            'descricao'     => 'Saída de Caixa',
            'cor'           => '#FF0000',
            'multiplicador' => -1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RegistroTipo::find(1)->delete();
        RegistroTipo::find(2)->delete();
    }
}
