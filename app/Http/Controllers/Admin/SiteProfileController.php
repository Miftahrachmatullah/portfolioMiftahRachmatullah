<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveSiteProfileRequest;
use App\Models\SiteProfile;
use App\Services\SiteProfileWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile', ['profile' => SiteProfile::current()]);
    }

    public function update(SaveSiteProfileRequest $request, SiteProfileWriter $writer): RedirectResponse
    {
        $writer->save($request->validated());

        return to_route('admin.profile.edit')->with('success', 'Hero dan About diperbarui. Perubahan tersedia di landing page.');
    }
}
