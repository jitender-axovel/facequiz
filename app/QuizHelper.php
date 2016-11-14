<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
            'default_graph_version' => 'v2.7',
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

    public function checkLike($pageId)
    {
        try {
            $response = $this->fb->get('/me/likes?target_id='.$pageId);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return false;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return false;
        }

        $response = $response->getGraphEdge();
        $response = $response->asArray();

        if(count($response)) {
            return true;
        }

        return false;
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
            return $template;
        }
    }
    
    public function setUserProfileImage($template, $quiz)
    {
        if($quiz->show_own_profile_picture) {
            try {
                $response = $this->fb->get('/me?fields=picture.width(480)');
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            }

            $response = $response->getGraphObject();
            $response = $response->asArray();
            return str_replace('user_profile_pic', $response['picture']['url'], $template);
        } else {
            return $template;
        }
    }

    public function setUserPhotos($template, $quiz)
    {
        if($quiz->show_own_photos) {
            try {
                $response = $this->fb->get('/me/photos/uploaded?fields=source.width(480)');
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
            }

            $response = $response->getGraphEdge();
            $response = $response->asArray();

            $array_keys = array();
            if(count($response)) {
                if(count($response) < $quiz->template->total_images) {
                    $array_keys = array_rand($response, count($response));
                    for ($i=0; $i < ($quiz->template->total_images - count($response)); $i++) { 
                        $array_keys[] = array_rand($response, 1);
                    }
                } else {
                    $array_keys = array_rand($response, $quiz->template->total_images);
                }
            }
            
            foreach($array_keys as $k => $key) {
                $k = $k + 1;
                $template = str_replace('user_photo_'.$k, $response[$key]['source'], $template);
            }

            return $template;
        } else {
            return $template;
        }
    }
    
    public function setUserName($template, $quiz)
    {
        if($quiz->show_user_name) {
            return str_replace('user_name', explode(' ', Auth::user()->name)[0], $template);
        } else {
            return str_replace('user_name', '', $template);
        }
    }

    private function getGraphObject($path)
    {
        try {
            $response = $this->fb->get($path);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return redirect('/')->with('error', 'Sorry for the inconvenience, there are no results for this quiz');
        }

        return $response;
    }
    
    public function setFriendData($template, $quiz)
    {
        if($quiz->show_friend_pictures || $quiz->show_friend_name) {
            $friends = $this->getGraphObject('/me/friends?fields=id,name,picture.width(480)');

            $friends = $friends->getGraphEdge()->asArray();

            foreach ($friends as $friend) {
                $friendData[$friend['id']] = $friend;
                $friendData[$friend['id']]['score'] = 0;
            }

            $now = Carbon::create();

            if (isset($friendData) && (is_array($friendData) && count($friendData))) {
                $posts = $this->getGraphObject('/me/posts')->getGraphEdge();

                $response = $posts->asArray();

                while(count($response) > 0) {
                    foreach ($response as $key => $post) {
                        $likes = $this->getGraphObject('/'.$post['id'].'/likes');

                        foreach ($likes->getGraphEdge()->asArray() as $key => $like) {
                            if(array_key_exists((int)$like['id'], $friendData)) {
                                $post['created_time'] = new Carbon($post['created_time']->format('M d Y'));
                                $diff = $now->diffInDays($post['created_time']);
                                $friendData[(int)$like['id']]['score'] += $diff * 0.01;
                            }
                        }
                    }

                    $posts = $this->fb->next($posts);
                    $response = $posts;
                }

                $photos = $this->getGraphObject('/me/photos/uploaded')->getGraphEdge();
                $response = $photos->asArray();

                while(count($response)) {
                    foreach($response as $key => $photo) {
                        $likes = $this->getGraphObject('/'.$photo['id'].'/likes');

                        $photo['created_time'] = new Carbon($photo['created_time']->format('M d Y'));
                        $diff = $now->diffInDays($photo['created_time']);

                        foreach($likes->getGraphEdge()->asArray() as $likeFrom) {

                            if (array_key_exists ((int)$likeFrom['id'] , $friendData)) {
                                $friendData[(int)$likeFrom['id']]['score'] += $diff * 0.01;
                            }
                        }

                        $comments = $this->getGraphObject('/'.$photo['id'].'/comments');

                        foreach($comments->getGraphEdge()->asArray() as $commentFrom) {

                            if (array_key_exists($commentFrom['from']['id'], $friendData)) {
                                $friendData[$commentFrom['from']['id']]['score'] += $diff * 0.02;
                            }
                        }
                    }

                    $photos = $this->fb->next($photos);
                    $response = $photos;
                }

                foreach ($friendData as $key => $friend) {
                    $mutualFriends = $this->getGraphObject($key.'?fields=context.fields(mutual_friends)');
                    $friendData[$key]['score'] += json_decode($mutualFriends->getBody(), true)['context']['mutual_friends']['summary']['total_count'];
                }

                dd($friendData);

                usort($friendData, function($a, $b) {
                    if ($a['score'] == $b['score']) {
                        return 0;
                    }
                    return ($a['score'] < $b['score']) ? 1 : -1;
                });

                (count($friendData) >= 10) ? ($friendData = array_slice($friendData, 0, 10)) : '';
                
                $array_keys = array();
                if(count($friendData)) {
                    if(count($friendData) < $quiz->template->total_images) {
                        $array_keys = array_rand($friendData, count($friendData));
                        for ($i=0; $i < ($quiz->template->total_images - count($friendData)); $i++) { 
                            $array_keys[] = array_rand($friendData, 1);
                        }
                    } else {
                        $array_keys = array_rand($friendData, $quiz->template->total_images);
                    }
                }
            }
            
        }

        if (!isset($array_keys)) {
            $profilePic = $this->getGraphObject('/me?fields=picture.width(480)');

            $profilePic = $profilePic->getGraphObject()->asArray();

            for ($i=0; $i < $quiz->template->total_images; $i++) { 
                $k = $i+1;
                if($quiz->show_friend_pictures)
                    $template = str_replace('friend_profile_pic_'.$k, $profilePic['picture']['url'], $template);

                if($quiz->show_friend_name)
                    $template = str_replace('friend_name_'.$k, explode(' ', Auth::user()->name)[0], $template);
            }

            return $template;
        } else if (($quiz->show_friend_pictures || $quiz->show_friend_name) && is_array($array_keys)) {
            foreach($array_keys as $k => $key) {
                $k = $k + 1;
                if($quiz->show_friend_pictures) {
                    $template = str_replace('friend_profile_pic_'.$k, $friendData[$key]['picture']['url'], $template);
                }

                if($quiz->show_friend_name) {
                    $template = str_replace('friend_name_'.$k, explode(' ', $friendData[$key]['name'])[0], $template);
                }
            }
        } else {
            $k = 1;
            if($quiz->show_friend_pictures) {
                $template = str_replace('friend_profile_pic_'.$k, $friendData[$array_keys]['picture']['url'], $template);
            }

            if($quiz->show_friend_name) {
                $template = str_replace('friend_name_'.$k, explode(' ', $friendData[$array_keys]['name'])[0], $template);
            }
        }
        
        return $template;
    }
    
    public function setFacts($template, $quiz)
    {
        $facts = QuizFact::where('quiz_id', $quiz->id)->get();

        if(($facts && $facts->count()) && $quiz->total_facts) {
            $facts = $facts->toArray();
            $array_keys = array_rand($facts, $quiz->total_facts);
        } else {
            return $template;
        }

        if(is_array($array_keys)) {
            foreach($array_keys as $k => $key) {
                $k = $k + 1;//return $fact->description;
                $factDesc = explode(':=:', $facts[$key]['description']);
                $template = str_replace('fact_'.$k, $facts[$key]['title'], $template);
                $template = str_replace('fact_desc_'.$k, $factDesc[array_rand($factDesc, 1)], $template);
                $template = str_replace('fact_image_'.$k, asset(config('image.quiz_facts_url').$quiz->id.'/'.$facts[$key]['image']), $template);
            }
        } else {
            $k = 1;//return $fact->description;
            $factDesc = explode(':=:', $facts[$array_keys]['description']);
            $template = str_replace('fact_'.$k, $facts[$array_keys]['title'], $template);
            $template = str_replace('fact_desc_'.$k, $factDesc[array_rand($factDesc, 1)], $template);
            $template = str_replace('fact_image_'.$k, asset(config('image.quiz_facts_url').$quiz->id.'/'.$facts[$array_keys]['image']), $template);
        }
        
        return $template;
    }

    public function revokePermissions()
    {
        try {
            $response = $this->fb->delete('/me/permissions');
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            return redirect('/')->with('error', 'Sorry for the inconvenience, the app permissions could not be revoked.');
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            return redirect('/')->with('error', 'Sorry for the inconvenience, the app permissions could not be revoked.');
        }

        return $response->getGraphObject()->asArray();
    }
}
