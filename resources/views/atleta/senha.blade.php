@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-5">
            <div class="card">
                <div class="card-header">
                    <h3>Bem vindo ao painel do atleta!</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('atleta.senha')}}" @submit.prevent="post">
                        @csrf
                        <div class="form-group">
                          <label>Senha de acesso</label>
                          <input type="password" class="form-control" name="senha">
                        </div>
                        <div class="form-group">
                          <label>Confirme a senha</label>
                          <input type="password" class="form-control" name="senha_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
