<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Widget;

class AdminWidgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Widgets - Robodoo - Play with Robo';
        $widgets = Widget::get();
        foreach($widgets as $widget) {
            $widget->widgets = json_decode($widget->widgets, true);
        }
        return view('admin.widgets.index', compact('page', 'widgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $widgets = Widget::get();

        foreach($widgets as $widget) {
            if(isset($input[$widget->slug.'Widget'])){
                $array = array();
                foreach($input[$widget->slug.'Widget']['Title'] as $k => $key) {
                    $array[] = array(
                        'title' => $key,
                        'content' => $input[$widget->slug.'Widget']['Content'][$k]
                        );
                }
                $widget->widgets = json_encode($array);
                $widget->save();
            }
        }
        return back()->with('success', 'The widgets are successfully saved. You can check at frontend now.');
    }
}
