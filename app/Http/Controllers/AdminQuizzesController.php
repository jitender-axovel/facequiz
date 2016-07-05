<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\SubCategory;
use App\Quiz;
use App\QuizFact;
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
        $page = 'Quizzes - Admin';

        $quizzes = Quiz::get();
        return view('admin.quizzes.index', compact('page', 'quizzes'));
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
        $file = $request->file('image');

        $quizData = array_intersect_key($input, Quiz::$updatable);
        
        $quizData['title'] = ucfirst($quizData['title']);
        $quiz = Quiz::create($quizData);

        $quiz['slug'] = Helper::slug($quiz->title, $quiz->id);
        $quiz->save();
        
        $destinationPath = public_path('images').'/quizzes/facts/'.$quiz->id;
        shell_exec('mkdir '.$destinationPath);

        foreach($input['fact']['title'] as $k => $fact) {
            $quizFact = new QuizFact();
            $quizFact->quiz_id = $quiz->id;
            $quizFact->title = $input['fact']['title'][$k];
            $quizFact->description = $input['fact']['description'][$k];
            if($file[$k]->isValid()) {
                $fileName = md5(time()).'.png';
                $file[$k]->move($destinationPath, $fileName);
                $quizFact->image = $fileName;
            }
            $quizFact->save();
        }

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

    public function getQuizForm(Request $request)
    {
        $input = $request->input();

        view()->share($input);

        return view('admin.quizzes.components.attributes-form');

    }
}
