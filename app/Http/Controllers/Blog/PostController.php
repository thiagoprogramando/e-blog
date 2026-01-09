<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    
    public function index(Request $request) {

        $query = Post::where('company_id', Auth::user()->company_id ?? Auth::user()->uuid);

        if (!empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if (!empty($request->tags)) {
            $query->where('tags', 'like', '%' . $request->tags . '%');
        }

        if (!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if (!empty($request->created_by)) {
            $query->where('created_by', $request->created_by);
        }

        return view('app.Blog.index', [
            'posts' => $query->orderBy('created_at', 'desc')->paginate(30),
        ]);
    }

    public function show($uuid) {

        $post = Post::where('uuid', $uuid)->first();
        if (!$post) {
            return redirect()->route('posts')->with('error', 'Post não encontrado. Verifique os dados e tente novamente!');
        }

        return view('app.Blog.show', [
            'post' => $post,
        ]);
    }

    public function store(Request $request) {

        $post                       = new Post();
        $post->uuid                 = Str::uuid();
        $post->company_id           = Auth::user()->company_id ?? Auth::user()->uuid;
        $post->created_by           = Auth::user()->id;
        $post->title                = $request->title;
        $post->body                 = $request->body;
        $post->tags                 = $request->tags;
        $post->status               = $request->status;
        $post->meta_title           = $request->meta_title;
        $post->meta_description     = $request->meta_description;
        $post->published_at         = $request->published_at;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {
                $path = $file->store('photos', 'public');
                $post->photo = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ((array) $request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'url'  => asset('storage/' . $path),
                    ];
                }
            }

            $post->attachments = json_encode($attachments);
        }

        if ($post->save()) {
            return redirect()->route('posts')->with('success', 'Post criado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Falha ao criar o post. Verifique os dados e tente novamente!');
        }
    }

    public function update(Request $request, $uuid) {

        $post = Post::where('uuid', $uuid)->first();
        if (!$post) {
            return redirect()->route('posts')->with('error', 'Post não encontrado, verifique os dados e tente novamente!');
        }

        if ($request->has('title')) {
            $post->title = $request->title;
        }
        if ($request->has('body')) {
            $post->body = $request->body;
        }
        if ($request->has('tags')) {
            $post->tags = $request->tags;
        }
        if ($request->has('status')) {
            $post->status = $request->status;
        }
        if ($request->has('meta_title')) {
            $post->meta_title = $request->meta_title;
        }
        if ($request->has('meta_description')) {
            $post->meta_description = $request->meta_description;
        }
        if ($request->has('published_at')) {
            $post->published_at = $request->published_at;
        }

        if ($request->hasFile('photo')) {
            
            if ($post->photo) {
                unlink($post->photo);
            }
            
            $file = $request->file('photo');
            if ($file->isValid()) {
                $path = $file->store('photos', 'public');
                $post->photo = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('attachments')) {

            $attachments = json_decode($post->attachments, true) ?? [];
            foreach ((array) $request->file('attachments') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'url'  => asset('storage/' . $path),
                    ];
                }
            }

            $post->attachments = json_encode(array_merge($attachments, json_decode($post->attachments, true) ?? []));
        }

        if ($post->save()) {
            return redirect()->back()->with('success', 'Post atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Falha ao atualizar o post, verifique os dados e tente novamente!');
        }
    }

    public function destroy($uuid) {

        $post = Post::where('uuid', $uuid)->first();
        if ($post && $post->delete()) {
            $attachments = json_decode($post->attachments, true) ?? [];
            foreach ($attachments as $attachment) {
                $fileUrl = $attachment['url'] ?? null;
                if ($fileUrl) {
                    $relativePath   = str_replace(asset('storage') . '/', '', $fileUrl);
                    $path           = public_path('storage/' . $relativePath);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
            return redirect()->route('posts')->with('success', 'Post excluído com sucesso!');
        }

        return redirect()->route('posts')->with('error', 'Erro ao excluir o post. Verifique os dados e tente novamente!');
    }

    public function destroyAttachment(Request $request, $uuid) {

        $post = Post::where('uuid', $uuid)->first();
        if (!$post) {
            return response()->json(['error' => 'Post não encontrado.'], 404);
        }

        $attachments = json_decode($post->attachments, true) ?? [];
        $updatedAttachments = [];

        foreach ($attachments as $attachment) {
            if ($attachment['url'] !== $request->attachment_url) {
            $updatedAttachments[] = $attachment;
            } else {
            $path = str_replace(url('storage'), storage_path('app/public'), $attachment['url']);
            if (file_exists($path)) {
                unlink($path);
            }
            }
        }

        $post->attachments = json_encode($updatedAttachments);
        if ($post->save()) {
            return redirect()->back()->with('success', 'Anexo removido com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao remover o anexo.');
    }
}
