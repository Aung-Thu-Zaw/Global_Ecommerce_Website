<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchHistoryController extends Controller
{
    public function update(SearchHistory $searchHistory): RedirectResponse
    {
        $searchHistory->update(["user_id"=>null]);

        return back();
    }
}
