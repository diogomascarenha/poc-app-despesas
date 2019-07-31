<?php

namespace App\Http\Controllers;

use App\Registro;
use App\RegistroCategoria;
use App\RegistroTipo;
use App\Vendedor;
use Illuminate\Http\Request;
use Faker\Generator as Faker;

class SincronizarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * @var Faker
         */
        $faker      = \Faker\Factory::create('pt_BR');
        $vendedores = Vendedor::where('user_id', auth()->id())->pluck('id');
        if ($vendedores->count() === 0) {
            return redirect()->route('registro.index')->withErrors('Necessário pelo menos um vendedor cadastrado para sincronizar');
        }


        $total = rand(0, 5);
        for ($i = 0; $i < $total; $i++) {

            $params = [
                'user_id'               => auth()->id(),
                'vendedor_id'           => $faker->randomElement($vendedores->toArray()),
                'valor'                 => (float)$faker->numerify('##'),
                'descricao'             => 'Paciente '. $faker->firstName,
                'tags'                  => [$faker->randomElement(['cielo', 'rede', 'getnet'])],
                'data'                  => $faker->dateTimeBetween('first day of this month', 'now')->format('Y-m-d'),
                'registro_tipo_id'      => 1,
                'registro_categoria_id' => $faker->randomElement([1, 2])

            ];
            Registro::create($params);
        }


        return redirect()
            ->route('registro.index')
            ->with('success', 'Foram sincronizados ' . $total . ' Registros');
    }
}
