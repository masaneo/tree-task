<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Tree View</title>

        <link rel="stylesheet" href="{{ URL::asset('css/app.css'); }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="treeview col-12">
                    @include('treenodes', ['nodes' => $root])
                </div>
            </div>
            <div class="row">
                <div class="col-3 form-div">
                    <h4>Dodaj nowy node</h4>
                    {{ Form::open(['url' => 'add']) }}
                        <div class="form-group">
                            {{ Form::text('name', old('name'), ['class' => 'form-control','placeholder' => 'Nazwa', 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::select('parentId', $tree, old('id'), ['class' => 'custom-select','placeholder' => 'Wybierz rodzica']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Dodaj', ['class' => 'btn btn-primary btn-block']) }}
                        </div>
                        
                    {{ Form::close() }}
                </div>
                <div class="col-3 form-div">
                    <h4>Usuń node</h4>
                    {{ Form::open(['url' => 'delete', 'method' => 'delete']) }}
                        <div class="form-group">
                            {{ Form::select('id', $tree, old('id'), ['class' => 'custom-select','placeholder' => 'Wybierz node do usunięcia', 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Usuń', ['class' => 'btn btn-danger btn-block']) }}
                        </div>
                    {{ Form::close() }}
                </div>
                <div class="col-3 form-div">
                    <h4>Edytuj node</h4>
                    {{ Form::open(['url' => 'edit', 'method' => 'put'])}}
                        <div class="form-group">
                            {{ Form::select('id', $tree, old('id'), ['class' => 'custom-select', 'placeholder' => 'Wybierz node do edycji', 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Nowa nazwa', 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Edytuj', ['class' => 'btn btn-primary btn-block']) }}
                        </div>
                    {{ Form::close() }}
                </div>
                <div class="col-3 form-div">
                    <h4>Przenieś node</h4>
                    {{ Form::open(['url' => 'move', 'method' => 'put'])}}
                        <div class="form-group">
                            {{ Form::select('moveNodeId', $tree, old('id'), ['class' => 'custom-select', 'placeholder' => 'Wybierz node do przeniesienia', 'required' => 'required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::select('targetNodeId', $tree, old('id'), ['class' => 'custom-select', 'placeholder' => 'Wybierz node docelowy']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Przenieś', ['class' => 'btn btn-primary btn-block', 'id' => 'move-button']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>

            @if ($message = Session::get('failed'))
                <div class="alert alert-danger alert-block alert-custom">
                    <strong>{{ $message }}</strong>
                </div>
            @elseif ($message = Session::get('succeed'))
                <div class="alert alert-success alert-block alert-custom">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
        <script src="{{ URL::asset('js/app.js'); }}"></script>
    </body>
</html>