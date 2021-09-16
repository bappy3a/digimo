<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LanguageHelper;
use App\Helpers\NexelitHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    const BASE_PATH = 'backend.email-template.';


    public function all(){
        return view(self::BASE_PATH.'all');
    }
    public function admin_password_reset(){
        return view(self::BASE_PATH.'admin-reset-password')->with(['all_languages' => LanguageHelper::all_languages()]);
    }

    public function update_admin_password_reset(Request $request){

        foreach (LanguageHelper::all_languages() as $lang){
            $this->validate($request,[
                'admin_reset_password_'.$lang->slug.'_subject',
                'admin_reset_password_'.$lang->slug.'_message',
            ]);
            $fields_list = [
                'admin_reset_password_'.$lang->slug.'_subject',
                'admin_reset_password_'.$lang->slug.'_message',
            ];
            foreach ($fields_list as $field){
                update_static_option($field,$request->$field);
            }
        }

        return back()->with(NexelitHelpers::settings_update());
    }

    public function user_password_reset(){
        return view(self::BASE_PATH.'user-reset-password')->with(['all_languages' => LanguageHelper::all_languages()]);
    }

    public function update_user_password_reset(Request $request){

        foreach (LanguageHelper::all_languages() as $lang){
            $this->validate($request,[
                'user_reset_password_'.$lang->slug.'_subject',
                'user_reset_password_'.$lang->slug.'_message',
            ]);
            $fields_list = [
                'user_reset_password_'.$lang->slug.'_subject',
                'user_reset_password_'.$lang->slug.'_message',
            ];
            foreach ($fields_list as $field){
                update_static_option($field,$request->$field);
            }
        }

        return back()->with(NexelitHelpers::settings_update());
    }

}
