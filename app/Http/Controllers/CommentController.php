<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $opportunity->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return redirect()->route('opportunities.show', $opportunity)
            ->with('success', 'Commentaire ajouté.');
    }
}
