<?php

namespace App\MenuBuilder\MegaMenus;

use App\Knowledgebase;
use App\KnowledgebaseTopic;
use App\MenuBuilder\MegaMenuBase;

class KnowledgebaseMegaMenu extends MegaMenuBase
{

    function model(){
        return 'App\Knowledgebase';
    }
    function render($ids,$lang)
    {
        //it will have all html markup for the mega menu
        $ids = explode(',',$ids);
        $output = '';
        if (empty($ids)){
            return $output;
        }
        $output .= $this->body_start();

        $mega_menu_items = Knowledgebase::whereIn('id',$ids)->get()->groupBy('topic_id');
        foreach ($mega_menu_items as $cat => $posts) {
            $output .= '<div class="col-lg-3 col-md-6">' ."\n";
            $output .= '<div class="xg-mega-menu-single-column-wrap">'."\n";
            $output .= '<h4 class="mega-menu-title">' . $this->category($cat). '</h4>'."\n";
            $output .= '<ul>'."\n";
            foreach ($posts as $post) {
                $output .= '<li><a href="'.route($this->route(),$post->slug).'">' . $post->title . '</a></li>'."\n";
            }
            $output .= '</ul>'."\n";
            $output .= '</div>'."\n";
            $output .= '</div>'."\n";
        }

        $output .= $this->body_end();
        // TODO: return all makrup data for render it to frontend
        return $output;
    }
    function slug()
    {
        // TODO: Implement name() method.
        return 'knowledgebase_page_slug';
    }

    function category($id)
    {
        $category = KnowledgebaseTopic::where(['id' => $id])->first();
        return $category->title ?? __('Uncategorized');
    }

    function route()
    {
        // TODO: Implement route() method.
        return 'frontend.knowledgebase.single';
    }

    function routeParams()
    {
        // TODO: Implement routeParams() method.
        return ['slug'];
    }

    function name()
    {
        // TODO: Implement name() method.
        return 'knowledgebase_page_[lang]_name';
    }
    function enable()
    {
        // TODO: Implement enable() method.
        return get_static_option('knowledgebase_module_status');
    }
    function query_type()
    {
        // TODO: Implement query_type() method.
        return 'old_lang'; // old_lang|new_lang
    }

    function title_param()
    {
        // TODO: Implement title_param() method.
        return 'title';
    }
}