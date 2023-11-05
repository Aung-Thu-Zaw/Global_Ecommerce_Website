<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request): RedirectResponse
    {
        $locale = $request->input('locale');

        $languages = DB::table('languages')->pluck('short_name')->toArray();

        if (in_array($locale, $languages)) {
            Cache::flush();
            Session::put('locale', $locale);
        }

        return back();
    }
}
