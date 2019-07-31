@extends('layouts.app')

@section('content')
    <div class="container">

        <a class="btn btn-primary" href="{{ route('registro.create',['registro_tipo_id'=>1])}}">Adicionar Receita</a>
        <a class="btn btn-primary" href="{{ route('registro.create',['registro_tipo_id'=>2])}}">Adicionar Despesa</a>
        <a class="btn btn-primary" href="{{ route('sincronizar.index')}}">Sincronizar (Cielo, Rede, Getnet)</a>

        <div class="card-header">
            <div>
                Registros
            </div>

        </div>
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="row">
                <div class="col-md-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <td>Mês</td>
                        <td>
                            <form id="form-pesquisa" method="GET" action="{{route('registro.index')}}">
                                <select class="form-control" id="mes" name="mes"
                                        onchange="document.getElementById('form-pesquisa').submit()">
                                    @foreach ($meses as $key=>$value)

                                        @if ($key == $mes)
                                            <option value="{{$key}}" selected> {{$value}}/{{$ano}}</option>
                                        @else
                                            <option value="{{$key}}"> {{$value}}/{{$ano}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Data</td>
                <td>Vendedor</td>
                <td>Categoria</td>
                <td>Valor (R$)</td>
                <td>Tags</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($registros as $registro)
                <tr style="color: {{$registro->tipo->cor}}">
                    <td>{{$registro->data->format('d/m/Y')}}</td>
                    <td>{{$registro->vendedor->nome}}</td>
                    <td>{{$registro->categoria->nome}}</td>
                    <td>{{number_format($registro->valor * $registro->tipo->multiplicador,2,'.',',')}}</td>
                    <td>{{implode(', ',$registro->tags)}}</td>
                    <td class="text-center">
                        <a href="{{ route('registro.edit',$registro->id)}}" class="btn btn-primary">Alterar</a>
                        <form action="{{ route('registro.destroy', $registro->id)}}"
                              method="post"
                              style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <canvas id="canvas"></canvas>
    </div>
    <link>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" rel="stylesheet">
    <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    <script>
        var color = Chart.helpers.color;
        var barChartData = {
            labels: ['{{$mesNome}}'],
            datasets: [{
                label: 'Receita',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: [
                    {{
                        $registros->filter(function($registro){
                        return $registro->registro_tipo_id == 1;
                    })->sum('valor')}}
                ]
            }, {
                label: 'Despesa',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [
                    {{
                        $registros->filter(function($registro){
                        return $registro->registro_tipo_id == 2;
                    })->sum('valor')}}
                ]
            }]

        };

        window.onload = function () {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Resumo'
                    }
                }
            });

        };
    </script>
@endsection
