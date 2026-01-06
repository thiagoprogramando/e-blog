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
                
                @if (Auth::user()->hasActiveSubscription())
                    <h4 class="text-primary mb-0"><a class="text-warning" href="{{ route('posts') }}">Aproveite os benefícios</a> </h4>
                    <p class="mb-3">Receba Likes e Comentários nas postagens! 😍</p>
                @else
                    <h4 class="text-primary mb-0"><a class="text-warning" href="{{ route('buy') }}">ASSINE UM PLANO</a></h4>
                    <p class="mb-3">Para obter os benefícios da sua conta! 😍</p>
                @endif
               
                <a href="{{ route('posts') }}" class="btn btn-sm btn-warning waves-effect waves-light">Publicar</a>
            </div>
            <img src="{{ asset('assets/img/illustrations/illustration-upgrade-account.png') }}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 mb-4" height="162" alt="Bem-vindo(a)! {{ Auth::user()->maskName() }}">
        </div>

        @if (Auth::user()->invoices->count() > 0)
            <div class="card card-action mb-6" id="invoices">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">Faturas</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach (Auth::user()->invoices->sortBy('payment_status') as $invoice)
                            <li class="mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <h6 class="mb-1">{{ $invoice->product->name ?? $invoice->title }} - R$ {{ number_format($invoice->value, 2, ',', '.') }}</h6>
                                            <small>{{ \Carbon\Carbon::parse($invoice->payment_date ?? $invoice->due_date)->format('d/m/Y') }}</small> | <small><a href="{{ $invoice->payment_url }}" target="_blank" rel="noopener noreferrer">Acessar</a></small>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="javascript:;">{!! $invoice->statusLabel() !!}</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        
                        <li class="text-center">
                            <a href="javascript:;">Não há mais dados.</a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
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