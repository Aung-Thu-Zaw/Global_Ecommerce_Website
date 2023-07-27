<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminSuggestionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $suggestions=Suggestion::search(request("search"))
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(request("per_page", 10))
                               ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/Suggestions/Index", compact("suggestions"));
    }

    public function show(Suggestion $suggestion): Response|ResponseFactory
    {
        $queryParameters=["page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        $suggestion->load("images");

        return inertia("Admin/FromTheSubmitters/Suggestions/Details", compact("suggestion", "queryParameters"));
    }

    public function destroy(Suggestion $suggestion): RedirectResponse
    {
        $suggestion->delete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route("admin.suggestions.index", $urlStringQuery)->with("success", "Suggestion has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSuggestions=Suggestion::search(request("search"))
                                    ->onlyTrashed()
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/Suggestions/Trash", compact("trashSuggestions"));
    }

    public function restore(int $suggestionId): RedirectResponse
    {
        $suggestion = Suggestion::onlyTrashed()->findOrFail($suggestionId);

        $suggestion->restore();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.suggestions.trash', $urlStringQuery)->with("success", "Suggestion has been successfully restored.");
    }

    public function forceDelete(int $suggestionId): RedirectResponse
    {
        $suggestion = Suggestion::onlyTrashed()->findOrFail($suggestionId);

        $multiImages=Image::where("suggestion_id", $suggestion->id)->get();

        $multiImages->each(function ($image) {
            Image::deleteImage($image);
        });

        $suggestion->forceDelete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.suggestions.trash', $urlStringQuery)->with("success", "Suggestion has been permanently deleted.");
    }

    public function permanentlyDelete(): RedirectResponse
    {
        $suggestions = Suggestion::onlyTrashed()->get();

        $suggestions->each(function ($suggestion) {

            $multiImages=Image::where("suggestion_id", $suggestion->id)->get();

            $multiImages->each(function ($image) {
                Image::deleteImage($image);
            });

            $suggestion->forceDelete();

        });

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.suggestions.trash', $urlStringQuery)->with("success", "Suggestions have been successfully deleted.");
    }
}
