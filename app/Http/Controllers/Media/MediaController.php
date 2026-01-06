<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller {
    
    public function index(Request $request) {

        $query = Media::query();

        if (!empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $query->where('user_id', Auth::user()->id)->orWhere('company_id', Auth::user()->company_id);

        return view('app.Media.index', [
            'medias' => $query->paginate(30)
        ]);
    }

    public function store(Request $request) {
        
        $request->validate([
            'media' => 'required|file|max:10240',
        ], [
            'media.max' => 'O arquivo não pode ser maior que 10MB!',
        ]);

        if (!$request->hasFile('media') || !$request->file('media')->isValid()) {
            return back()->withErrors(['media' => 'Arquivo inválido']);
        }

        $file = $request->file('media');
        $path = $file->store('medias', 'public');
        $uuid = Str::uuid();

        $media = new Media();
        $media->uuid        = $uuid;
        $media->user_id     = Auth::id();
        $media->company_id  = Auth::user()->company_id ?? Auth::id();
        $media->title       = $request->title ?? $file->getClientOriginalName();
        $media->file        = $path;
        if ($media->save()) {
            return redirect()->back()->with('success', 'Mídia salva com sucesso!');
        }
        return redirect()->back()->with('error', 'Erro ao salvar mídia, tente novamente!');
    }

    public function destroy($uuid) {
        
        $media = Media::where('uuid', $uuid)->first();
        if ($media && $media->delete()) {
            Storage::delete($media->file);
            return redirect()->back()->with('success', 'Mídia excluída com sucesso!');
        }

        return redirect()->back()->with('error', 'Erro ao excluir mídia, tente novamente!');
    }
}
