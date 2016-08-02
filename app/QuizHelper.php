<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Facebook;
use Auth;

class QuizHelper extends Model
{
    protected $fb;
    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
        
        $facebookCredentials = config('services.facebook');
        
        $this->fb = new Facebook\Facebook([
            'app_id' => $facebookCredentials['client_id'],
            'app_secret' => $facebookCredentials['client_secret'],
            'default_graph_version' => 'v2.2',
        ]);
        
        $this->fb->setDefaultAccessToken(session()->get('fb_access_token'));
        
        try {
            $response = $this->fb->get('/me');
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
    
    public function setTitle($template, $quiz)
    {
        if($quiz->template->has_title) {
            return str_replace('is_quiz_title', $quiz->title, $template);
        } else {
            return $template;
        }
    }

    public function setBackgroundImage($template, $quiz) {
        if($quiz->background_image != '') {
            return str_replace('quiz_background_image', asset(config('image.quiz_background_url').$quiz->id.'/'.$quiz->background_image), $template);
        } else {
            $template;
        }
    }
    
    public function setUserProfileImage($template, $quiz)
    {
        if($quiz->show_own_profile_picture) {
            return str_replace('user_profile_pic', Auth::user()->avatar, $template);
        } else {
            return $template;
        }
    }
    
    public function setUserName($template, $quiz)
    {
        if($quiz->show_user_name) {
            return str_replace('user_name', Auth::user()->name, $template);
        } else {
            return str_replace('user_name', '', $template);
        }
    }
    
    public function setFriendData($template, $quiz)
    {
        if($quiz->show_friend_pictures || $quiz->show_friend_name) {
            try {
                $response = $this->fb->get('/me/taggable_friends?fields=picture.type(normal),name');
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            }
            // dd($response);
            $response = $response->getGraphEdge();
            
            $array_keys = array();
            if($response->count()) {
                $response = $response->asArray();
                $array_keys = array_rand($response, $quiz->template->total_images);
            }
            
        }
        
        if($quiz->show_friend_pictures) {
            foreach($array_keys as $k => $key) {
                $k = $k + 1;
                $template = str_replace('friend_profile_pic_'.$k, $response[$key]['picture']['url'], $template);
            }
        }
        
        if($quiz->show_friend_names) {
            foreach($array_keys as $k => $key) {
                $k = $k + 1;
                $template = str_replace('friend_name_'.$k, $response[$key]['name'], $template);
            }
        }
        
        return $template;
    }
    
    public function setFacts($template, $quiz)
    {
        $facts = QuizFact::where('quiz_id', $quiz->id)->get();
        
        if($facts->count()) {
            $facts = $facts->toArray();
            $array_keys = array_rand($facts, $quiz->total_facts);
        } else {
            $array_keys = array();
        }

        if(is_array($array_keys) && count($array_keys)) {
            foreach($array_keys as $k => $key) {
                $k = $k + 1;//return $fact->description;
                $template = str_replace('fact_'.$k, $facts[$key]['title'], $template);
                $template = str_replace('fact_desc_'.$k, $facts[$key]['description'], $template);
                $template = str_replace('fact_image_'.$k, $facts[$key]['image'], $template);
            }
        } else {
            $k = $array_keys + 1;//return $fact->description;
            $template = str_replace('fact_'.$k, $facts[$array_keys]['title'], $template);
            $template = str_replace('fact_desc_'.$k, $facts[$array_keys]['description'], $template);
            $template = str_replace('fact_image_'.$k, $facts[$array_keys]['image'], $template);
        }
        
        return $template;
    }
    
}
