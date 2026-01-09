@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="kanban-add-new-board mb-5">
            <a href="" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Adicionar</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('created-plan') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Título" required/>
                                        <label for="title">Título</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="caption" id="caption" class="form-control" placeholder="Legenda"/>
                                        <label for="caption">Legenda</label>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="status" id="status" class="select2 form-select">
                                                <option value="true" selected>Ativo</option>
                                                <option value="false">Inativo</option>
                                            </select>
                                        </div>
                                        <label for="status">Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control money" name="value" oninput="maskValue(this)" value="0">
                                        <label>Valor:</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="time" id="time" class="select2 form-select" required>
                                                <option value="Opções Disponíveis" selected>Opções Disponíveis</option>
                                                <option value="free">Gratuito</option>
                                                <option value="monthly">Mensal</option>
                                                <option value="semi-annual">Semestral</option>
                                                <option value="yearly">Anual</option>
                                                <option value="lifetime">vitalício</option>
                                            </select>
                                        </div>
                                        <label for="time">Expiração</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <textarea class="form-control h-px-100" name="description" id="description" placeholder="Notas"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Imagem de Capa</label>
                                        <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer btn-group">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                            <button type="submit" class="btn btn-dark">Enviar</button>
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
                        <h5 class="mb-0">{{ $plans->sum('views') }}</h5>
                        <p class="mb-0">Visitas</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-success rounded">
                        <i class="ri-shopping-cart-line ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">{{ $plans->sum('paid_invoices_count') }}</h5>
                        <p class="mb-0">Assinaturas/Renovações</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-info rounded">
                        <i class="ri-store-2-line ri-24px"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">{{ $plans->count() }}</h5>
                        <p class="mb-0">Planos</p>
                    </div>
                </div>
            </div>
        </div>  
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($plans as $plan)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <img src="{{ $plan->image ? asset('storage/'.$plan->image) : asset('assets/img/avatars/man.png') }}" alt="Imagem do Plano" class="rounded-circle me-3" width="40">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $plan->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-success me-1"></span>
                                            <small>Assinaturas/Renovações: {{ $plan->paid_invoices_count }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>Visitas: {{ $plan->views }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-plan', ['uuid' => $plan->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" class="btn btn-outline-dark btn-sm" title="Editar Plano" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $plan->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Excluir Plano"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updatedModal{{ $plan->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-plan', ['uuid' => $plan->uuid]) }}" method="POST" enctype="multipart/form-data">
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
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Título" value="{{ $plan->title }}"/>
                                                    <label for="title">Título</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="caption" id="caption" class="form-control" placeholder="Legenda" value="{{ $plan->caption }}"/>
                                                    <label for="caption">Legenda</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="status" id="status" class="select2 form-select">
                                                            <option value="true" @selected($plan->status == 1)>Ativo</option>
                                                            <option value="false" @selected($plan->status != 1)>Inativo</option>
                                                        </select>
                                                    </div>
                                                    <label for="status">Status</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control money" name="value" oninput="maskValue(this)" value="{{ $plan->value }}">
                                                    <label>Valor:</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="time" id="time" class="select2 form-select" required>
                                                            <option value="Opções Disponíveis" selected>Opções Disponíveis</option>
                                                            <option value="free" @selected($plan->time == 'free')>Gratuito</option>
                                                            <option value="monthly" @selected($plan->time == 'monthly')>Mensal</option>
                                                            <option value="semi-annual" @selected($plan->time == 'semi-annual')>Semestral</option>
                                                            <option value="yearly" @selected($plan->time == 'yearly')>Anual</option>
                                                            <option value="lifetime" @selected($plan->time == 'lifetime')>vitalício</option>
                                                        </select>
                                                    </div>
                                                    <label for="time">Expiração</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <textarea class="form-control h-px-100" name="description" id="description" placeholder="Notas">{{ $plan->description }}</textarea>
                                                    <label for="description">Descrição</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="mb-4">
                                                    <label for="image" class="form-label">Imagem de Capa</label>
                                                    <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer btn-group">
                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                                        <button type="submit" class="btn btn-dark">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card-footer text-center">
                {{ $plans->links() }}
            </div>
        </div>
    </div>

@endsection