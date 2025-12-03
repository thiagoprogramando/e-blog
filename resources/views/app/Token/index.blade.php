@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="kanban-add-new-board mb-5">
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Gerar Token</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('created-token') }}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados do Token</h4>
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
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <textarea class="form-control h-px-100" name="description" id="description" placeholder="Descrição"></textarea>
                                        <label for="description">Descrição</label>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="url" id="url" class="form-control" placeholder="URL (Serão aceitos apenas requisições)"/>
                                        <label for="url">URL (Serão aceitos apenas requisições)</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="ip" id="ip" class="form-control" placeholder="IP"/>
                                        <label for="ip">IP</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Senha (Será necessário enviar a senha para autenticação)"/>
                                        <label for="password">Senha (Será necessário enviar a senha para autenticação)</label>
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
                @foreach ($tokens as $token)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $token->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-dark me-1"></span>
                                            <small>{{ $token->url }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>{{ $token->description }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-token', ['token' => $token->token]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" onclick="onClip('{{ $token->token }}')" class="btn btn-info text-white btn-sm" title="Copiar Token"><i class="ri-file-copy-line"></i></button>
                                    <button type="button" class="btn btn-success text-white btn-sm" title="Editar Token" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $token->token }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Excluir Token"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updatedModal{{ $token->token }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-token', ['token' => $token->token]) }}" method="POST">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLegenda1">Dados do TOKEN</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="token" class="form-control" placeholder="Token" value="{{ $token->token }}" readonly/>
                                                    <label for="token">Token</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Título" value="{{ $token->title }}"/>
                                                    <label for="title">Título</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <textarea class="form-control h-px-100" name="description" id="description" placeholder="Descrição">{{ $token->description }}</textarea>
                                                    <label for="description">Descrição</label>
                                                </div>
                                            </div>
                                           
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="url" id="url" class="form-control" placeholder="URL (Serão aceitos apenas requisições)" value="{{ $token->url }}"/>
                                                    <label for="url">URL (Serão aceitos apenas requisições)</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="ip" id="ip" class="form-control" placeholder="IP" value="{{ $token->ip }}"/>
                                                    <label for="ip">IP</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha (Será necessário enviar a senha para autenticação)"/>
                                                    <label for="password">Senha (Será necessário enviar a senha para autenticação)</label>
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
                Não há mais dados a serem exibidos.
            </div>
        </div>
    </div>

@endsection