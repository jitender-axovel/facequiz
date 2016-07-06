<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\QuizTemplate;
use App\Category;

class AdminQuizTemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Quiz Layouts - Admin';
        $templates = QuizTemplate::get();
        return view('admin.templates.index', compact('page', 'templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'Create Layout - Admin';
        $categories = Category::get();
        return view('admin.templates.create', compact('page', 'categories'));
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
        
        $fileInput = $request->file('og_image');

        $input = array_intersect_key($input, QuizTemplate::$updatable);

        $input['html_data'] = htmlspecialchars($input['html_data']);

        $template = QuizTemplate::create($input);

        $destinationPath = config('image.quiz_template_path');
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        $fileName = md5(time()).'.png';
        $fileInput->move($destinationPath, $fileName);
        
        $template->og_image = $fileName;
        $template->save();

        if($template) {
            return redirect('admin/layout')->with('success', 'Layout created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = 'View Template - Admin';
        $template = QuizTemplate::find($id);
        return view('admin.templates.view', compact('page', 'template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
