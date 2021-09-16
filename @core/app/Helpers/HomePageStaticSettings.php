<?php

namespace App\Helpers;


class HomePageStaticSettings
{
    public $user_lang = null;
    public function __construct() {
        if ($this->user_lang == null){
            $this->user_lang = LanguageHelper::user_lang_slug();
        }
    }

    public static function default_settings(){
        return [

        ];
    }
    public function home_01(){}
    public function home_18(){
        $list = [
            'grocery_home_page_'.$this->user_lang.'_header_section_subtitle',
            'grocery_home_page_'.$this->user_lang.'_header_section_title' ,
            'grocery_home_page_'.$this->user_lang.'_header_section_description',
            'grocery_home_page_'.$this->user_lang.'_header_section_button_one_text',
            'grocery_home_page_header_section_button_one_url' ,
            'grocery_home_page_header_section_button_one_icon',
            'grocery_home_page_header_section_bg_image'
        ];
        return array_merge(self::default_settings(),$list);
    }
}