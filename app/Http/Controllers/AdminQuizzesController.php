<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;

use App\Quiz;
use App\QuizFact;
use App\QuizTemplate;
use App\Helper;
use App\Language;

class AdminQuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Quizzes - Robodoo - Play with Robo';

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
        $page = "Create Quiz - Robodoo - Play with Robo";
        $templates = QuizTemplate::all();
        $languages = Language::get();
        return view('admin.quizzes.create', compact('page', 'templates', 'languages'));
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

        $validation = array(
            'title' => 'required|max:255|unique:quizzes',
            'locale' => 'required',
            'total_facts' => 'required|integer|min:0',
            'html_data' => 'required',
            'og_image' => 'required',
            'total_images' => 'required|min:0|integer',
            'total_textareas' => 'required|min:0|integer',
        );

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //save template
        
        $fileInput = $request->file('og_image');

        $template = array_intersect_key($input, QuizTemplate::$updatable);

        $template['html_data'] = htmlspecialchars($template['html_data']);

        $template['name'] = $input['title'];

        $template = QuizTemplate::create($template);
        
        if(isset($input['has_title'])) {
            $template->has_title = 1;
        }
        
        if(isset($input['has_image_caption'])) {
            $template->has_image_caption = 1;
        }
        
        $template->save();

        $destinationPath = config('image.quiz_template_path');
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        $fileName = md5(time()).'.png';
        $fileInput->move($destinationPath, $fileName);
        
        $template->og_image = $fileName;
        $template->save();

        //Saving quiz

        $input['quiz_template_id'] = $template->id;

        $quizData = array_intersect_key($input, Quiz::$updatable);
        
        $quizData['title'] = ucfirst($quizData['title']);
        $quiz = Quiz::create($quizData);

        if(isset($input['is_active'])) {
            $quiz->is_active = 1;
        }
        if(isset($input['show_own_profile_picture'])) {
            $quiz->show_own_profile_picture = 1;
        }
        if(isset($input['show_user_name'])) {
            $quiz->show_user_name = 1;
        }
        if(isset($input['show_friend_pictures'])) {
            $quiz->show_friend_pictures = 1;
        }
        if(isset($input['show_friend_name'])) {
            $quiz->show_friend_name = 1;
        }

        $quiz['slug'] = Helper::slug($quiz->title, $quiz->id);
        $quiz->save();

        if($request->hasFile('background_image')) {
            
            $backgroundPath = config('image.quiz_background_path').$quiz->id;

            if (!file_exists($backgroundPath)) {
                mkdir($backgroundPath, 0777, true);
            }

            $background = $request->file('background_image');
            $quiz->background_image = md5(time()).'.'.$background->getClientOriginalExtension();
            $background->move($backgroundPath, $quiz->background_image);

            $quiz->save();
        }
        
        $destinationPath = config('image.quiz_facts_path').$quiz->id;
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        if(isset($input['fact'])) {
            foreach($input['fact']['title'] as $k => $fact) {
                $quizFact = new QuizFact();
                $quizFact->quiz_id = $quiz->id;
                $quizFact->title = $input['fact']['title'][$k];
                $quizFact->description = $input['fact']['description'][$k];
                if($request->hasFile('image') && $file[$k] != null) {
                    $fileName = md5($input['fact']['title'][$k]).'.png';
                    $file[$k]->move($destinationPath, $fileName);
                    $quizFact->image = $fileName;
                    $quizFact->save();
                } else {
                    $quizFact->save();
                }
            }
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
        $page = 'View Template - Robodoo - Play with Robo';
        $quiz = Quiz::find($id);
        return view('admin.quizzes.view', compact('page', 'quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::find($id);
        $page = 'Edit '.$quiz->title.' - Robodoo - Play with Robo';
        $languages = Language::get();
        return view('admin.quizzes.edit', compact('quiz', 'page', 'languages'));
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
        // dd($request->file('image'));
        $quiz = Quiz::find($id);

        if(!$quiz) {
            return redirect('admin/quiz')->with('error', 'Can not find quiz. Kindly try again.');
        }

        $input = $request->input();
        $file = $request->file('image');

        $validation = array(
            'title' => 'required|max:255',
            'locale' => 'required',
            'total_facts' => 'required|integer|min:0',
            'html_data' => 'required',
            'total_images' => 'required|min:0|integer',
            'total_textareas' => 'required|min:0|integer',
        );

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //save template
        
        $fileInput = $request->file('og_image');

        $templateInput = array_intersect_key($input, QuizTemplate::$updatable);

        $templateInput['html_data'] = htmlspecialchars($templateInput['html_data']);

        $templateInput['name'] = $input['title'];

        $quiz->template->update($templateInput);

        if(isset($input['has_title'])) {
            $quiz->template->has_title = 1;
        }
        
        if(isset($input['has_image_caption'])) {
            $quiz->template->has_image_caption = 1;
        }
        
        $quiz->template->save();

        if($fileInput) {
            $destinationPath = config('image.quiz_template_path');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $fileName = md5(time()).'.png';
            $fileInput->move($destinationPath, $fileName);
            
            $quiz->template->og_image = $fileName;
            $quiz->template->save();
        }

        //Saving quiz

        $quizData = array_intersect_key($input, Quiz::$updatable);
        
        $quizData['title'] = ucfirst($quizData['title']);
        $quiz->update($quizData);

        if(isset($input['is_active'])) {
            $quiz->is_active = 1;
        }
        if(isset($input['show_own_profile_picture'])) {
            $quiz->show_own_profile_picture = 1;
        }
        if(isset($input['show_user_name'])) {
            $quiz->show_user_name = 1;
        }
        if(isset($input['show_friend_pictures'])) {
            $quiz->show_friend_pictures = 1;
        }
        if(isset($input['show_friend_name'])) {
            $quiz->show_friend_name = 1;
        }

        $quiz['slug'] = Helper::slug($quiz->title, $quiz->id);
        $quiz->save();

        if($request->hasFile('background_image')) {
            
            $backgroundPath = config('image.quiz_background_path').$quiz->id;

            if (!file_exists($backgroundPath)) {
                mkdir($backgroundPath, 0777, true);
            }

            $background = $request->file('background_image');
            $quiz->background_image = md5(time()).'.'.$background->getClientOriginalExtension();
            $background->move($backgroundPath, $quiz->background_image);

            $quiz->save();
        }
        
        $destinationPath = config('image.quiz_facts_path').$quiz->id;
        
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        if(isset($input['fact'])) {
            foreach($input['fact']['title'] as $k => $fact) {
                if(QuizFact::find($k)) {
                    $quizFact = QuizFact::find($k);
                    $quizFact->title = $input['fact']['title'][$k];
                    $quizFact->description = $input['fact']['description'][$k];
                } else {
                    $quizFact = new QuizFact();
                    $quizFact->quiz_id = $quiz->id;
                    $quizFact->title = $input['fact']['title'][$k];
                    $quizFact->description = $input['fact']['description'][$k];
                }
                if($request->hasFile('image') && $file[$k] != null) {
                    $fileName = md5($input['fact']['title'][$k]).'.png';
                    $file[$k]->move($destinationPath, $fileName);
                    $quizFact->image = $fileName;
                    $quizFact->save();
                } else {
                    $quizFact->save();
                }
            }
        }

        return redirect('admin/quiz')->with('success', 'Quiz is successfully upadted.');
    }

    /**
     * Change Status of the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        $quiz = Quiz::find($id);
        $title = $quiz->title;

        $quiz->is_active = !$quiz->is_active;

        if($quiz->save()) {
            $result['status'] = true;
            $result['message'] = $title."'s status has been changed.";

            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = $title."'s status could not changed.";

            return json_encode($result);
        }
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
