<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
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
        $templates = QuizTemplate::all();
        return view('admin.quizzes.create', compact('page', 'templates'));
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
        
        $destinationPath = config('image.quiz_facts_path').$quiz->id;
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

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

        return redirect('admin/quiz')->with('success', 'Quiz has been created.');
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
        $quiz = Quiz::find($id);
        $title = $quiz->title;

        if($quiz->delete()) {
            $result['status'] = true;
            $result['message'] = $title." category has been deleted.";

            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = $title." category could not deleted.";

            return json_encode($result);
        }
    }
}
