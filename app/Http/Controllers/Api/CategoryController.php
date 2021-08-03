<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = $request->q;

        $category = Category::where('category_name', 'like', "%" . $key . "%")->paginate(10);
        return response()->json(['success' => true, 'collection' => $category, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'category_name' => 'required|unique:categories|max:45'
            ]
        );
        $category = Category::insert(
            [
                'category_name' => $request->category_name,
                'created_at' => Carbon::now()
            ]

        );  

        return response()->json(
            [
                'success' => true,
                'message' => 'Category Successfully Added',
                'category' => $category
            ]
        );
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
    public function update(Request $request)
    {
        //
        $request->validate(
            [
                'category_name' => 
                [
                    'required',
                    'max:45',
                    ValidationRule::unique('categories')->ignore($request->id, 'id')
                ]
            ]
        );
        $category = Category::where('id', $request->id)->update([
            'category_name' => $request->category_name,
            'updated_at' => Carbon::now()
        ]);

        return response()->json(
            [
                'success' => true,
                'message' => 'Category Successfully Updated',
                'category' => $category
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $deleted = Category::where('id', $id)->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Category Successfully Deleted',
                'deleted' => $deleted
            ]
        );
    }
}
