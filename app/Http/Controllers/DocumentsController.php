<?php

namespace App\Http\Controllers;

use App\Models\B24Documents;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentsController extends Controller
{

    public function index(Request $request): View
    {
        $user = $request->user();
        $documents = B24Documents::find($user->documents_id);
        return view('documents', compact('user', 'documents'));
    }
}
