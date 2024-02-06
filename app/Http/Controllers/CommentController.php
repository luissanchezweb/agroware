<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /*
    *Función para crear comentarios
    */
    public function store($id)
    {
        $issue = Issue::find($id);

        //validation
        request()->validate([
            'comment' => 'required'
        ]);

        //add a comment to incidencia
        $issue->comments()->create([
            'user_id' => request()->user()->id,
            'issue_id' => request(),
            'comment' => request('comment')
        ]);

        return back();
    }
}
