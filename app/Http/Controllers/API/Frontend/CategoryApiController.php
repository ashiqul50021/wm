<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name_en', 'DESC')->where('status', '=', 1)->limit(5)->get();
        if ($categories->isEmpty()) {
            return response()->json(['message' => 'Category Not Found!'], 404);
        }

        return response()->json([
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function featuredCategory()
    {
        $categories_featured = Category::orderBy('name_en', 'DESC')->where('status', '=', 1)->where('is_featured', 1)->latest()->get();

        if ($categories_featured->isEmpty()) {
            return response()->json([
                'message' => 'No Featured Categories Found',
            ], 401);
        }

        return response()->json([
            'category_featured' => CategoryResource::collection($categories_featured),
        ]);
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
    }
}
