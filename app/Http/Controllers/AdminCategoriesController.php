<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;
use App\Helper;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = "Categories - Admin";
        $categories = Category::get();
        return view('admin.categories.index', compact('page', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = "Create Category - Admin";
        return view('admin.categories.create', compact('page'));
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

            $input = array_intersect_key($input, Category::$updatable);
            
            $input['title'] = ucfirst($input['title']);

            $category = Category::create($input);
            
            $category['slug'] = Helper::slug($input['title'], $category->id);
            $category->save();

            $request->session()->flash('success', $input['title'].' category created successfully.');
            
            return redirect('admin/category');
        } else {
            
            $request->session()->flash('success', $input['title'].' category could not be created. Please try again.');
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
        $page = "Category Details - Admin";
        $category = Category::find($id);
        return view('admin.categories.view', compact('page', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = "Edit Category - Admin";
        $category = Category::find($id);
        return view('admin.categories.edit', compact('page', 'category'));
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

        $input = array_intersect_key($input, Category::$updatable);
        if(Category::where('id', $id)->update($input)) {
            $request->session()->flash('success', 'Category updated successfully');
            return redirect('admin/category');
        } else {
            $request->session()->flash('error', "Category cann't be updated");
            return redirect('admin/category');
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
        $category = Category::find($id);
        $title = $category->title;

        if($category->delete()) {
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
