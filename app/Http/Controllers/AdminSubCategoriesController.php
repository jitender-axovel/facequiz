<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;
use App\SubCategory;
use App\Helper;

class AdminSubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = "Sub-Categories - Admin";
        $subCategories = SubCategory::get();
        return view('admin.sub-categories.index', compact('page', 'subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Sub-Category - Admin";
        $categories = Category::get();
        return view('admin.sub-categories.create', compact('page', 'categories'));
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

        if($input['title'] == $input['confirm_title']) {

            $input = array_intersect_key($input, SubCategory::$updatable);
            
            $input['title'] = ucfirst($input['title']);

            $subCategory = SubCategory::create($input);
            
            $subCategory['slug'] = Helper::slug($input['title'], $subCategory->id);
            $subCategory->save();

            $request->session()->flash('success', $input['title'].' sub-category created successfully.');
            
            return redirect('admin/sub-category');
        } else {
            
            $request->session()->flash('success', $input['title'].' sub-category could not be created. Please try again.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = "Sub-Category Details - Admin";
        $subCategory = SubCategory::find($id);
        return view('admin.sub-categories.view', compact('page', 'subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = "Edit Sub-Category - Admin";
        $categories = Category::get();
        $subCategory = SubCategory::find($id);
        return view('admin.sub-categories.edit', compact('page', 'categories', 'subCategory'));
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
        $input = $request->input();

        $input = array_intersect_key($input, SubCategory::$updatable);
        if(SubCategory::where('id', $id)->update($input)) {
            $request->session()->flash('success', 'Sub-Category updated successfully');
            return redirect('admin/sub-category');
        } else {
            $request->session()->flash('error', "Sub-Category cann't be updated");
            return redirect('admin/sub-category');
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
        $subCategory = SubCategory::find($id);
        $title = $subCategory->title;

        if($subCategory->delete()) {
            $result['status'] = true;
            $result['message'] = $title." sub-category has been deleted.";

            return json_encode($result);
        } else {
            $result['status'] = false;
            $result['message'] = $title." sub-category could not deleted.";

            return json_encode($result);
        }
    }
}
