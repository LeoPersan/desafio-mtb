@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <h1>Contato</h1>
            </div>
        </div>
        <div class="col-12 py-5 bg-gray">
            <div class="container">
                <div class="row justify-content-around text-center">
                    <div class="col-md-4 bg-white p-3">
                        <ul class="list-unstyled">
                            <li class="my-3">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            </li>
                            <li class="my-3">
                                <h4>Telefone / WhatsApp</h4>
                            </li>
                            <li class="my-3">
                                (18) 99655-3861 - Carlos
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 bg-white p-3">
                        <ul class="list-unstyled">
                            <li class="my-3">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </li>
                            <li class="my-3">
                                <h4>E-mail</h4>
                            </li>
                            <li class="my-3">
                                rcttupipta@gmail.com
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 black">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 offset-md-1">
                        <h2 class="my-4">Como podemos ajudá-lo?</h2>
                        <p class="my-4">
                            Algumas dúvidas podem ser respondidas pelo <a href="{{ route('regulamento') }}">Regulamento</a>,
                            mas não exite em nos mandar suas dúvidas ou sugestões.
                        </p>
                        <p class="my-4">
                            <a target="_blank" href="http://facebook.com/rotaracttupipaulista">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a target="_blank" href="https://instagram.com/rotaracttupipaulista/">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a target="_blank" href="https://youtube.com/channel/UCi46aojKFqFge-Dw8ppy0Ag">
                                <i class="fa fa-youtube" aria-hidden="true"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 my-4">
                        <form action="{{ route('contato') }}" @submit.prevent="post">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" name="nome" placeholder="Nome"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" name="email" placeholder="E-mail"
                                    required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-control-lg" name="mensagem" rows="3"
                                    placeholder="Mensagem" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary">Enviar E-mail</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
