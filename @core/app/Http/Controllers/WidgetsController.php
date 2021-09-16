<?php

namespace App\Http\Controllers;

use App\Widgets;
use Illuminate\Http\Request;

class WidgetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        $all_widget = Widgets::orderBy('widget_order','ASC')->get();
        return view('backend.widgets.widget-index')->with(['all_widgets' => $all_widget]);
    }

    public function widget_markup(Request $request){
        $markup = '';
        $markup = call_user_func($request->func_name);

        return $markup;
    }

    public function new_widget(Request $request){
        $this->validate($request,[
           'admin_render_function' => 'required',
           'frontend_render_function' => 'required',
           'widget_name' => 'required',
           'widget_order' => 'required',
        ]);

        unset($request['_token']);
        $widget_content = (array) $request->all();

       $widget_id =  Widgets::create([
            'admin_render_function' => $request->admin_render_function,
            'frontend_render_function' => $request->frontend_render_function,
            'widget_name' => $request->widget_name,
            'widget_order' => $request->widget_order,
            'widget_content' => serialize($widget_content),
        ])->id;
        $data['id'] = $widget_id;
        $data['status'] = 'ok';
        return response()->json($data);
    }
    public function update_widget(Request $request){
        $this->validate($request,[
            'admin_render_function' => 'required',
            'frontend_render_function' => 'required',
            'widget_name' => 'required',
            'widget_order' => 'required',
        ]);

        unset($request['_token']);
        $widget_content = (array) $request->all();

        Widgets::find($request->id)->update([
            'admin_render_function' => $request->admin_render_function,
            'frontend_render_function' => $request->frontend_render_function,
            'widget_name' => $request->widget_name,
            'widget_order' => $request->widget_order,
            'widget_content' => serialize($widget_content),
        ]);

        return response()->json('ok');
    }

    public function delete_widget(Request $request){
        Widgets::find($request->id)->delete();
        return response()->json('ok');
    }

    public function update_order_widget(Request $request){
        Widgets::find($request->id)->update(['widget_order' => $request->widget_order]);
        return response()->json('ok');
    }
}
