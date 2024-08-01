<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Image;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerCategoryApiController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories as c')
            ->leftJoin('categories as sc', 'c.parent_id', '=', 'sc.id')
            ->select('c.*', 'sc.id as parent_id', 'sc.name_en as parent_name')
            ->latest()
            ->get();
        if (!$categories) {
            return response()->json([
                'message' => 'Not Found',
            ],404);
        }

        return response()->json([
            'categories' => $categories,
        ],200);
    } // end method

    public function store(Request $request)
    {
        $this->validate($request, [
            'name_en' => 'required',
        ]);

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/category/' . $name_gen);
            $save_url = 'upload/category/' . $name_gen;
        } else {
            $save_url = '';
        }
        $user = Auth::user();
        $category = new Category();
        $category->seller_id = $user->id;
        /* ======== Category Name English ======= */
        $category->name_en = $request->name_en;
        if ($request->name_bn == '') {
            $category->name_bn = $request->name_en;
        } else {
            $category->name_bn = $request->name_bn;
        }

        /* ======== Category Description English ======= */
        $category->description_en = $request->description_en;
        if ($request->description_bn == '') {
            $category->description_bn = $request->description_en;
        } else {
            $category->description_bn = $request->description_bn;
        }

        /* ======== Category Parent Id  ======= */
        if ($request->parent_id != "0") {
            $category->parent_id = $request->parent_id;

            $parent = Category::find($request->parent_id);

            // dd($parent);
            $category->type = $parent->type + 1;
        }

        /* ======== Category Slug   ======= */
        if ($request->slug != null) {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
        }

        /* ======== Status   ======= */
        if ($request->status == Null) {
            $request->status = 0;
        }
        $category->status = $request->status;

        /* ======== Featured   ======= */
        if ($request->is_featured == Null) {
            $request->is_featured = 0;
        }
        $category->is_featured = $request->is_featured;
        $category->image = $save_url;
        $category->created_by = $user->id;
        $category->created_at = Carbon::now();

        // dd($request()->all());
        $category->save();

        return response()->json([
            'message' => 'Category Successfully inserted',
            'data' => $category,
        ]);
    } // end method
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name_en' => 'required',
        ]);
        $user = Auth::user()->id;
        $category = Category::findOrFail($id);

        if ($category->seller_id != $user) {
            return response()->json([
                'message' => 'You are not able to Edit this product',
            ], 403);
        }


        //Category Photo Update
        if ($request->hasfile('image')) {
            try {
                if (file_exists($category->image)) {
                    unlink($category->image);
                }
            } catch (Exception $e) {
            }
            $image = $request->image;
            $category_save = time() . $image->getClientOriginalName();
            $image->move('upload/category/', $category_save);
            $category->image = 'upload/category/' . $category_save;
        } else {
            $category_save = '';
        }

        /* ======== Category Name English ======= */
        $category->name_en = $request->name_en;
        if ($request->name_bn == '') {
            $category->name_bn = $request->name_en;
        } else {
            $category->name_bn = $request->name_bn;
        }

        /* ======== Category Description English ======= */
        $category->description_en = $request->description_en;
        if ($request->description_bn == '') {
            $category->description_bn = $request->description_en;
        } else {
            $category->description_bn = $request->description_bn;
        }

        /* ======== Category Parent Id  ======= */
        if ($request->parent_id != "0") {
            $category->parent_id = $request->parent_id;

            $parent = Category::find($request->parent_id);
            $category->type = $parent->type + 1;
        } else {
            $category->parent_id = 0;
            $category->type = 1;
        }

        /* ======== Category Slug   ======= */
        if ($request->slug != null) {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
        }

        /* ======== Status   ======= */
        if ($request->status == Null) {
            $request->status = 0;
        }
        $category->status = $request->status;

        /* ======== Featured   ======= */
        if ($request->is_featured == Null) {
            $request->is_featured = 0;
        }

        $category->is_featured = $request->is_featured;
        $category->created_by = $user;

        $category->updated_at = Carbon::now();

        // dd($request()->all());
        $category->save();
        return response()->json([
            'message' => 'Category Successfully Updated',
        ]);
    }
}
