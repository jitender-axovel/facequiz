<div class="thumbnail content-img col-md-12 col-xs-12 col-sm-6">
    <div class="quiz-image-wrapper">
        <a href="{{ url('quiz/'.$quizItem->slug.'/show') }}"><img src="{{ asset(config('image.quiz_template_url').$quizItem->template->og_image) }}"></a>
    </div>
    <div class="caption">
        <div class="heading"><a href="{{ url('quiz/'.$quizItem->slug.'/show') }}">{{ $quizItem->title }}</a></div>
    </div>
</div>