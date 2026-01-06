@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="kanban-add-new-board mb-5">
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Novo</span>
            </a>
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Filtro</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('created-coupon') }}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados do CUPOM</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Código"/>
                                        <label for="code">Código (Deixe vazio para criar automáticamente)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <textarea class="form-control h-px-100" name="description" id="description" placeholder="Descrição"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="status" id="status" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                <option value="1">Ativo</option>
                                                <option value="2">Inativo</option>
                                            </select>
                                        </div>
                                        <label for="status">Situação</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantidade"/>
                                        <label for="quantity">Quantidade</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="discount_amount" id="discount_amount" class="form-control money" oninput="maskValue(this)" placeholder="Valor do Desconto"/>
                                        <label for="discount_amount">Desconto (R$)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="discount_percent" id="discount_percent" class="form-control" oninput="maskPerformance(this)" placeholder="Porcentagem de Desconto"/>
                                        <label for="discount_percent">Desconto (%)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="user_id" id="user_id" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="user_id">Usuário (Opcional)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                            <button type="submit" class="btn btn-dark">Confirmar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('coupons') }}" method="GET">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados do CUPOM</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="code" id="code" class="form-control" placeholder="Código"/>
                                        <label for="code">Código</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="status" id="status" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                <option value="1">Ativo</option>
                                                <option value="2">Inativo</option>
                                            </select>
                                        </div>
                                        <label for="status">Situação</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantidade"/>
                                        <label for="quantity">Quantidade</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="discount_amount" id="discount_amount" class="form-control money" oninput="maskValue(this)" placeholder="Valor do Desconto"/>
                                        <label for="discount_amount">Desconto (R$)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="discount_percent" id="discount_percent" class="form-control" oninput="maskPerformance(this)" placeholder="Porcentagem de Desconto"/>
                                        <label for="discount_percent">Desconto (%)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="user_id" id="user_id" class="select2 form-select" required>
                                                <option value="---" selected>Opções Disponíveis</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="user_id">Usuário (Opcional)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                            <button type="submit" class="btn btn-dark">Pesquisar</button>
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
                        <h5 class="mb-0">{{ $coupons->count() }}</h5>
                        <p class="mb-0">Cupons</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-success rounded">
                            <i class="ri-money-dollar-circle-line ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">R$ {{ number_format($coupons->sum('discount_amount'), 2, ',', '.') }}</h5>
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
                        <h5 class="mb-0">{{ number_format($coupons->where('status', 2)->sum('discount_amount'), 2, ',', '.') }}</h5>
                        <p class="mb-0">Valor Total Pendentes</p>
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($coupons as $coupon)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $coupon->code }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-dark me-1"></span>
                                            <small>
                                                R$ {{ number_format($coupon->discount_amount, 2, ',', '.') }} | 
                                                {{ number_format($coupon->discount_percent, 2, ',', '.') }}% |
                                                Disponiveis: {{ $coupon->quantity }}
                                            </small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>{{ $coupon->statusLabel() }} | {{ \Carbon\Carbon::parse($coupon->created_at)->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-coupon', ['uuid' => $coupon->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" class="btn btn-outline-dark btn-sm" title="Copiar Código" onclick="onClip('{{ $coupon->code }}')"><i class="ri-file-copy-line"></i></button>
                                    <button type="button" class="btn btn-outline-dark btn-sm" title="Editar CUPOM" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $coupon->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Excluir CUPOM"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updatedModal{{ $coupon->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-coupon', ['uuid' => $coupon->uuid]) }}" method="POST">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLegenda1">Dados do CUPOM</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="code" id="code" class="form-control" placeholder="Código" value="{{ $coupon->code }}" readonly/>
                                                    <label for="code">Código</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <textarea class="form-control h-px-100" name="description" id="description" placeholder="Descrição">{{ $coupon->description }}</textarea>
                                                    <label for="description">Descrição</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="status" id="status" class="select2 form-select" required>
                                                            <option value="---" selected>Opções Disponíveis</option>
                                                            <option value="1" @selected($coupon->status == 1)>Ativo</option>
                                                            <option value="2" @selected($coupon->status == 2)>Inativo</option>
                                                        </select>
                                                    </div>
                                                    <label for="status">Situação</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantidade" value="{{ $coupon->quantity }}"/>
                                                    <label for="quantity">Quantidade</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control money" oninput="maskValue(this)" placeholder="Valor do Desconto" value="{{ $coupon->discount_amount }}"/>
                                                    <label for="discount_amount">Desconto (R$)</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="discount_percent" id="discount_percent" class="form-control performance" oninput="maskPerformance(this)" placeholder="Porcentagem de Desconto" value="{{ $coupon->discount_percent }}"/>
                                                    <label for="discount_percent">Desconto (%)</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="user_id" id="user_id" class="select2 form-select" required>
                                                            <option value="---" selected>Opções Disponíveis</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @selected($user->id == $coupon->user_id)>{{ $user->name }} ({{ $user->email }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="user_id">Usuário (Opcional)</label>
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
                {{ $coupons->links() }}
            </div>
        </div>
    </div>

@endsection