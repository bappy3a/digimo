<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class ServicePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function service_page_settings(){
        return view('backend.pages.service.service-page-settings');
    }
    public function update_service_page_settings(Request $request){
        $this->validate($request,[
            'service_page_service_items' => 'required|string|max:191',
        ]);
        update_static_option('service_page_service_items', $request->service_page_service_items);

        return redirect()->back()->with(['msg' => __('Settings Update Success'),'type' => 'success']);
    }
    public function service_single_page_settings(){
        $all_language = Language::all();
        return view('backend.pages.service.service-single-settings')->with(['all_languages' => $all_language]);
    }

    public function update_service_single_page_settings(Request $request)
    {
        $this->validate($request,[
           'service_single_page_query_form_email' => 'nullable|string'
        ]);
        $all_languages = Language::all();
        foreach ($all_languages as $lang) {
            $this->validate($request, [
                'service_single_page_' . $lang->slug . '_query_form_title' => 'nullable|string',
            ]);

            $query_form_title = 'service_single_page_' . $lang->slug . '_query_form_title';

            update_static_option($query_form_title, $request->$query_form_title);
        }
        update_static_option('service_single_page_query_form_email', $request->service_single_page_query_form_email);

        return redirect()->back()->with(['msg' => __('Page Settings Updated..'), 'type' => 'success']);
    }
}
