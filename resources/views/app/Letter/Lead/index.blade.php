@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="kanban-add-new-board mb-5">
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Adicionar</span>
            </a>
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Filtrar</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('created-lead') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome" required/>
                                        <label for="name">Nome</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="email" name="email" class="form-control" placeholder="E-mail"/>
                                        <label for="email">E-mail</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="phone" name="phone" class="form-control phone" oninput="maskPhone(this)" placeholder="Telefone"/>
                                        <label for="phone">Telefone</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="type" id="type" class="select2 form-select">
                                                <option value="free">Opções</option>
                                                <option value="subscriber">Assinante</option>
                                                <option value="free">Gratuito</option>
                                                <option value="guest">Convidado</option>
                                            </select>
                                        </div>
                                        <label for="type">Tipo</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="group_id" id="group_id" class="select2 form-select">
                                                <option value="  ">Opções</option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="group_id">Grupo</label>
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

        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('leads') }}" method="GET">
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
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nome"/>
                                        <label for="name">Nome</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="E-mail"/>
                                        <label for="email">E-mail</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone"/>
                                        <label for="phone">Telefone</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="type" id="type" class="select2 form-select">
                                                <option value="  ">Opções</option>
                                                <option value="subscriber">Assinante</option>
                                                <option value="free">Gratuito</option>
                                                <option value="guest">Convidado</option>
                                            </select>
                                        </div>
                                        <label for="type">Tipo</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="group_id" id="group_id" class="select2 form-select">
                                                <option value="  ">Opções</option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label for="group_id">Grupo</label>
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
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($leads as $lead)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $lead->name }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-success me-1"></span>
                                            <small class="me-3">{{ $lead->email }}</small>
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small class="me-3">{{ $lead->maskPhone() }}</small>
                                            <span class="badge badge-dot bg-warning me-1"></span>
                                            <small class="me-3">{{ $lead->typeLabel() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-lead', ['uuid' => $lead->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" onclick="onClip('{{ $lead->email }}')" class="btn btn-info text-white btn-sm" title="Copiar E-mail"><i class="ri-file-copy-line"></i></button>
                                    <button type="button" class="btn btn-success text-white btn-sm" title="Editar Token" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $lead->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div> 

                    <div class="modal fade" id="updatedModal{{ $lead->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-lead', ['uuid' => $lead->uuid]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLegenda1">Dados</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome" value="{{ $lead->name }}"/>
                                                    <label for="name">Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="email" name="email" class="form-control" placeholder="E-mail" value="{{ $lead->email }}"/>
                                                    <label for="email">E-mail</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="phone" name="phone" class="form-control phone" oninput="maskPhone(this)" placeholder="Telefone" value="{{ $lead->phone }}"/>
                                                    <label for="phone">Telefone</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="type" id="type" class="select2 form-select">
                                                            <option value="free">Opções</option>
                                                            <option value="subscriber" @selected($lead->type == 'subscriber')>Assinante</option>
                                                            <option value="free" @selected($lead->type == 'free')>Gratuito</option>
                                                            <option value="guest" @selected($lead->type == 'guest')>Convidado</option>
                                                        </select>
                                                    </div>
                                                    <label for="type">Tipo</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="group_id" id="group_id" class="select2 form-select">
                                                            <option value="  ">Opções</option>
                                                            @foreach ($groups as $group)
                                                                <option value="{{ $group->id }}" @selected($lead->group_id == $group->id)>{{ $group->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="group_id">Grupo</label>
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
            <div class="card-footer">
                {{ $leads->links() }}
            </div>
        </div>
    </div>

@endsection