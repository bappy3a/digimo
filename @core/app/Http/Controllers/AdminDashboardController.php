<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Brand;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\Events;
use App\Faq;
use App\Jobs;
use App\Language;
use App\Mail\ProductOrder;
use App\MediaUpload;
use App\Order;
use App\Products;
use App\Services;
use App\Blog;
use App\ContactInfoItem;
use App\Counterup;
use App\KeyFeatures;
use App\PricePlan;
use App\SocialIcons;
use App\TeamMember;
use App\Testimonial;
use App\Works;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function adminIndex()
    {
        $default_lang = get_default_language();

        $all_blogs = Blog::where('lang', $default_lang)->count();
        $total_admin = Admin::count();
        $total_testimonial = Testimonial::where('lang', $default_lang)->count();
        $total_team_member = TeamMember::where('lang', $default_lang)->count();
        $total_counterup = Counterup::where('lang', $default_lang)->count();
        $total_price_plan = PricePlan::where('lang', $default_lang)->count();
        $total_services = Services::where('lang', $default_lang)->count();
        $total_key_features = KeyFeatures::where('lang', $default_lang)->count();
        $total_works = Works::where('lang', $default_lang)->count();
        $total_jobs = Jobs::where('lang', $default_lang)->count();
        $total_events = Events::where('lang', $default_lang)->count();
        $total_donations = Donation::where('lang', $default_lang)->count();
        $total_products = Products::where('lang', $default_lang)->count();
        $total_Faq = Faq::where('lang', $default_lang)->count();
        $total_brand = Brand::all()->count();
        $total_product_order = \App\ProductOrder::all()->count();
        $total_donated_log = DonationLogs::where('status','complete')->count();
        $total_event_attendance = EventAttendance::where('status','complete')->count();

        //recent 5 order of product order
        $product_recent_order = \App\ProductOrder::orderBy('id','desc')->take(5)->get();
        $package_recent_order = Order::orderBy('id','desc')->take(5)->get();
        $event_attendance_recent_order = EventAttendance::orderBy('id','desc')->take(5)->get();
        $donation_recent = DonationLogs::orderBy('id','desc')->take(5)->get();

        $this->update_script_info();

        return view('backend.admin-home')->with([
            'blog_count' => $all_blogs,
            'total_admin' => $total_admin,
            'total_price_plan' => $total_price_plan,
            'total_works' => $total_works,
            'total_services' => $total_services,
            'total_jobs' => $total_jobs,
            'total_events' => $total_events,
            'total_donations' => $total_donations,
            'total_products' => $total_products,
            'total_donated_log' => $total_donated_log,
            'total_product_order' => $total_product_order,
            'total_event_attendance' => $total_event_attendance,
            'product_recent_order' => $product_recent_order,
            'package_recent_order' => $package_recent_order,
            'event_attendance_recent_order' => $event_attendance_recent_order,
            'donation_recent' => $donation_recent,
        ]);
    }

    private function update_script_info(){
        update_static_option('site_install_path',url('/'));
        update_static_option('site_admin_path',route('admin.home'));
        update_static_option('site_frontend_path',route('homepage'));
        \Illuminate\Support\Facades\Cache::forget('site_script_version');
        setEnvValue([
            'XGENIOUS_NEXELIT_VERSION' => get_static_option('site_script_version')
        ]);
        update_static_option('site_script_unique_key',getenv('XGENIOUS_API_KEY'));
    }

    public function admin_settings()
    {
        return view('auth.admin.settings');
    }

    public function admin_profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'username' => 'required|string|max:191',
            'image' => 'nullable|string|max:191'
        ]);
        Admin::find(Auth::user()->id)->update(['name' => $request->name, 'email' => $request->email, 'username' => str_replace(' ', '_', $request->username), 'image' => $request->image]);

        return redirect()->back()->with(['msg' => __('Profile Update Success'), 'type' => 'success']);
    }

    public function admin_password_chagne(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Admin::findOrFail(Auth::id());

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('admin.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with(['msg' => __('You Logged Out !!'), 'type' => 'danger']);
    }

    public function admin_profile()
    {
        return view('auth.admin.edit-profile');
    }

    public function admin_password()
    {
        return view('auth.admin.change-password');
    }

    public function contact()
    {
        $all_contact_info_items = ContactInfoItem::all();
        return view('backend.pages.contact')->with([
            'all_contact_info_item' => $all_contact_info_items
        ]);
    }

    public function update_contact(Request $request)
    {
        $this->validate($request, [
            'page_title' => 'required|string|max:191',
            'get_title' => 'required|string|max:191',
            'get_description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        update_static_option('contact_page_title', $request->page_title);
        update_static_option('contact_page_get_title', $request->get_title);
        update_static_option('contact_page_get_description', $request->get_description);
        update_static_option('contact_page_latitude', $request->latitude);
        update_static_option('contact_page_longitude', $request->longitude);

        return redirect()->back()->with(['msg' => __('Contact Page Info Update Success'), 'type' => 'success']);
    }


    public function blog_page()
    {
        $all_languages = Language::all();
        return view('backend.pages.blog')->with(['all_languages' => $all_languages]);
    }

    public function blog_page_update(Request $request)
    {
        $all_language = Language::all();
        foreach ($all_language as $lang) {
            $this->validate($request, [
                'blog_page_' . $lang->slug . '_title' => 'nullable',
                'blog_page_' . $lang->slug . '_item' => 'nullable',
                'blog_page_' . $lang->slug . '_category_widget_title' => 'nullable',
                'blog_page_' . $lang->slug . '_recent_post_widget_title' => 'nullable',
                'blog_page_' . $lang->slug . '_recent_post_widget_item' => 'nullable',
            ]);
            $blog_page_title = 'blog_page_' . $lang->slug . '_title';
            $blog_page_item = 'blog_page_' . $lang->slug . '_item';
            $blog_page_category_widget_title = 'blog_page_' . $lang->slug . '_category_widget_title';
            $blog_page_recent_post_widget_title = 'blog_page_' . $lang->slug . '_recent_post_widget_title';
            $blog_page_recent_post_widget_item = 'blog_page_' . $lang->slug . '_recent_post_widget_item';

            update_static_option('blog_page_' . $lang->slug . '_title', $request->$blog_page_title);
            update_static_option('blog_page_' . $lang->slug . '_item', $request->$blog_page_item);
            update_static_option('blog_page_' . $lang->slug . '_category_widget_title', $request->$blog_page_category_widget_title);
            update_static_option('blog_page_' . $lang->slug . '_recent_post_widget_title', $request->$blog_page_recent_post_widget_title);
            update_static_option('blog_page_' . $lang->slug . '_recent_post_widget_item', $request->$blog_page_recent_post_widget_item);
        }


        return redirect()->back()->with(['msg' => __('Blog Settings Update Success'), 'type' => 'success']);
    }


    public function home_variant()
    {
        return view('backend.pages.home.home-variant');
    }

    public function update_home_variant(Request $request)
    {
        $this->validate($request, [
            'home_page_variant' => 'required|string'
        ]);
        update_static_option('home_page_variant', $request->home_page_variant);
        return redirect()->back()->with(['msg' => __('Home Variant Settings Updated..'), 'type' => 'success']);
    }

    public function admin_set_static_option(Request $request)
    {
        $this->validate($request,[
           'static_option' => 'required|string',
           'static_option_value' => 'required|string',
        ]);
        set_static_option($request->static_option,$request->static_option_value);
        return 'ok';
    }

    public function admin_get_static_option(Request $request)
    {
        $this->validate($request,[
            'static_option' => 'required|string'
        ]);
        $data = get_static_option($request->static_option);
        return response()->json($data);
    }

    public function admin_update_static_option(Request $request)
    {
        $this->validate($request,[
            'static_option' => 'required|string',
            'static_option_value' => 'required|string',
        ]);
        update_static_option($request->static_option,$request->static_option_value);
        return 'ok';
    }

}


