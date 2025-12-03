@extends('app.layout')
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}"/>

    <div class="col-12 col-sm-12 col-md-5 col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-1">Bem-vindo(a)! {{ Auth::user()->maskName() }}</h5>
                <p class="card-subtitle mb-3">
                    {{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('dddd [às] HH:mm') }}
                </p>
                <h4 class="text-primary mb-0">
                    <a class="text-warning" href="{{ route('buy') }}">ASSINE UM PLANO</a>
                </h4>
                <p class="mb-3">Para obter os benefícios da sua conta! 😍</p>
                <a href="{{ route('posts') }}" class="btn btn-sm btn-warning waves-effect waves-light">Publicar</a>
            </div>
            <img src="{{ asset('assets/img/illustrations/illustration-upgrade-account.png') }}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4" height="162" alt="Bem-vindo(a)! {{ Auth::user()->maskName() }}">
        </div>
    
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">News Letter</h5>
                </div>
                <p class="mb-0 card-subtitle">Total 5.520 e-mails</p>
            </div>
            <div class="card-body">
                <div class="demo-inline-spacing mt-4">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect">
                            <div class="w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="user-info">
                                        <h6 class="mb-1 fw-normal">Danish sesame snaps halvah</h6>
                                        <div class="d-flex align-items-center">
                                            <div class="user-status me-2 d-flex align-items-center">
                                                <span class="badge badge-dot bg-success me-1"></span>
                                                <small>Disparado</small>
                                            </div>
                                            <div class="user-status me-2 d-flex align-items-center">
                                                <span class="badge badge-dot bg-info me-1"></span>
                                                <small>1000 e-mails</small>
                                            </div>
                                            <small class="text-muted ms-1">10/10/2025</small>
                                        </div>
                                    </div>
                                    <div class="add-btn">
                                        <button class="btn btn-primary btn-sm waves-effect waves-light">Acessar</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="card bg-warning mb-3">
            <div class="card-body pb-1 pt-0">
                <div class="mb-6 mt-1">
                    <div class="d-flex align-items-center">
                        <h1 class="mb-0 me-2 text-white">{{ $posts->count() }}</h1>
                        <div class="badge bg-label-dark rounded-pill">+{{ $posts->sum('views') }} visitas</div>
                    </div>
                    <p class="mt-0 text-white">Últimas postagens</p>
                </div>
                <div class="table-responsive text-nowrap border-top">
                    <table class="table">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td class="ps-0 pe-12 py-4">
                                    <span class="text-white">POSTAGEM</span>
                                </td>
                                <td class="text-end py-4 text-center">
                                    <span class="text-white">VISUALIZAÇÕES</span>
                                </td>
                                <td class="pe-0 py-4 text-center">
                                    <span class="text-white">OPÇÕES</span>
                                </td>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="ps-0 pe-12 py-4">
                                        <span class="text-white">{{ Str::limit($post->title, 50) }}</span>
                                    </td>
                                    <td class="text-end py-4 text-center">
                                        <span class="text-white">{{ $post->views }}</span>
                                    </td>
                                    <td class="pe-0 py-4 text-center">
                                        <a href="{{ route('post', ['uuid' => $post->uuid]) }}" class="text-white">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
@endsection