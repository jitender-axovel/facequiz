<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\SubCategory;
use App\Quiz;
use App\QuizTemplate;
use App\Helper;

class AdminQuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Quiz - Admin";
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $templates = QuizTemplate::all();
        return view('admin.quizzes.create', compact('page', 'categories', 'subCategories', 'templates'));
    }

    public function getSubCategories()
    {
        $subCategories = SubCategory::where('category_id', $_GET['ci'])->select(['id', 'title'])->get();
        return json_encode($subCategories);
    }

    public function getTemplateDetails()
    {
        $template = QuizTemplate::where('id', $_GET['ti'])->first();
        return json_encode($template);
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

        $input = array_intersect_key($input, Quiz::$updatable);
        
        $input['title'] = ucfirst($input['title']);
        $quiz = Quiz::create($input);

        $quiz['slug'] = Helper::slug($input['title'], $quiz->id);
        $quiz->save();

        $category = $quiz->category->title;

        $type = $quiz->subCategory->title;

        return view('admin.quizzes.components.attributes-form', compact('category', 'type'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
