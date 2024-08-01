<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\MultiImg;
use App\Models\Page;
use App\Models\OrderDetail;
use App\Models\Campaing;
use App\Models\Dealer;
use App\Models\ProductStock;
use App\Models\Seller;
use App\Models\Vendor;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Utility\CategoryUtility;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Image;

class FrontendController extends Controller
{
    /*=================== Start Index Methoed ===================*/
    public function index(Request $request)
    {
        $products = Product::where('status', 1)->where('is_featured', 1)->where('approved', 1)->orderBy('id', 'DESC')->get();
        // dd($products);
        // Search Start
        $sort_search = null;
        if ($request->has('search')) {
            $sort_search = $request->search;
            $products = $products->where('name_en', 'like', '%' . $sort_search . '%');
            // dd($products);
        } else {
            $products = Product::where('status', 1)->where('is_featured', 1)->where('approved', 1)->orderBy('id', 'DESC')->get();
        }
        // Header Category Start
        $categories = Category::orderBy('name_en', 'DESC')->where('status', '=', 1)->limit(5)->get();
        // Header Category End
        // Category Featured all
        $featured_category = Category::orderBy('name_en', 'DESC')->where('is_featured', '=', 1)->where('status', '=', 1)->limit(15)->get();
        //Slider
        $sliders = Slider::where('status', 1)->orderBy('id', 'DESC')->limit(10)->get();
        // Product Top Selling
        $product_top_sellings = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->limit(2)->get();
        //Product Trending
        $product_trendings = Product::where('status', 1)->where('approved', 1)->orderBy('id', 'ASC')->skip(2)->limit(2)->get();
        //Product Recently Added
        $product_recently_adds = Product::where('status', 1)->where('approved', 1)->latest()->skip(2)->limit(2)->get();

        $product_top_rates = Product::where('status', 1)->where('approved', 1)->orderBy('regular_price')->limit(2)->get();
        // Home Banner
        $home_banners = Banner::where('status', 1)->where('position', 1)->orderBy('id', 'DESC')->get();
        // Daily Best Sells
        $todays_sale  = OrderDetail::where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $todays_sale = $todays_sale->unique('product_id');
        //Home2 featured category
        $home2_featured_categories = Category::orderBy('name_en', 'DESC')->where('is_featured', '=', 1)->where('status', '=', 1)->get();
        // Hot deals product
        $hot_deals = Product::where('status', 1)->where('approved', 1)->where('is_deals', 1)->latest()->take(4)->get();
        $campaign = Campaing::where('status', 1)->where('is_featured', 1)->first();

        $home_view = 'frontend.home';

        return view($home_view, compact('categories', 'sliders', 'featured_category', 'products', 'product_top_sellings', 'product_trendings', 'product_recently_adds', 'product_top_rates', 'home_banners', 'sort_search', 'todays_sale', 'home2_featured_categories', 'hot_deals', 'campaign'));
    } // end method

    /* ========== Start ProductDetails Method ======== */
    public function productDetails($slug)
    {

        $product = Product::where('slug', $slug)->first();
        if ($product) {
            if ($product->id) {
                $multiImg = MultiImg::where('product_id', $product->id)->get();
            }

            /* ================= Product Color Eng ================== */
            $color_en = $product->product_color_en;
            $product_color_en = explode(',', $color_en);

            /* ================= Product Size Eng =================== */
            $size_en = $product->product_size_en;
            $product_size_en = explode(',', $size_en);

            /* ================= Realted Product =============== */
            $cat_id = $product->category_id;
            $relatedProduct = Product::where('category_id', $cat_id)->where('id', '!=', $product->id)->where('approved', 1)->orderBy('id', 'DESC')->get();

            $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->limit(5)->get();
            $new_products = Product::orderBy('name_en')->where('status', '=', 1)->where('approved', 1)->limit(3)->latest()->get();

            return view('frontend.product.product_details', compact('product', 'multiImg', 'categories', 'new_products', 'product_color_en', 'product_size_en', 'relatedProduct'));
        }

        return view('frontend.product.productNotFound');
    }

    /* ========== Start CatWiseProduct Method ======== */
    public function CatWiseProduct(Request $request, $slug = 'all')
    {
        $category = Category::where('slug', $slug)->first();
        // Top filter Start
        $sort_by = $request->sort_by;
        $brand_id = $request->brand;

        $conditions = ['status' => 1];

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $products_sort_by = Product::where($conditions);

        switch ($sort_by) {
            case 'newest':
                $products_sort_by->orderBy('created_at', 'desc')->paginate(20);
                break;
            case 'oldest':
                $products_sort_by->orderBy('created_at', 'asc')->paginate(20);
                break;
            case 'price-asc':
                $products_sort_by->orderBy('regular_price', 'asc')->paginate(20);
                break;
            case 'price-desc':
                $products_sort_by->orderBy('regular_price', 'desc')->paginate(20);
                break;
            default:
                $products_sort_by->orderBy('id', 'desc')->paginate(20);
                break;
        }
        // Top filter End

        $min_price = $request->get('filter_price_start');
        $max_price = $request->get('filter_price_end');

        $conditions = ['status' => 1];

        if ($request->brand_id != null && $request->brand_id > 0) {
            $conditions = array_merge($conditions, ['brand_id' => $request->brand_id]);
        }

        $products = Product::where($conditions);

        if ($min_price != null && $max_price != null) {
            $products->where('regular_price', '>=', $min_price)->where('regular_price', '<=', $max_price);
        }

        $category_ids = CategoryUtility::children_ids($category->id);
        $category_ids[] = $category->id;
        $products->whereIn('category_id', $category_ids);

        $products = $products->orderBy('created_at', 'desc')->where('approved', 1)->where('status', 1)->paginate(20);

        $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->get();
        // dd($products);
        $subcategories = Category::orderBy('name_en', 'ASC')->where('status', 1)->where('parent_id', $category->id)->get();

        return view('frontend.product.category_view', compact('products', 'categories', 'category', 'sort_by', 'brand_id', 'subcategories'));
    } // end method
    /* ========== End CatWiseProduct Method ======== */

    /* ========== Start CatWiseProduct Method ======== */
    public function VendorWiseProduct(Request $request, $slug)
    {

        $vendor = Vendor::where('slug', $slug)->first();
        // dd($category);

        $products = Product::where('status', 1)->where('approved', 1)->where('vendor_id', $vendor->user_id)->orderBy('id', 'DESC')->paginate(20);
        // Price Filter
        if ($request->get('filter_price_start') !== Null && $request->get('filter_price_end') !== Null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $products = Product::where('status', '=', 1)->where('approved', 1)->where('vendor_id', $vendor->user_id)->whereBetween('regular_price', [$filter_price_start, $filter_price_end])->paginate(20);
                // dd($products);
            }
        }

        $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->get();
        // dd($products);

        return view('frontend.product.vendor_view', compact('products', 'categories', 'vendor'));
    } // end method

    public function sellerWiseProduct(Request $request, $slug)
    {

        $seller = Seller::where('slug', $slug)->first();
        // dd($category);

        $products = Product::where('status', 1)->where('approved', 1)->where('seller_id', $seller->user_id)->orderBy('id', 'DESC')->paginate(20);
        // Price Filter
        if ($request->get('filter_price_start') !== Null && $request->get('filter_price_end') !== Null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $products = Product::where('status', '=', 1)->where('approved', 1)->where('seller_id', $seller->user_id)->whereBetween('regular_price', [$filter_price_start, $filter_price_end])->paginate(20);
                // dd($products);
            }
        }

        $categories = Category::orderBy('name_en', 'ASC')->where('status', '=', 1)->get();
        // dd($products);

        return view('frontend.product.seller_view', compact('products', 'categories', 'seller'));
    } // end method


    /* ========== End CatWiseProduct Method ======== */

    /* ========== Start TagWiseProduct Method ======== */
    // public function TagWiseProduct($id,$slug){

    //     $products = Product::where('status','=',1)->where('tag_id',$id)->orderBy('id','DESC')->paginate(5);
    //     $categories = Category::orderBy('name_en','ASC')->where('status','=',1)->limit(5)->get();
    //     $tags = Tag::orderBy('name_en','ASC')->where('status','=',1)->limit(5)->get();
    //     $tag = Tag::find($id);
    //     $new_products = Product::orderBy('name_en')->where('status','=',1)->limit(3)->latest()->get();

    //     return view('frontend.product.tag_view',compact('products','categories','tags','tag','new_products'));
    // } // end method
    /* ========== End TagWiseProduct Method ======== */


    /* ================= Start ProductViewAjax Method ================= */
    public function ProductViewAjax($id)
    {


        $product = Product::with('category', 'brand', 'stocks')->findOrFail($id);
        // dd($product);


        return response()->json(array(
            'product' => $product
        ));
    }



    public function ProductViewModal($id)
    {
        $idarr = explode("_", $id);
        if (sizeof($idarr) > 1) {
            $product_stock = ProductStock::findOrFail($idarr[1]);
            $product = Product::with('category', 'brand')->findOrFail($idarr[0]);

            $product->varient = $product_stock->varient;
            $product->regular_price = $product_stock->price;
            $product->stock_qty = $product_stock->qty;
            $product->product_thumbnail = $product_stock->image;
        } else {
            $product = Product::findOrFail($id);
        }
        return response()->json(array(
            'product' => $product,
        ));
    }
    /* ================= END PRODUCT VIEW WITH MODAL METHOD =================== */


    public function pageAbout($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('frontend.settings.page.about', compact('page'));
    }

    /* ================= Start Product Search =================== */
    public function ProductSearch(Request $request)
    {

        //$request->validate(["search" => "required"]);
        $sort_by = $request->sort_by;
        $brand_id = $request->brand;

        $conditions = ['status' => 1];

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $products_sort_by = Product::where($conditions)->where('approved', 1);

        switch ($sort_by) {
            case 'newest':
                $products_sort_by->orderBy('created_at', 'desc')->paginate(20);
                break;
            case 'oldest':
                $products_sort_by->orderBy('created_at', 'asc')->paginate(20);
                break;
            case 'price-asc':
                $products_sort_by->orderBy('regular_price', 'asc')->paginate(20);
                break;
            case 'price-desc':
                $products_sort_by->orderBy('regular_price', 'desc')->paginate(20);
                break;
            default:
                $products_sort_by->orderBy('id', 'desc')->paginate(20);
                break;
        }

        $item = $request->search;
        $category_id = $request->searchCategory;
        // echo "$item";

        // Header Category Start //
        $categories = Category::orderBy('name_en', 'DESC')->where('status', 1)->get();
        if ($category_id == 0) {
            $products = Product::where('name_en', 'LIKE', "%$item%")->orWhere('model_number', 'LIKE', "%$item%")->orWhere('tags', 'LIKE', "%$item%")->where(
                'status',
                1
            )->where('approved', 1)->latest()->get();
        } else {
            $products = Product::where('name_en', 'LIKE', "%$item%")->orWhere('model_number', 'LIKE', "%$item%")->orWhere('tags', 'LIKE', "%$item%")->where('category_id', $category_id)->where(
                'status',
                1
            )->where('approved', 1)->latest()->get();
        }

        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();

        return view('frontend.product.search', compact('products', 'categories', 'attributes', 'sort_by', 'brand_id'));
    } // end method

    /* ================= End Product Search =================== */

    /* ================= Start Advance Product Search =================== */
    public function advanceProduct(Request $request)
    {

        // return $request;

        $request->validate(["search" => "required"]);

        $item = $request->search;
        $category_id = $request->category;
        // echo "$item";

        // Header Category Start //
        $categories = Category::orderBy('name_en', 'DESC')->where('status', 1)->get();

        if ($category_id == 0) {
            $products = Product::where('name_en', 'LIKE', "%$item%")->orWhere('tags', 'LIKE', "%$item%")->where(
                'status',
                1
            )->where('approved', 1)->orWhere('model_number', 'LIKE', "%$item%")->latest()->get();
        } else {
            $products = Product::where('name_en', 'LIKE', "%$item%")->where('category_id', $category_id)->where(
                'status',
                1
            )->where('approved', 1)->orWhere('tags', 'LIKE', "%$item%")->orWhere('model_number', 'LIKE', "%$item%")->latest()->get();
        }

        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();

        return view('frontend.product.advance_search', compact('products', 'categories', 'attributes'));
    } // end method

    /* ================= End Advance Product Search =================== */

    /* ================= Start Hot Deals Page Show =================== */
    public function hotDeals(Request $request)
    {

        $sort_by = $request->sort_by;
        $brand_id = $request->brand;

        $conditions = ['status' => 1];

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        $products_sort_by = Product::where($conditions);

        switch ($sort_by) {
            case 'newest':
                $products_sort_by->orderBy('created_at', 'desc')->paginate(20);
                break;
            case 'oldest':
                $products_sort_by->orderBy('created_at', 'asc')->paginate(20);
                break;
            case 'price-asc':
                $products_sort_by->orderBy('regular_price', 'asc')->paginate(20);
                break;
            case 'price-desc':
                $products_sort_by->orderBy('regular_price', 'desc')->paginate(20);
                break;
            default:
                $products_sort_by->orderBy('id', 'desc')->paginate(20);
                break;
        }
        // Hot deals product
        $products = Product::where('status', 1)->where('is_deals', 1)->where('approved', 1)->paginate(20);

        // Category Filter Start
        if ($request->get('filtercategory')) {

            $checked = $_GET['filtercategory'];
            // filter With name start
            $category_filter = Category::whereIn('name_en', $checked)->get();
            $catId = [];
            foreach ($category_filter as $cat_list) {
                array_push($catId, $cat_list->id);
            }
            // filter With name end

            $products = Product::whereIn('category_id', $catId)->where('status', 1)->where('is_deals', 1)->where('approved', 1)->latest()->paginate(20);
            // dd($products);
        }
        // Category Filter End

        $attributes = Attribute::orderBy('name', 'DESC')->where('status', 1)->latest()->get();
        // End Shop Product //
        return view('frontend.deals.hot_deals', compact('attributes', 'products', 'sort_by', 'brand_id'));
    } // end method
    // Dealer Apply
    public function dealerApply(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address'       => 'required',
            'profile_photo'  => 'required',
        ]);

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        if ($request->hasfile('profile_photo')) {
            $image_profile = $request->file('profile_photo');
            $name_gen1 = hexdec(uniqid()) . '.' . $image_profile->getClientOriginalExtension();
            'Image'::make($image_profile)->resize(300, 300)->save('upload/dealer_images/' . $name_gen1);
            $profile_photo = 'upload/dealer_images/' . $name_gen1;
        } else {
            $profile_photo = '';
        }

        if ($request->hasfile('bank_information')) {
            $image_info = $request->file('bank_information');
            $name_gen_info = hexdec(uniqid()) . '.' . $image_info->getClientOriginalExtension();
            'Image'::make($image_info)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_info);
            $bank_information = 'upload/dealer_images/' . $name_gen_info;
        } else {
            $bank_information = '';
        }

        if ($request->hasfile('nid')) {
            $image_nid = $request->file('nid');
            $name_gen_nid = hexdec(uniqid()) . '.' . $image_nid->getClientOriginalExtension();
            'Image'::make($image_nid)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_nid);
            $nid = 'upload/dealer_images/' . $name_gen_nid;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image_trade = $request->file('trade_license');
            $name_gen_trade = hexdec(uniqid()) . '.' . $image_trade->getClientOriginalExtension();
            'Image'::make($image_trade)->resize(300, 300)->save('upload/dealer_images/' . $name_gen_trade);
            $trade_license = 'upload/dealer_images/' . $name_gen_trade;
        } else {
            $trade_license = '';
        }

        $userEmail = User::where('email', $request->email)->first();
        $userPhone = User::where('phone', $request->phone)->first();
        if ($userEmail) {
            $notification = array(
                'message' => 'Dealer email already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } elseif ($userPhone) {
            $notification = array(
                'message' => 'Dealer Phone already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $user = User::create([
                'name'              => $request->name,
                'profile_image'     => $profile_photo,
                'username'          => $slug,
                'email'             => $request->email,
                'address'           => $request->address,
                'phone'             => $request->phone,
                'password'          => Hash::make($request->password),
                'role'              => 6,
                'status'            => 0,
                'is_approved'       => 0,
            ]);
        }
        event(new Registered($user));

        //Auth::login($user);

        Dealer::insert([
            'name'                  => $request->name,
            'user_id'               => $user->id,
            'address'               => $request->address,
            'description'           => $request->description,
            'bank_name'             => $request->bank_name,
            'bank_account'          => $request->bank_account,
            'profile_image'         => $profile_photo,
            'bank_account_img'      => $bank_information,
            'nid'                   => $nid,
            'trade_license'         => $trade_license,
            'status'                => 0,
            'created_by'            => $user->id,
        ]);

        $notification = array(
            'message' => 'Application submitted successfully! Please wait for admin approval',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    // Vendor Apply
    public function vendorApply(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address'       => 'required',
            'shop_profile'  => 'required',
            'shop_cover'    => 'required',
        ]);

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . Str::random(5);
        }

        if ($request->hasfile('shop_profile')) {
            $image = $request->file('shop_profile');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $shop_profile = 'upload/vendor/' . $name_gen;
        } else {
            $shop_profile = '';
        }

        if ($request->hasfile('shop_cover')) {
            $image = $request->file('shop_cover');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $shop_cover = 'upload/vendor/' . $name_gen;
        } else {
            $shop_cover = '';
        }

        if ($request->hasfile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $nid = 'upload/vendor/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image = $request->file('trade_license');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/vendor/' . $name_gen);
            $trade_license = 'upload/vendor/' . $name_gen;
        } else {
            $trade_license = '';
        }

        $userEmail = User::where('email', $request->email)->first();
        $userPhone = User::where('phone', $request->phone)->first();
        if ($userEmail) {
            $notification = array(
                'message' => 'Vendor email already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } elseif ($userPhone) {
            $notification = array(
                'message' => 'Vendor Phone already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $user = User::create([
                'name'          => $request->shop_name,
                'username'      => $slug,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'profile_image' => $shop_profile,
                'password'      => Hash::make($request->password),
                'role'          => 2,
                'status'        => 0,
                'is_approved'   => 0,
            ]);
        }
        event(new Registered($user));

        Vendor::insert([
            'shop_name'         => $request->shop_name,
            'slug'              => $slug,
            'user_id'           => $user->id,
            'address'           => $request->address,
            'description'       => $request->description,
            'shop_profile'      => $shop_profile,
            'shop_cover'        => $shop_cover,
            'nid'               => $nid,
            'trade_license'     => $trade_license,
            'status'            => 0,
            'created_by'        => $user->id,
        ]);

        $notification = array(
            'message' => 'Application submitted successfully! Please wait for admin approval',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    // Seller Apply
    public function sellerApply(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address'       => 'required',
            'shop_profile'  => 'required',
            'shop_cover'    => 'required',
        ]);

        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->shop_name)) . '-' . Str::random(5);
        }

        if ($request->hasfile('shop_profile')) {
            $image = $request->file('shop_profile');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_profile = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_profile = '';
        }

        if ($request->hasfile('shop_cover')) {
            $image = $request->file('shop_cover');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $shop_cover = 'upload/seller_images/' . $name_gen;
        } else {
            $shop_cover = '';
        }

        if ($request->hasfile('nid')) {
            $image = $request->file('nid');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $nid = 'upload/seller_images/' . $name_gen;
        } else {
            $nid = '';
        }

        if ($request->hasfile('trade_license')) {
            $image = $request->file('trade_license');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            'Image'::make($image)->resize(300, 300)->save('upload/seller_images/' . $name_gen);
            $trade_license = 'upload/seller_images/' . $name_gen;
        } else {
            $trade_license = '';
        }

        $userEmail = User::where('email', $request->email)->first();
        $userPhone = User::where('phone', $request->phone)->first();
        if ($userEmail) {
            $notification = array(
                'message' => 'Seller email already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else if ($userPhone) {
            $notification = array(
                'message' => 'Seller Phone already Created',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $user = User::create([
                'name'          => $request->shop_name,
                'username'      => $slug,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'profile_image' => $shop_profile,
                'password'      => Hash::make($request->password),
                'role'          => 9,
                'status'        => 0,
                'is_approved'   => 0,
            ]);
        }
        event(new Registered($user));

        $seller = Seller::create([
            'shop_name'         => $request->shop_name,
            'slug'              => $slug,
            'user_id'           => $user->id,
            'address'           => $request->address,
            'description'       => $request->description,
            'shop_profile'      => $shop_profile,
            'shop_cover'        => $shop_cover,
            'nid'               => $nid,
            'trade_license'     => $trade_license,
            'status'            => 0,
            'created_by'        => $user->id,
        ]);
        if ($seller) {
            $user->update(['seller_id' => $seller->id]);
            $user->save();
        } else {
            return back()->with('error', 'No seller found');
        }

        $notification = array(
            'message' => 'Application submitted successfully! Please wait for admin approval',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
