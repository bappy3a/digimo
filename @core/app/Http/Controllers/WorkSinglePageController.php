<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class WorkSinglePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function work_single_page_settings(){
        $all_language = Language::all();
        return view('backend.pages.works.work-single-settings')->with(['all_languages' => $all_language]);
    }

    public function update_work_single_page_settings(Request $request){

        $all_languages = Language::all();
        foreach ($all_languages as $lang){

            $this->validate($request,[
                'case_study_'.$lang->slug.'_read_more_text' => 'nullable|string',
                'case_study_'.$lang->slug.'_query_title' => 'nullable|string',
                'case_study_'.$lang->slug.'_related_title' => 'nullable|string',
                'case_study_'.$lang->slug.'_gallery_title' => 'nullable|string'
            ]);
            $read_more_text = 'case_study_'.$lang->slug.'_read_more_text';
            $query_title = 'case_study_'.$lang->slug.'_query_title';
            $gallery_title = 'case_study_'.$lang->slug.'_gallery_title';
            $related_title = 'case_study_'.$lang->slug.'_related_title';
            $query_button_text = 'case_study_'.$lang->slug.'_query_button_text';

            update_static_option($read_more_text,$request->$read_more_text);
            update_static_option($query_title,$request->$query_title);
            update_static_option($gallery_title,$request->$gallery_title);
            update_static_option($related_title,$request->$related_title);
            update_static_option($query_button_text,$request->$query_button_text);
        }
            update_static_option('case_study_query_form_mail',$request->case_study_query_form_mail);

        return redirect()->back()->with(['msg' => __('Case Study Page Settings Update...'),'type' => 'success']);
    }
}
