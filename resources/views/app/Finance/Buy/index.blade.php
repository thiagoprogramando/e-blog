@extends('app.layout')
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-pricing.css') }}"/>

    <div class="col-12 col-sm-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
        <div class="card">
            <section class="pb-sm-12 pb-2 rounded-top">
                <div class="container py-8">
                    <h2 class="text-center mb-2">Planos</h2>
                    <p class="text-center px-sm-12 mb-5">
                        Selecione o plano ideal para o seu negócio!
                    </p>

                    <div class="pricing-plans row mx-4 gy-3 px-lg-10">
                        @foreach ($plans as $plan)
                            <div class="col-lg-4 mb-lg-0 mb-3">
                                <div class="card border-dark border shadow-none">
                                    <div class="card-body">
                                        <div class="mt-3 mb-3 text-center">
                                            <img data-bs-toggle="modal" data-bs-target="#buyModal{{ $plan->uuid }}" src="{{ $plan->image ? asset('storage/'.$plan->image) : asset('assets/img/illustrations/pricing-basic.png') }}" class="img-fluid" alt="{{ $plan->title }}"/>
                                        </div>
                                        <h4 class="card-title text-center text-capitalize mb-2" data-bs-toggle="modal" data-bs-target="#buyModal{{ $plan->uuid }}">{{ $plan->title }}</h4>
                                        <p class="text-center mb-5">{{ $plan->caption }}</p>
                                        <div class="text-center" data-bs-toggle="modal" data-bs-target="#buyModal{{ $plan->uuid }}">
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 pricing-currency mt-2 mb-0 me-1 text-body fw-normal">R$</sup>
                                                <h1 class="mb-0 text-warning">{{ $plan->value }}</h1>
                                                <sub class="h6 pricing-duration mt-auto mb-1 text-body fw-normal">/{{ $plan->timeLabel() }}</sub>
                                            </div>
                                        </div>
                                        <div class="ps-6 my-5 pt-4 text-center">
                                            {!! $plan->description !!}
                                        </div>
                                        <button type="button" class="btn btn-outline-warning d-grid w-100" @disabled($plan->hasInvoice()) data-bs-toggle="modal" data-bs-target="#buyModal{{ $plan->uuid }}">Escolher Plano</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="buyModal{{ $plan->uuid }}" tabindex="-1" aria-hidden="true">
                                <form action="{{ route('created-buy', ['plan' => $plan->uuid]) }}" method="POST">
                                    @csrf
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Escolha uma forma de Pagamento</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                                                        <div class="form-floating form-floating-outline mb-2">
                                                            <select name="payment_method" id="payment_method_{{ $plan->uuid }}" class="form-select">
                                                                <option value="PIX">Pix</option>
                                                            </select>
                                                            <label for="payment_method_{{ $plan->uuid }}">Forma de Pagamento</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="installments" id="installments" class="form-control" placeholder="Parcelas" value="1" readonly/>
                                                            <label for="installments">Parcelas</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="code" id="code" class="form-control" placeholder="Código"/>
                                                            <label for="code">Código Promocional</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer btn-group">
                                                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success">Avançar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection