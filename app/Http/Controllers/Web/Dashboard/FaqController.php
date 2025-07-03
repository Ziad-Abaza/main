<?php
namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index() {
        $faqs = Faq::all();
        return view('dashboard.faq.index', compact('faqs'));
    }
    public function create() {
        return view('dashboard.faq.create');
    }
    public function store(Request $request) {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        Faq::create($request->only('question', 'answer'));
        return redirect()->route('dashboard.faq.index')->with('success', 'FAQ created successfully.');
    }
    public function edit(Faq $faq) {
        return view('dashboard.faq.edit', compact('faq'));
    }
    public function update(Request $request, Faq $faq) {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        $faq->update($request->only('question', 'answer'));
        return redirect()->route('dashboard.faq.index')->with('success', 'FAQ updated successfully.');
    }
    public function destroy(Faq $faq) {
        $faq->delete();
        return redirect()->route('dashboard.faq.index')->with('success', 'FAQ deleted successfully.');
    }
}
