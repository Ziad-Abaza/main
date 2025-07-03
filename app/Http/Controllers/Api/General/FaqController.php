<?php
namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index() {
        return response()->json(Faq::all());
    }
    public function show(Faq $faq) {
        return response()->json($faq);
    }
}
