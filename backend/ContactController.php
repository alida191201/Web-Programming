<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class ContactController extends Controller
{
     public function index()
    {
        return view('contacts');
    }
    public function send(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Devi essere loggato per inviare un messaggio.'
            ], 403);
        }

        // validazione
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        
        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Messaggio inviato con successo!',
            'data' => $contact
        ]);
    }
}
