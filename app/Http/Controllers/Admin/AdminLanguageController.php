<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Languages\CreateLanguageAction;
use App\Actions\Admin\Languages\UpdateLanguageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminLanguageController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $languages=Language::search(request("search"))
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/Languages/Index", compact("languages"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Languages/Create", compact("per_page"));
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        (new CreateLanguageAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.languages.index", $urlStringQuery)->with("success", "Language has been successfully created.");
    }

    public function edit(Request $request, Language $language): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Languages/Edit", compact("language", "queryStringParams"));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        (new UpdateLanguageAction())->handle($request->validated(), $language);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.languages.index", $urlStringQuery)->with("success", "Language has been successfully updated.");
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        $language->delete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.languages.index", $urlStringQuery)->with("success", "Language has been successfully deleted.");
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
        $language = Language::onlyTrashed()->findOrFail($trashLanguageId);

        $language->restore();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.languages.trash', $urlStringQuery)->with("success", "Language has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashLanguageId): RedirectResponse
    {
        $language = Language::onlyTrashed()->findOrFail($trashLanguageId);

        unlink(resource_path("lang/$language->short_name.json"));

        $language->forceDelete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.languages.trash', $urlStringQuery)->with("success", "The language has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $languages = Language::onlyTrashed()->get();

        $languages->each(function ($language) {

            unlink(resource_path("lang/$language->short_name.json"));

            $language->forceDelete();

        });

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.languages.trash', $urlStringQuery)->with("success", "Languages have been successfully deleted.");
    }

    public function languageDetail(Request $request, Language $language): Response|ResponseFactory
    {
        $json = file_get_contents(resource_path("lang/$language->short_name.json"));

        $jsonData = $json !== false ? json_decode($json, true) : null;

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Languages/Detail", compact("jsonData", "language", "queryStringParams"));
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
