<?php

namespace App\Http\Controllers\Admin;

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
        Language::create($request->validated());

        $copyData=file_get_contents(resource_path("lang/en.json"));

        file_put_contents(resource_path('lang/'.$request->short_name.'.json'), $copyData);

        return to_route("admin.languages.index", "per_page=$request->per_page")->with("success", "Language has been successfully created.");
    }

    public function edit(Language $language): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Languages/Edit", compact("language", "paginate"));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $language->update($request->validated());

        return to_route("admin.languages.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Language has been successfully updated.");
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        $language->delete();

        return to_route("admin.languages.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Language has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $language = Language::onlyTrashed()->findOrFail($id);

        $language->restore();

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Language has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $language = Language::onlyTrashed()->findOrFail($id);

        unlink(resource_path("lang/$language->short_name.json"));

        $language->forceDelete();

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The language has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $languages = Language::onlyTrashed()->get();

        $languages->each(function ($language) {

            unlink(resource_path("lang/$language->short_name.json"));

            $language->forceDelete();

        });

        return to_route('admin.languages.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Languages have been successfully deleted.");
    }

    public function languageDetail(Language $language): Response|ResponseFactory
    {
        $json = file_get_contents(resource_path("lang/$language->short_name.json"));

        $jsonData = $json !== false ? json_decode($json) : null;

        return inertia("Admin/Languages/Detail", compact("jsonData", "language"));
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
