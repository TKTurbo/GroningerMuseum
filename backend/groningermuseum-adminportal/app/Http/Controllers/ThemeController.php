<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function show_main()
    {
        // Get all the themes.
        $themes = Theme::all();

        return view('themes.main', [
            'themes' => $themes
        ]);

    }
}
