<?php

namespace App\Http\Middleware;

use Closure;

use App;
use Auth;

class BeforeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //perform action
        $locale = NULL;
        $browser_lang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        $cookie_lang = $request->cookie('language');
        
        if(isset($_GET['lang']) && in_array($_GET['lang'], config('app.languages'))) {
            $request->session()->put('locale', $_GET['lang']);
        } elseif($cookie_lang && in_array($cookie_lang, config('app.languages'))) {
            $request->session()->put('locale', $cookie_lang);
        }
        elseif(in_array($browser_lang, config('app.languages'))) {
            $request->session()->put('locale', $browser_lang);
        }
        
        if($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        }

        if(!$locale) {
            $locale = 'en';
        }
        // Set the local in Session if it's supported
        if ( array_key_exists($locale, config('app.locales'))) {
            $request->session()->put('locale', $locale);
            
            cookie()->forever('language', $locale);
        }
        if(!$request->session()->has('locale'))
        {
            $request->session()->put('locale', $request->getPreferredLanguage( config('app.languages')));
        }
        
        $languageStrings = App\Language::where('code', $request->session()->get('locale'))->orWhere('fb_code', $request->session()->get('locale'))->first();
        if(isset($languageStrings->fb_like)) {
            $fb_like_button = $languageStrings->fb_like;
            view()->share('fb_like_button', $fb_like_button);

            $fb_widget = $languageStrings->fb_widget;
            view()->share('fb_widget', $fb_widget);
        }

        if($languageStrings) $languageStrings = json_decode($languageStrings->strings, true);
        view()->share('languageStrings', array_filter($languageStrings));
        App::setLocale($request->session()->get('locale'));
        
        if(Auth::check()) {
            if(Auth::user()->avatar) {
                $urlParts = parse_url(Auth::user()->avatar);
                $queryString = $urlParts['query'];
                parse_str($queryString, $queryString);
                $queryString['type'] = 'small';
                $queryString = http_build_query($queryString, '', '&amp;');
                view()->share('profile_pic_header', $urlParts['scheme'].'://'.$urlParts['host'].($urlParts['path']!='' ? $urlParts['path'] : '').'?'.$queryString);
            }
        }

        $widgets = App\Widget::get();

        if($widgets->count()) {
            foreach($widgets as $widget) {
                $widget->widgets = json_decode($widget->widgets, true);
                if(is_array($widget->widgets)) {
                    foreach($widget->widgets as $k => $item) {
                        $widgetItems[$widget->slug][$k] = $item['content'];
                    }
                }
            }
            if(isset($widgetItems)) {
                view()->share('widgets', $widgetItems);
            }
        }
        
        return $next($request);
    }
}
