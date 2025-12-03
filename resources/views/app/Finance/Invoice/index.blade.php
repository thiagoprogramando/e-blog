@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="kanban-add-new-board mb-5">
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Filtro</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('invoices') }}" method="GET">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados da Pesquisa</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Título"/>
                                        <label for="title">Título</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="plan_id" id="plan_id" class="select2 form-select">
                                                <option value="---" selected>Opções Disponíveis</option>
                                                @foreach ($plans as $plan)
                                                    <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="plan_id">Planos</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="payment_status" id="payment_status" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                <option value="paid">Paga</option>
                                                <option value="pending">Pendente</option>
                                                <option value="canceled">Cancelado</option>
                                                <option value="overdue">Atrasado</option>
                                            </select>
                                        </div>
                                        <label for="payment_status">Situação</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" name="payment_due_date" id="payment_due_date" class="form-control" placeholder="Data"/>
                                        <label for="payment_due_date">Data</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="user_id" id="user_id" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="user_id">Usuário</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                            <button type="submit" class="btn btn-success">Pesquisar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Visão Geral</h5>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="salesOverview" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesOverview">
                            <button type="button" class="dropdown-item waves-effect" onclick="location.reload(true)">Atualizar</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center card-subtitle">
                    <div class="me-2">Os dados são atualizados automáticamente.</div>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between flex-wrap gap-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded">
                            <i class="ri-eye-line ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">{{ $invoices->count() }}</h5>
                        <p class="mb-0">Faturas</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-success rounded">
                            <i class="ri-money-dollar-circle-line ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">R$ {{ number_format($invoices->sum('value'), 2, ',', '.') }}</h5>
                        <p class="mb-0">Valor Total</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-info rounded">
                            <i class="ri-hand-coin-line" ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">R$ {{ number_format($invoices->where('payment_status', '!=', 'paid')->sum('value'), 2, ',', '.') }}</h5>
                        <p class="mb-0">Valor Pendente</p>
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($invoices as $invoice)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $invoice->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-dark me-1"></span>
                                            <small>R$ {{ number_format($invoice->value, 2, ',', '.') }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>{{ $invoice->statusLabel() }} | {{ \Carbon\Carbon::parse($invoice->payment_due_date)->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-invoice', ['uuid' => $invoice->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" class="btn btn-success text-white btn-sm" title="Editar Fatura" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $invoice->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir Fatura"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updatedModal{{ $invoice->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-invoice', ['uuid' => $invoice->uuid]) }}" method="POST">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLegenda1">Dados do Plano</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Título" value="{{ $invoice->title }}"/>
                                                    <label for="title">Título</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="value" id="value" class="form-control money" oninput="maskValue(this)" placeholder="Título" value="{{ $invoice->value }}"/>
                                                    <label for="value">Valor</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="date" name="payment_due_date" id="payment_due_date" class="form-control" placeholder="Data" value="{{ $invoice->payment_due_date }}"/>
                                                    <label for="payment_due_date">Data</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="plan_id" id="plan_id" class="select2 form-select">
                                                            <option value="---" selected>Opções Disponíveis</option>
                                                            @foreach ($plans as $plan)
                                                                <option value="{{ $plan->id }}" @selected($invoice->plan_id == $plan->id)>{{ $plan->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="plan_id">Planos</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="payment_status" id="payment_status" class="select2 form-select" required>
                                                            <option value="---" selected>Opções Disponíveis</option>
                                                            <option value="paid" @selected($invoice->payment_status == 'paid')>Paga</option>
                                                            <option value="pending" @selected($invoice->payment_status == 'pending')>Pendente</option>
                                                            <option value="canceled" @selected($invoice->payment_status == 'canceled')>Cancelado</option>
                                                            <option value="overdue" @selected($invoice->payment_status == 'overdue')>Atrasado</option>
                                                        </select>
                                                    </div>
                                                    <label for="payment_status">Situação</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer btn-group">
                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card-footer text-center">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

@endsection