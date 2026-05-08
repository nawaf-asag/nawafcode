<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    private const SUPPORTED = ['ar', 'en'];

    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (in_array($locale, self::SUPPORTED, true)) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
