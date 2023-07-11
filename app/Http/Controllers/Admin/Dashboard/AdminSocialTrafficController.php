<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SocialTraffic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSocialTrafficController extends Controller
{
    public function changeTarget(Request $request): RedirectResponse
    {
        $socialTraffics = SocialTraffic::all();

        foreach ($socialTraffics as $socialTraffic) {
            $socialName = strtolower($socialTraffic->social_name);

            if ($socialName === 'linked in') {
                $socialName = 'linked_in';
            }

            if ($request->has($socialName)) {
                $targetVisitors = $request->input($socialName);
                $socialTraffic->update(['target_visitors' => $targetVisitors]);
            }
        }

        return back()->with("success", "Change visitor target successfully.");
    }

    public function incrementActualVisitors(SocialTraffic $socialTraffic): RedirectResponse
    {
        $socialTraffic->update(["actual_visitors"=>$socialTraffic->actual_visitors+1]);

        return back();
    }
}
