<?php
namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
        $contact = Contact::create($validated);
        return response()->json(['success' => true, 'message' => 'Message sent successfully.']);
    }
}
