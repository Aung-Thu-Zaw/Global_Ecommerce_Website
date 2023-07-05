<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchHistoryController extends Controller
{
    public function destroy(): RedirectResponse
    {
        $searchHistories=SearchHistory::all();

        $searchHistories->each(function ($searchHistory) {
            $searchHistory->delete();
        });

        return back();
    }
}
