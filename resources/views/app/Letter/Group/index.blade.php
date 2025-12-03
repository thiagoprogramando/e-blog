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
            <form action="{{ route('created-group') }}" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Nome" required/>
                                        <label for="title">Nome</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <textarea class="form-control h-px-100 editor" name="description" id="description" placeholder="Descrição"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="value" name="value" class="form-control money" oninput="maskValue(this)" placeholder="Valor"/>
                                        <label for="value">Valor</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="type" id="type" class="select2 form-select">
                                                <option value="free">Opções</option>
                                                <option value="signature">Assinatura</option>
                                                <option value="free">Gratuito</option>
                                                <option value="private">Privado</option>
                                            </select>
                                        </div>
                                        <label for="type">Tipo</label>
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
            <form action="{{ route('groups') }}" method="GET">
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
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="type" id="type" class="select2 form-select">
                                                <option value="free">Opções</option>
                                                <option value="signature">Assinatura</option>
                                                <option value="free">Gratuito</option>
                                                <option value="private">Privado</option>
                                            </select>
                                        </div>
                                        <label for="type">Tipo</label>
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
                @foreach ($groups as $group)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $group->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-success me-1"></span>
                                            <small class="me-3" title="{{ $group->description }}">{{ Str::limit($group->description, 60) }}</small>
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small class="me-3">R$ {{ number_format($group->value, 2, ',', '.') }}</small>
                                            <span class="badge badge-dot bg-warning me-1"></span>
                                            <small class="me-3">{{ $group->typeLabel() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-group', ['uuid' => $group->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" onclick="onClip('{{ route('register-lead', ['uuid' => $group->uuid]) }}')" class="btn btn-info text-white btn-sm" title="Copiar Link do Grupo"><i class="ri-file-copy-line"></i></button>
                                    <button type="button" class="btn btn-success text-white btn-sm" title="Editar Grupo" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $group->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div> 

                    <div class="modal fade" id="updatedModal{{ $group->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-group', ['uuid' => $group->uuid]) }}" method="POST" enctype="multipart/form-data">
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
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Nome" value="{{ $group->title }}"/>
                                                    <label for="title">Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <textarea class="form-control h-px-100 editor" name="description" id="description" placeholder="Descrição">{{ $group->description }}</textarea>
                                                    <label for="description">Descrição</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="value" name="value" class="form-control money" oninput="maskValue(this)" placeholder="Valor" value="{{ $group->value }}"/>
                                                    <label for="value">Valor</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="type" id="type" class="select2 form-select">
                                                            <option value="free">Opções</option>
                                                            <option value="signature" @selected($group->type == 'signature')>Assinatura</option>
                                                            <option value="free" @selected($group->type == 'free')>Gratuito</option>
                                                            <option value="private" @selected($group->type == 'private')>Privado</option>
                                                        </select>
                                                    </div>
                                                    <label for="type">Tipo</label>
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
                {{ $groups->links() }}
            </div>
        </div>
    </div>

@endsection