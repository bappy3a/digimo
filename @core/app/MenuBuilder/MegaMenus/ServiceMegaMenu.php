<?php


namespace App\MenuBuilder\MegaMenus;


use App\MenuBuilder\MegaMenuBase;
use App\ServiceCategory;
use App\Services;

class ServiceMegaMenu extends MegaMenuBase
{

    function model(){
        return 'App\Services';
    }

    function render($ids,$lang)
    {
        // TODO: Implement render() method.
        //it will have all html markup for the mega menu
        $ids = explode(',',$ids);
        $output = '';
        if (empty($ids)){
            return $output;
        }
        $output .= $this->body_start();

        // TODO:what you want you can write,inside this,
        // TODO:it's recommended to have a column inside it
        $mega_menu_items = Services::whereIn('id',$ids)->get()->groupBy('categories_id');
        foreach ($mega_menu_items as $cat => $posts) {
            $output .= '<div class="col-lg-3 col-md-6">' ."\n";
            $output .= '<div class="xg-mega-menu-single-column-wrap">'."\n";
            $output .= '<h4 class="mega-menu-title">' . $this->category($cat). '</h4>'."\n";
            $output .= '<ul>'."\n";
            foreach ($posts as $post) {
                $output .= '<li><a href="'.route('frontend.services.single',$post->slug).'">' . $post->title . '</a></li>'."\n";
            }
            $output .= '</ul>'."\n";
            $output .= '</div>'."\n";
            $output .= '</div>'."\n";
        }

        $output .= $this->body_end();
        // TODO: return all makrup data for render it to frontend
        return $output;

    }

    function category($id)
    {
        // TODO: Implement category() method.
        $category = ServiceCategory::where(['id' => $id])->first();
        return $category->name ?? __('Uncategorized');
    }

    function name()
    {
        // TODO: Implement name() method.
        return 'service_page_[lang]_name';
    }
    function slug()
    {
        // TODO: Implement name() method.
        return 'service_page_slug';
    }
    function enable()
    {
        // TODO: Implement enable() method.
        return true;
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