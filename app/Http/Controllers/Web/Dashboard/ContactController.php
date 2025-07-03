<?php
namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::orderByDesc('created_at')->get();
        return view('dashboard.contact.index', compact('contacts'));
    }
    public function destroy(Contact $contact) {
        $contact->delete();
        return redirect()->route('dashboard.contact.index')->with('success', 'Contact message deleted successfully.');
    }
}
