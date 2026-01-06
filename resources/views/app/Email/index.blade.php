@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-7 col-lg-7">
        <div class="kanban-add-new-board mb-5">
            <a href="#" class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Nova Integração</span>
            </a>
        </div>

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('created-email') }}" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Configuração do E-mail</h4>
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
                                        <input type="text" name="from_name" id="from_name" class="form-control" placeholder="Ex João Grandão"/>
                                        <label for="from_name">Nome</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="from_email" id="from_email" class="form-control" placeholder="Ex suporte@eblog.com"/>
                                        <label for="from_email">Email</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <div class="select2-primary">
                                            <select name="smtp_encryption" id="smtp_encryption" class="select2 form-select">
                                                <option value="SSL">Opções</option>
                                                <option value="SSL">SSL</option>
                                                <option value="TLS">TLS</option>
                                            </select>
                                        </div>
                                        <label for="smtp_encryption">Criptografia</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" value="true" id="is_default" name="is_default">
                                        <label class="form-check-label" for="is_default"> Padrão </label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="smtp_host" id="smtp_host" class="form-control" placeholder="IP ou URL"/>
                                        <label for="smtp_host">SMTP</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="smtp_port" id="smtp_port" class="form-control" placeholder="Ex 864"/>
                                        <label for="smtp_port">Port</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="smtp_username" id="smtp_username" class="form-control" placeholder="Ex suporte@eblog.com"/>
                                        <label for="smtp_username">SMTP Email</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="smtp_password" id="smtp_password" class="form-control" placeholder="******"/>
                                        <label for="smtp_password">SMTP Senha</label>
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
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($emails as $email)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $email->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>{{ $email->smtp_host }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-dark me-1"></span>
                                            <small>{{ $email->smtp_username }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-email', ['uuid' => $email->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" class="btn btn-outline-dark text-white btn-sm" title="Editar Email" data-bs-toggle="modal" data-bs-target="#updatedModal{{ $email->uuid }}"><i class="ri-menu-search-line"></i></button>
                                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Excluir Email"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updatedModal{{ $email->uuid }}" tabindex="-1" aria-hidden="true">
                        <form action="{{ route('updated-email', ['uuid' => $email->uuid]) }}" method="POST">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLegenda1">Configurações do E-mail</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Título" value="{{ $email->title }}"/>
                                                    <label for="title">Título</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="from_name" id="from_name" class="form-control" placeholder="Ex João Grandão" value="{{ $email->from_name }}"/>
                                                    <label for="from_name">Nome</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="from_email" id="from_email" class="form-control" placeholder="Ex suporte@eblog.com" value="{{ $email->from_email }}"/>
                                                    <label for="from_email">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <div class="select2-primary">
                                                        <select name="smtp_encryption" id="smtp_encryption" class="select2 form-select">
                                                            <option value="SSL">Opções</option>
                                                            <option value="SSL" @selected($email->smtp_encryption === 'SSL')>SSL</option>
                                                            <option value="TLS" @selected($email->smtp_encryption === 'TLS')>TLS</option>
                                                        </select>
                                                    </div>
                                                    <label for="smtp_encryption">Criptografia</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-check mt-4">
                                                    <input class="form-check-input" type="checkbox" value="true" id="is_default" name="is_default" @checked($email->is_default)>
                                                    <label class="form-check-label" for="is_default"> Padrão </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="smtp_host" id="smtp_host" class="form-control" placeholder="IP ou URL" value="{{ $email->smtp_host }}"/>
                                                    <label for="smtp_host">SMTP</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="smtp_port" id="smtp_port" class="form-control" placeholder="Ex 864" value="{{ $email->smtp_port }}"/>
                                                    <label for="smtp_port">Port</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="smtp_username" id="smtp_username" class="form-control" placeholder="Ex suporte@eblog.com" value="{{ $email->smtp_username }}"/>
                                                    <label for="smtp_username">SMTP Email</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" name="smtp_password" id="smtp_password" class="form-control" placeholder="******"/>
                                                    <label for="smtp_password">SMTP Senha</label>
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
                @endforeach
            </div>

            <div class="card-footer text-center">
                {{ $emails->links() }}
            </div>
        </div>
    </div>

@endsection