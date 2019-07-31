@extends('layouts.app')

@section('content')

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
            crossorigin="anonymous">
    </script>

    <link href="https://www.jqueryscript.net/demo/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.css" rel="stylesheet">
    <script src="https://www.jqueryscript.net/demo/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.js"></script>

    <div class="container">
        <div class="card uper">
            <div class="card-header">
                Adicionar Registro
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form method="post" action="{{ route('registro.update',['id'=>$registro->id]) }}">
                    @method('PUT')
                    <input type="hidden" name="registro_tipo_id" value="{{$registro->tipo->id}}">
                    <div class="form-group">
                        <label for="price">Tipo :</label>
                        <input type="text" class="form-control" name="tipo" disabled value="{{$registro->tipo->descricao}}"/>
                    </div>
                    <div class="form-group">
                        @csrf
                        <label for="name">Vendedor :</label>
                        <select class="form-control" id="vendedor_id" name="vendedor_id">
                            @foreach ($vendedores as $vendedor)
                                @if ($vendedor->id == $registro->vendedor_id)
                                    <option value="{{$vendedor->id}}" selected>{{$vendedor->nome}}</option>
                                @else
                                    <option value="{{$vendedor->id}}">{{$vendedor->nome}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Categoria :</label>
                        <select class="form-control" id="vendedor_id" name="registro_categoria_id">
                            @foreach ($categorias as $categoria)
                                @if ($categoria->id == $registro->registro_categoria_id)
                                    <option value="{{$categoria->id}}" selected> {{$categoria->nome}}</option>
                                @else
                                    <option value="{{$categoria->id}}"> {{$categoria->nome}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="data">Data :</label>
                        <input type="date" class="form-control" name="data" value="{{$registro->data->format('Y-m-d')}}"/>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor :</label>
                        <input type="number" class="form-control" name="valor" value="{{$registro->valor}}"/>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição :</label>
                        <input type="text" class="form-control" name="descricao" value="{{$registro->descricao}}"/>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Tags :</label>
                        <input type="text" class="form-control" data-role="tagsinput" name="tags" value="{{implode(',',$registro->tags)}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Alterar Registro</button> <a href="{{route('registro.index')}}" class="btn btn-danger">Voltar</a>
                </form>
            </div>
        </div>
    </div>


@endsection
