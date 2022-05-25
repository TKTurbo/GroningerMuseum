<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    /**
     * Show the main page for the routes
     *
     * @return view
     */
    public function show_main()
    {
        // Get all the themes.
        $themes = Theme::all();

        return view('themes.main', compact('themes'));

    }
}
