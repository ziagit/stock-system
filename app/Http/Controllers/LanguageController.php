<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function update(Request $request)
    {
        $language = $request->input('language');
        // Update the language setting in the user's session
        Session::put('locale', $language);
        return response()->json(['reload' => true]);
    }
}
