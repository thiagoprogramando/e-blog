@extends('app.layout')
@section('content')

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}"/>

    <div class="col-12 col-sm-12 col-md-8 col-lg-8">
        <div class="kanban-add-new-board mb-5">
            <a class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#createdModal">
                <i class="ri-add-line"></i>
                <span class="align-middle">Adicionar</span>
            </a>
            <label class="kanban-add-board-btn" for="kanban-add-board-input" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="ri-filter-line"></i>
                <span class="align-middle">Filtrar</span>
            </label>
        </div> 

        <div class="modal fade" id="createdModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('created-post') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="createdPost">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalFullTitle">Nova Publicação</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="file" id="photo" name="photo" multiple class="form-control" placeholder="Imagem de Capa"/>
                                    <label for="photo">Imagem de Capa</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline mb-2">
                                    <input type="text" class="form-control" name="title" placeholder="Ex: Como viajar para o Japão?" required/>
                                    <label>Título</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline mb-2">
                                    <div class="select2-primary">
                                        <select name="status" id="status" class="select2 form-select" required>
                                            <option value="published">Público</option>
                                            <option value="draft">Rascunho</option>
                                            <option value="archived">Arquivado</option>
                                        </select>
                                    </div>
                                    <label for="status">Status</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline mb-2">
                                    <input type="date" class="form-control" name="published_at" placeholder="Ex: 10/10/2025"/>
                                    <label>Data de Publicação</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                                <div class="full-editor">
                                    <h6>Conteúdo do POST</h6>
                                </div>
                                <textarea name="body" id="body" hidden></textarea>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <input id="TagifyCustomInlineSuggestion" name="tags" class="form-control h-auto" placeholder="Aperte Enter após escrever" value=""/>
                                    <label for="TagifyCustomInlineSuggestion">Tags</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="file" id="attachments" name="attachments[]" multiple class="form-control" placeholder="Anexos"/>
                                    <label for="attachments">Anexos</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <a class="btn btn-dark mt-3 me-1" data-bs-toggle="collapse" href="#collapseMeta" role="button" aria-expanded="false" aria-controls="collapseMeta">Configurar Meta Tags</a>

                                <div class="collapse mt-2" id="collapseMeta">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline mb-2">
                                                <input type="text" class="form-control" name="meta_title" placeholder="como-viajar-para-o-japao"/>
                                                <label>Meta Título</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline mb-2">
                                                <input type="text" class="form-control" name="meta_description" placeholder="descubra como viajar do brasil para o joão"/>
                                                <label>Meta Descrição</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                        <button type="submit" class="btn btn-dark">Publicar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('posts') }}" method="GET" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalFullTitle">Filtrar</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline mb-2">
                                    <input type="text" class="form-control" name="title" placeholder="Ex: Como viajar para o Japão?"/>
                                    <label>Título</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline mb-2">
                                    <div class="select2-primary">
                                        <select name="status" id="status" class="select2 form-select">
                                            <option value="published">Público</option>
                                            <option value="draft">Rascunho</option>
                                            <option value="archived">Arquivado</option>
                                        </select>
                                    </div>
                                    <label for="status">Status</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-floating form-floating-outline mb-2">
                                    <input type="date" class="form-control" name="published_at" placeholder="Ex: 10/10/2025"/>
                                    <label>Data de Publicação</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-floating form-floating-outline">
                                    <input id="TagifyCustomInlineSuggestion" name="tags" class="form-control h-auto" placeholder="Aperte Enter após escrever" value=""/>
                                    <label for="TagifyCustomInlineSuggestion">Tags</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal"> Fechar </button>
                        <button type="submit" class="btn btn-dark">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card demo-inline-spacing">
            <div class="list-group p-0 m-0">
                @foreach ($posts as $post)
                    <div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect waves-light">
                        <img src="{{ $post->photo ? asset($post->photo) : asset('assets/img/avatars/man.png') }}" alt="Produto Imagem" class="rounded-3 me-3" width="60">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <h6 class="mb-1 fw-normal">{{ $post->title }}</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-success me-1"></span>
                                            <small>{{ $post->statusLabel() }} |</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-primary me-1"></span>
                                            <small>{{ $post->tagsLabel() }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-danger me-1"></span>
                                            <small>Likes: {{ $post->likes }}</small>
                                        </div>
                                        <div class="user-status me-2 d-flex align-items-center">
                                            <span class="badge badge-dot bg-info me-1"></span>
                                            <small>Visitas: {{ $post->views }}</small>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleted-post', ['uuid' => $post->uuid]) }}" method="POST" class="add-btn delete">
                                    @csrf
                                    <a href="{{ route('post', ['uuid' => $post->uuid]) }}" class="btn btn-outline-dark btn-sm" title="Acessar Conteúdo"><i class="ri-menu-search-line"></i></a>
                                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Excluir Conteúdo"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div> 
                @endforeach
            </div>
            <div class="card-footer">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullToolbar = [
                [
                    { font: [] },
                    { size: [] }
                ],
                ['bold', 'italic', 'underline', 'strike'],
                    [
                    { color: [] },
                    { background: [] }
                ],
                [
                    { script: 'super' },
                    { script: 'sub' }
                ],
                [
                    { header: '1' },
                    { header: '2' },
                    'blockquote',
                    'code-block'
                ],
                [
                    { list: 'ordered' },
                    { list: 'bullet' },
                    { indent: '-1' },
                    { indent: '+1' }
                ],
                [{ direction: 'rtl' }],
                ['link', 'image', 'video', 'formula'],
                ['clean']
            ];

            window.editor = new Quill('.full-editor', {
                bounds: '.full-editor',
                placeholder: 'Digite o conteúdo do POST...',
                modules: {
                    formula: true,
                    toolbar: fullToolbar,
                },
                theme: 'snow'
            });
        });

        document.getElementById('createdPost').addEventListener('submit', function (e) {
            document.getElementById('body').value = window.editor.root.innerHTML.trim();
        });
    </script>
@endsection