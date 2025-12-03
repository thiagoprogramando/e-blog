@extends('app.layout')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <h4 class="card-title">{{ $post->title }}</h4>
        <hr>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Dados</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('updated-post', ['uuid' => $post->uuid]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input type="text" class="form-control" name="title" placeholder="Ex: Como viajar para o Japão?" value="{{ $post->title }}"/>
                                        <label>Título</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <div class="select2-primary">
                                            <select name="status" id="status" class="select2 form-select" required>
                                                <option value="published" @selected($post->status == 'published')>Público</option>
                                                <option value="draft" @selected($post->status == 'draft')>Rascunho</option>
                                                <option value="archived" @selected($post->status == 'archived')>Arquivado</option>
                                            </select>
                                        </div>
                                        <label for="status">Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input type="date" class="form-control" name="published_at" placeholder="Ex: 10/10/2025" value="{{ $post->published_at }}"/>
                                        <label>Data de Publicação</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input id="TagifyCustomInlineSuggestion" name="tags" class="form-control h-auto" placeholder="Aperte Enter após escrever" value="{{ $post->tags }}"/>
                                        <label for="TagifyCustomInlineSuggestion">Tags</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <textarea class="form-control h-px-100 editor" name="body" id="body" placeholder="Para viajar ao Japão é necessário uma Passagem...">{{ $post->body }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                    <a class="btn btn-dark mt-3 me-1" data-bs-toggle="collapse" href="#collapseMeta" role="button" aria-expanded="false" aria-controls="collapseMeta">Configurar Meta Tags</a>

                                    <div class="collapse mt-3" id="collapseMeta">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="text" class="form-control" name="meta_title" placeholder="como-viajar-para-o-japao" value="{{ $post->meta_title }}"/>
                                                    <label>Meta Título</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-floating form-floating-outline mb-2">
                                                    <input type="text" class="form-control" name="meta_description" placeholder="descubra como viajar do brasil para o joão" value="{{ $post->meta_description }}"/>
                                                    <label>Meta Descrição</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-1">Salvar</button>
                                <a href="{{ route('posts') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Anexos</h5>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="ri-upload-cloud-line"></i></button>

                        <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('updated-post', ['uuid' => $post->uuid]) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalFullTitle">Arquivos</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="file" id="attachments" name="attachments[]" multiple class="form-control" placeholder="Anexos"/>
                                                    <label for="attachments">Anexos</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"> Fechar </button>
                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Arquivo</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    
                                    @foreach (json_decode($post->attachments) as $attachment)
                                    <tr>
                                        <td>
                                            <a href="{{ $attachment->url }}" target="_blank" class="fw-medium">{{ $attachment->name }}</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('deleted-post-attachment', ['uuid' => $post->uuid]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="attachment_url" value="{{ $attachment->url }}">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/tgezwiu6jalnw1mma8qnoanlxhumuabgmtavb8vap7357t22/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/js/tinymce.js') }}"></script>
@endsection