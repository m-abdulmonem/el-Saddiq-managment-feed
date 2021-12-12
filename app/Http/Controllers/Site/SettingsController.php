<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    protected $folder = "site.dashboard";
    protected $perm = "setting";
    protected $trans = "settings";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => trans("$this->trans.title"),
        ];
        return view("$this->folder.settings",$data);
    }


    /**
     *
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function apps_save()
    {
        $data = $this->validate(request(),[
            'android_app_link' => 'sometimes|nullable|string|url',
            'ios_app_link' => 'sometimes|nullable|string|url',
        ]);
        return settings(false,true,$data)
            ? back()->with("success", trans("settings.Success_update_apps"))
            : back()->with("error", trans("Error_update"));
    }

    public function main_info()
    {

        $data = $this->validate(request(),[
            'name_ar' => 'required',
            'name_en' => 'required',
            'logo' => 'sometimes|nullable',
            'icon' => 'sometimes|nullable',
            'email' => 'sometimes|nullable|email',
            'phone' => 'sometimes|nullable|numeric',
            'description' => 'sometimes|nullable',
            'keywords' => 'sometimes|nullable',
            'status' => 'sometimes|nullable|in:open,close',
            'paginate' => 'integer',
        ]);
        $data['icon'] = image('icon',false,settings('icon'));
        $data['logo'] = image('logo',false,settings('logo'));
        return settings(false,true,$data)
            ? back()->with('success',trans("home.alert_success_update"))
            : back()->with('error', trans("settings.Error_update"));
    }


    public function social_media()
    {
        $data = $this->validate(request(),[
            'fb' => 'sometimes|nullable',
            'tw'=> 'sometimes|nullable',
        ]);
        return settings(false,true,$data)
            ? back()->with('success',trans("home.alert_success_update"))
            : back()->with('error','عفوا هناك خطأ');
    }

    public function maintenance()
    {
        $data = $this->validate(request(),[
            'maintenance_start_at' => 'required|before:today',
            'maintenance_end_at' => 'required|after:today',
            'maintenance_message' => 'required|string'
        ]);
        return settings(false,true,$data)
            ? back()->with("success",trans("settings.Success_update_maintenance"))
            : back()->with("error", trans("settings.Error_update"));
    }
}
