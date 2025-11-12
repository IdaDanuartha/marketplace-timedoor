<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebSetting\UpdateWebSettingRequest;
use App\Interfaces\WebSettingRepositoryInterface;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Gate;

class WebSettingController extends Controller
{
    public function __construct(
        protected readonly WebSettingRepositoryInterface $webSetting
    ) {}

    public function index()
    {
        Gate::authorize('viewAny', WebSetting::class);
        $settings = $this->webSetting->allGrouped();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateWebSettingRequest $request)
    {
        Gate::authorize('update', WebSetting::class);
        $this->webSetting->update($request);
        return back()->with('success', 'Settings updated successfully!');
    }
}