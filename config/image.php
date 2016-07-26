<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(

    /*
     |.....................................................................
     |  Quiz paths
     |.....................................................................
     |
     */

    'quiz_template_path' => str_replace('\\','/',public_path()).'/images/quizzes/templates/',
    'quiz_facts_path' => str_replace('\\','/',public_path()).'/images/quizzes/facts/',

    'quiz_background_path' => str_replace('\\', '/', public_path()).'/images/quizzes/background_image/',

    'quiz_result_path' => str_replace('\\', '/', public_path()).'/images/quizzes/results/',
    
    /*
     |.....................................................................
     |  Quiz urls
     |.....................................................................
     |
     */
    
    'quiz_template_url' => '/images/quizzes/templates/',
    'quiz_facts_url' => '/images/quizzes/facts/',
    'quiz_background_url' => '/images/quizzes/background_image/',
    'quiz_result_url' => '/images/quizzes/results/',

    /*
     |.....................................................................
     |  User Quizzes
     |.....................................................................
     |
     */

    'user_quiz_result_path' => str_replace('\\','/',public_path()).'/images/quizzes/results/',
    
    /*
     |.....................................................................
     |  User Quizzes urls
     |.....................................................................
     |
     */

    'user_quiz_result_url' => '/images/quizzes/results/',

    'widget_image_url' => '/images/widgets/preview/'

);