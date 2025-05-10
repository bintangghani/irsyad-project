<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSetting;
use App\Http\Requests\SiteSettingRequest;
use App\Http\Requests\SiteSettingsRequest;
use App\Models\SiteSettings;
use RealRashid\SweetAlert\Facades\Alert;

class SiteSettingsController extends Controller
{
    public function index()
    {
        if (!haveAccessTo('view_site_settings')) {
            return redirect()->back();
        }

        $setting = SiteSettings::first();
        return view('pages.admin.site_settings.index', compact('setting'));
    }

    public function edit()
    {
        if (!haveAccessTo('update_site_settings')) {
            return redirect()->back();
        }

        $setting = SiteSettings::first();
        return view('pages.admin.site_settings.edit', compact('setting'));
    }

    public function update(SiteSettingsRequest $request)
    {
        if (!haveAccessTo('update_site_settings')) {
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $setting = SiteSettings::first();

            if ($request->hasFile('icon')) {
                if ($setting->icon && Storage::disk('public')->exists($setting->icon)) {
                    Storage::disk('public')->delete($setting->icon);
                }
                $iconPath = $request->file('icon')->store('site_icons', 'public');
                $setting->icon = $iconPath;
            }

            $setting->title = $request->title;
            $setting->brand = $request->brand;
            $setting->deskripsi = $request->deskripsi;
            $setting->save();

            DB::commit();

            Alert::success('Success', 'Site Setting berhasil diubah');
            return redirect()->route('dashboard.site.index')->with('success', 'Site settings updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update site settings: ' . $e->getMessage());
        }
    }
}
