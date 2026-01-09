@extends('app.layout')
@section('content')

    <div class="col-12">
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
            <form action="{{ route('created-media') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLegenda1">Dados do Arquivo</h4>
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
                                        <input type="file" id="media" name="media" class="form-control" placeholder="Mídia"/>
                                        <label for="media">Mídia</label>
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
            <form action="{{ route('medias') }}" method="GET">
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
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Título" required/>
                                        <label for="title">Título</label>
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
    </div>

    <div class="col-12 col-sm-12 col-md-5 col-lg-5">
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($medias as $media)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal"><a href="{{ asset('storage/' . $media->file) }}" target="_blank">{{ $media->title }}</a></h6>
                                </div>
                                <form action="{{ route('deleted-media', ['uuid' => $media->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <button type="button" onclick="onClip('{{ asset('storage/' . $media->file) }}')" class="btn btn-outline-dark btn-sm" title="Copiar URL"><i class="ri-file-copy-line"></i></button>
                                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Excluir Mídia"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div> 
                @endforeach
            </div>
            <div class="card-footer">
                {{ $medias->links() }}
            </div>
        </div>
    </div>
    
@endsection