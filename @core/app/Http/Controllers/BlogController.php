<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;
use App\Language;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;


class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_blog = Blog::all()->groupBy('lang');
        return view('backend.pages.blog.index')->with([
            'all_blog' => $all_blog
        ]);
    }
    public function new_blog(){
        $all_category = BlogCategory::where('lang',get_default_language())->get();
        $all_language = Language::all();
        return view('backend.pages.blog.new')->with([
            'all_category' => $all_category,
            'all_languages' => $all_language,
        ]);
    }
    public function store_new_blog(Request $request){
        $this->validate($request,[
           'category' => 'required',
           'blog_content' => 'required',
           'tags' => 'required',
           'excerpt' => 'required',
           'title' => 'required',
           'lang' => 'required',
           'status' => 'required',
           'author' => 'required',
           'slug' => 'nullable',
           'meta_tags' => 'nullable|string',
           'meta_description' => 'nullable|string',
           'image' => 'nullable|string|max:191',
        ]);

        Blog::create([
            'blog_categories_id' => $request->category,
            'slug' => !empty($request->slug) ? \Str::slug($request->slug) : \Str::slug($request->title) ,
            'content' => $request->blog_content,
            'tags' => $request->tags,
            'title' => $request->title,
            'status' => $request->status,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
            'excerpt' => $request->excerpt,
            'lang' => $request->lang,
            'image' => $request->image,
            'user_id' => Auth::user()->id,
            'author' => $request->author,
        ]);
        return redirect()->back()->with([
            'msg' => __('New Blog Post Added...'),
            'type' => 'success'
        ]);
    }
    public function clone_blog(Request $request)
    {
        $blog_details = Blog::find($request->item_id);
        Blog::create([
            'blog_categories_id' => $blog_details->blog_categories_id,
            'slug' => !empty($blog_details->slug) ? \Str::slug($blog_details->slug) : \Str::slug($blog_details->title) ,
            'content' => $blog_details->content,
            'tags' => $blog_details->tags,
            'title' => $blog_details->title,
            'status' => 'draft',
            'meta_tags' => $blog_details->meta_tags,
            'meta_description' => $blog_details->meta_description,
            'excerpt' => $blog_details->excerpt,
            'lang' => $blog_details->lang,
            'image' => $blog_details->image,
            'user_id' => null,
            'author' => $blog_details->author,
        ]);

        return redirect()->back()->with([
            'msg' => __('Blog Post cloned success...'),
            'type' => 'success'
        ]);
    }

    public function edit_blog($id){
        $blog_post = Blog::find($id);
        $all_category = BlogCategory::where('lang',$blog_post->lang)->get();
        $all_language = Language::all();
        return view('backend.pages.blog.edit')->with([
            'all_category' => $all_category,
            'blog_post' => $blog_post,
            'all_languages' => $all_language,
        ]);
    }
    public function update_blog(Request $request,$id){
        $this->validate($request,[
            'category' => 'required',
            'blog_content' => 'required',
            'tags' => 'required',
            'excerpt' => 'required',
            'title' => 'required',
            'lang' => 'required',
            'status' => 'required',
            'author' => 'required',
            'slug' => 'nullable',
            'meta_tags' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|string|max:191',
        ]);
        Blog::where('id',$id)->update([
            'blog_categories_id' => $request->category,
            'slug' => !empty($request->slug) ? \Str::slug($request->slug) : \Str::slug($request->title) ,
            'content' => $request->blog_content,
            'tags' => $request->tags,
            'title' => $request->title,
            'status' => $request->status,
            'meta_tags' => $request->meta_tags,
            'meta_description' => $request->meta_description,
            'excerpt' => $request->excerpt,
            'lang' => $request->lang,
            'image' => $request->image,
            'user_id' => Auth::user()->id,
            'author' => $request->author,
        ]);

        return redirect()->back()->with([
            'msg' => __('Blog Post updated...'),
            'type' => 'success'
        ]);
    }
    public function delete_blog(Request $request,$id){
        Blog::find($id)->delete();

        return redirect()->back()->with([
            'msg' => __('Blog Post Delete Success...'),
            'type' => 'danger'
        ]);
    }

    public function category(){
        $all_category = BlogCategory::all()->groupBy('lang');
        $all_language = Language::all();
        return view('backend.pages.blog.category')->with([
            'all_category' => $all_category,
            'all_languages' => $all_language
        ]);
    }
    public function new_category(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191|unique:blog_categories',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        BlogCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => __('New Category Added...'),
            'type' => 'success'
        ]);
    }

    public function update_category(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        BlogCategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => __('Category Update Success...'),
            'type' => 'success'
        ]);
    }

    public function delete_category(Request $request,$id){
        if (Blog::where('blog_categories_id',$id)->first()){
            return redirect()->back()->with([
                'msg' => __('You Can Not Delete This Category, It Already Associated With A Post...'),
                'type' => 'danger'
            ]);
        }
        BlogCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => __('Category Delete Success...'),
            'type' => 'danger'
        ]);
    }

    public function Language_by_slug(Request $request){
        $all_category = BlogCategory::where('lang',$request->lang)->get();

        return response()->json($all_category);
    }

    public function blog_page_settings(){
        $all_languages = Language::all();
        return view('backend.pages.blog.page-settings.blog')->with(['all_languages' => $all_languages]);
    }
    public function blog_single_page_settings(){
        $all_languages = Language::all();
        return view('backend.pages.blog.page-settings.blog-single')->with(['all_languages' => $all_languages]);
    }

    public function update_blog_single_page_settings(Request $request){
        $this->validate($request,[
            'blog_single_page_recent_post_item' => 'nullable|string|max:191'
        ]);
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $this->validate($request, [
                'blog_single_page_'.$lang->slug.'_related_post_title' => 'nullable|string',
                'blog_single_page_'.$lang->slug.'_share_title' => 'nullable|string',
                'blog_single_page_'.$lang->slug.'_category_title' => 'nullable|string',
                'blog_single_page_'.$lang->slug.'_recent_post_title' => 'nullable|string',
                'blog_single_page_'.$lang->slug.'_tags_title' => 'nullable|string'
            ]);

            $related_post_title = 'blog_single_page_'.$lang->slug.'_related_post_title';
            $share_title = 'blog_single_page_'.$lang->slug.'_share_title';
            $category_title = 'blog_single_page_'.$lang->slug.'_category_title';
            $recent_post_title = 'blog_single_page_'.$lang->slug.'_recent_post_title';
            $tags_title = 'blog_single_page_'.$lang->slug.'_tags_title';

            update_static_option($related_post_title, $request->$related_post_title);
            update_static_option($share_title, $request->$share_title);
            update_static_option($category_title, $request->$category_title);
            update_static_option($recent_post_title, $request->$recent_post_title);
            update_static_option($tags_title, $request->$tags_title);
        }
        update_static_option('blog_single_page_recent_post_item',$request->blog_single_page_recent_post_item);

        return redirect()->back()->with([
            'msg' => __('Settings Update Success...'),
            'type' => 'success'
        ]);
    }

    public function update_blog_page_settings(Request $request){

        $this->validate($request,[
           'blog_page_recent_post_widget_items' => 'nullable|string|max:191',
           'blog_page_item' => 'nullable|string|max:191'
        ]);

        $all_languages = Language::all();
        foreach ($all_languages as $lang){
            $this->validate($request, [
                'blog_page_'.$lang->slug.'_read_more_btn_text' => 'nullable|string',
            ]);
            $read_more_btn_text = 'blog_page_'.$lang->slug.'_read_more_btn_text';
            update_static_option($read_more_btn_text, $request->$read_more_btn_text);
        }

        update_static_option('blog_page_item',$request->blog_page_item);
        update_static_option('blog_page_recent_post_widget_items',$request->blog_page_recent_post_widget_items);

        return redirect()->back()->with([
            'msg' => __('Settings Update Success...'),
            'type' => 'success'
        ]);
    }

    public function bulk_action(Request $request){
        $all = Blog::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

    public function category_bulk_action(Request $request){
        $all = BlogCategory::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return response()->json(['status' => 'ok']);
    }

}
