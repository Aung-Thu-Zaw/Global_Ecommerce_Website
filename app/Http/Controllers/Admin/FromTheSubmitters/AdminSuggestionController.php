<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Actions\Admin\FromTheSubmitters\Suggestions\PermanentlyDeleteAllTrashSuggestionsAction;
use App\Actions\Admin\FromTheSubmitters\Suggestions\PermanentlyDeleteTrashSuggestionsAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Suggestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminSuggestionController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $suggestions = Suggestion::search(request('search'))
                                 ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                 ->paginate(request('per_page', 10))
                                 ->appends(request()->all());

        return inertia('Admin/FromTheSubmitters/Suggestions/Index', compact('suggestions'));
    }

    public function show(Request $request, Suggestion $suggestion): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $suggestion->load('images');

        return inertia('Admin/FromTheSubmitters/Suggestions/Detail', compact('suggestion', 'queryStringParams'));
    }

    public function destroy(Request $request, Suggestion $suggestion): RedirectResponse
    {
        $suggestion->delete();

        return to_route('admin.suggestions.index', $this->getQueryStringParams($request))->with('success', 'SUGGESTION_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSuggestions = Suggestion::search(request('search'))
                                      ->onlyTrashed()
                                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                      ->paginate(request('per_page', 10))
                                      ->appends(request()->all());

        return inertia('Admin/FromTheSubmitters/Suggestions/Trash', compact('trashSuggestions'));
    }

    public function restore(Request $request, int $trashSuggestionId): RedirectResponse
    {
        $trashSuggestion = Suggestion::onlyTrashed()->findOrFail($trashSuggestionId);

        $trashSuggestion->restore();

        return to_route('admin.suggestions.trash', $this->getQueryStringParams($request))->with('success', 'SUGGESTION_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashSuggestionId): RedirectResponse
    {
        $trashSuggestion = Suggestion::onlyTrashed()->findOrFail($trashSuggestionId);

        (new PermanentlyDeleteTrashSuggestionsAction())->handle($trashSuggestion);

        return to_route('admin.suggestions.trash', $this->getQueryStringParams($request))->with('success', 'THE_SUGGESTION_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSuggestions = Suggestion::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashSuggestionsAction())->handle($trashSuggestions);

        return to_route('admin.suggestions.trash', $this->getQueryStringParams($request))->with('success', 'SUGGESTIONS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
