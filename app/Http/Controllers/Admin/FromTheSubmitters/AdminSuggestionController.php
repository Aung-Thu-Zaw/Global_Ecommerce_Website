<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $suggestion->load("images");

        return inertia("Admin/FromTheSubmitters/Suggestions/Details", compact("suggestion", "paginate"));
    }

    public function destroy(Request $request, Suggestion $suggestion): RedirectResponse
    {
        $suggestion->delete();

        return to_route("admin.suggestions.index", "page=$request->page&per_page=$request->per_page")->with("success", "Suggestion has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {

        dd("hit");
        $trashSuggestions=Suggestion::search(request("search"))
                                    ->onlyTrashed()
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/Suggestions/Trash", compact("trashSuggestions"));
    }

    public function restore(Request $request, int $suggestionId): RedirectResponse
    {
        $suggestion = Suggestion::onlyTrashed()->findOrFail($suggestionId);

        $suggestion->restore();

        return to_route('admin.suggestions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Suggestion has been successfully restored.");
    }

    public function forceDelete(Request $request, int $suggestionId): RedirectResponse
    {
        $suggestion = Suggestion::onlyTrashed()->findOrFail($suggestionId);

        $multiImages=Image::where("suggestion_id", $suggestion->id)->get();

        $multiImages->each(function ($image) {
            Image::deleteImage($image);
        });

        $suggestion->forceDelete();

        return to_route('admin.suggestions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Suggestion has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $suggestions = Suggestion::onlyTrashed()->get();

        $suggestions->each(function ($suggestion) {

            $multiImages=Image::where("suggestion_id", $suggestion->id)->get();

            $multiImages->each(function ($image) {
                Image::deleteImage($image);
            });

            $suggestion->forceDelete();

        });
        return to_route('admin.suggestions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Suggestions have been successfully deleted.");
    }
}
