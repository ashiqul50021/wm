<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SellerBrandController extends Controller
{
     /*=================== Start BrandView Methoed ===================*/
     public function BrandView(){
        $role = Auth::guard('seller')->user()->role;
    	$brands = Brand::latest()->get();
        if($role == '9'){
            return view('seller.template.brand.brand_view',compact('brands'));
        }else{
            return  abort(500, 'Something went wrong');
        }
    }

    /*=================== Start BrandAdd Method ===================*/
    public function BrandAdd(){
        $role = Auth::guard('seller')->user()->role;
        $sellerId = Auth::guard('seller')->user()->seller_id;
        // dd($product);
        if ($role == '9') {
        return view('seller.template.brand.brand_add');
        }

    }

    /*=================== Start BrandStore Methoed ===================*/
    public function BrandStore(Request $request){
        $this->validate($request,[
            'name_en' => 'required',
            'brand_image' => 'required',
        ]);

        if($request->hasFile('brand_image')){
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            'Image'::make($image)->resize(160,160)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;
        }else{
            $save_url = '';
        }

        $brand = new Brand();
        $brand->seller_id = Auth::guard('seller')->user()->id;
        $brand->name_en = $request->name_en;
        if($request->name_bn == ''){
            $brand->name_bn = $request->name_en;
        }else{
            $brand->name_bn = $request->name_bn;
        }

        $brand->description_en = $request->description_en;
        if($request->description_bn == ''){
            $brand->description_bn = $request->description_en;
        }else{
            $brand->description_bn = $request->description_bn;
        }
        $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name_en)));
        $brand->status = $request->status ?? 0;
        $brand->brand_image = $save_url;
        $brand->created_by = Auth::guard('seller')->user()->id;
        $brand->created_at = Carbon::now();

        $brand->save();

		Session::flash('success','Brand Inserted Successfully');
		return redirect()->route('seller.brand.all');

    } // end method

    /*=================== Start BrandEdit Methoed ===================*/
    public function BrandEdit($id){
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {
    	$brand = Brand::findOrFail($id);
    	return view('seller.template.brand.brand_edit',compact('brand'));
        }
    }

    /*=================== Start BrandUpdate Methoed ===================*/
    public function BrandUpdate(Request $request, $id){
        $this->validate($request,[
            'name_en' => 'required',
        ]);

        $brand = Brand::find($id);
        //Brand Photo Update
        if($request->hasFile('brand_image')){
            try {
                if(file_exists($brand->brand_image)){
                    unlink($brand->brand_image);
                }
            } catch (Exception $e) {

            }
            $brand_image = $request->brand_image;
            $brand_save = time().$brand_image->getClientOriginalName();
            $brand_image->move('upload/brand/',$brand_save);
            $brand->brand_image = 'upload/brand/'.$brand_save;
        }else{
            $brand_save = '';
        }

        // Brand table update
        $brand->name_en = $request->name_en;
        if($request->name_bn == ''){
            $brand->name_bn = $request->name_en;
        }else{
            $brand->name_bn = $request->name_bn;
        }

        $brand->description_en = $request->description_en;
        if($request->description_bn == ''){
            $brand->description_bn = $request->description_en;
        }else{
            $brand->description_bn = $request->description_bn;
        }
        $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name_en)));
        // if($request->status == Null){
        //     $request->status = 0;
        // }
        $brand->status = $request->status ?? 0;
        $brand->created_by = Auth::guard('seller')->user()->id;

        $brand->save();

        $notification = array(
            'message' => 'Brand Updated Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('seller.brand.all')->with($notification);
    } // end method

    /*=================== Start BrandDelete Methoed ===================*/
    public function BrandDelete($id){
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {
    	$brand = Brand::findOrFail($id);
    	try {
            if(file_exists($brand->brand_image)){
                unlink($brand->brand_image);
            }
        } catch (Exception $e) {

        }

    	$brand->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully.',
            'alert-type' => 'error'
        );
		return redirect()->back()->with($notification);
    }
    else{
        Session::flash('error', 'You Can not access the page');
        return back();
    }

    } // end method

    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id){
        $brand = Brand::find($id);
        $brand->status = 1;
        $brand->save();

        Session::flash('success','Brand Active Successfully.');
        return redirect()->back();
    }

    public function inactive($id){
        $brand = Brand::find($id);
        $brand->status = 0;
        $brand->save();

        Session::flash('warning','Brand Inactive Successfully.');
        return redirect()->back();
    }
}
