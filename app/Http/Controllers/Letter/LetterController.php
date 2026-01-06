<?php

namespace App\Http\Controllers\Letter;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller {
    
    public function index(Request $request) {
        
        $userId = Auth::id();
        $query  = Letter::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                ->orWhere('company_id', $userId);
            })->when($request->filled('status'), fn($q) =>
                $q->where('status', $request->status)
            );

        return view('app.Letter.index', [
            'letters'  => $query->paginate(30)->appends($request->query()),
        ]);
    }

    public function show($uuid) {
        //
    }

    public function store(Request $request) {
        
        return $request;
    }

    public function update(Request $request, $uuid) {
        //
    }

    public function destroy($uuid) {
        //
    }
}
