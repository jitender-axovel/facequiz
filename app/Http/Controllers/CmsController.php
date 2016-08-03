<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cms;

class CmsController extends Controller
{
    public function getPage($slug)
    {
    	$cmsPage = Cms::where('slug', $slug)->first();
    	$page = $cmsPage->title . ' - Robodoo';

    	return view('cms.index', compact('page', 'cmsPage'));
    }
}
