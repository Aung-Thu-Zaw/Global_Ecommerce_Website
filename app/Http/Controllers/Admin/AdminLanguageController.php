<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Languages\PermanentlyDeleteAllTrashLanguageAction;
use App\Actions\Admin\Languages\CreateLanguageAction;
use App\Actions\Admin\Languages\UpdateLanguageAction;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminLanguageController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $languages=Language::search(request("search"))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/Languages/Index", compact("languages"));
    }

    public function show(Request $request, Language $language): Response|ResponseFactory
    {
        $json = file_get_contents(resource_path("lang/$language->short_name.json"));

        $jsonData = $json !== false ? json_decode($json, true) : null;

        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/Languages/Details", compact("jsonData", "language", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Languages/Create", compact("per_page"));
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        (new CreateLanguageAction())->handle($request->validated());

        return to_route("admin.languages.index", $this->getQueryStringParams($request))->with("success", "LANGUAGE_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Language $language): Response|ResponseFactory
    {
        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/Languages/Edit", compact("language", "queryStringParams"));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        (new UpdateLanguageAction())->handle($request->validated(), $language);

        return to_route("admin.languages.index", $this->getQueryStringParams($request))->with("success", "LANGUAGE_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        $language->delete();

        return to_route("admin.languages.index", $this->getQueryStringParams($request))->with("success", "LANGUAGE_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashLanguages=Language::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Languages/Trash", compact("trashLanguages"));
    }

    public function restore(Request $request, int $trashLanguageId): RedirectResponse
    {
        $trashLanguage = Language::onlyTrashed()->findOrFail($trashLanguageId);

        $trashLanguage->restore();

        return to_route('admin.languages.trash', $this->getQueryStringParams($request))->with("success", "LANGUAGE_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashLanguageId): RedirectResponse
    {
        $trashLanguage = Language::onlyTrashed()->findOrFail($trashLanguageId);

        unlink(resource_path("lang/$trashLanguage->short_name.json"));

        $trashLanguage->forceDelete();

        return to_route('admin.languages.trash', $this->getQueryStringParams($request))->with("success", "THE_LANGUAGE_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashLanguages = Language::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashLanguageAction())->handle($trashLanguages);

        return to_route('admin.languages.trash', $this->getQueryStringParams($request))->with("success", "LANGUAGES_HAVE_BEEN_PERMANENTLY_DELETED");
    }



    // public function updateDetailUpdate(Request $request, Language $language)
    // {
    //     $arr1=[];
    //     $arr2=[];

    //     foreach ($request->key as $value) {
    //         $arr1[]=$value;
    //     }

    //     foreach ($request->value as $value) {
    //         $arr2[]=$value;
    //     }


    //     for ($i=0;$i<count($arr1);$i++) {
    //         $data[$arr1[$i]]=$arr2[$i];
    //     }


    //     $encodeJson=json_encode($data, JSON_PRETTY_PRINT);

    //     file_put_contents(resource_path("lang/$language->short_name.json"), $encodeJson);

    //     return to_route("admin.languages.index")->with("success", "Language Details is updated successfully");
    // }
}
