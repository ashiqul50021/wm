<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\API\Seller\SellerProductApiController;
use App\Http\Controllers\Controller;
use App\Models\AccountLedger;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Seller;
use App\Models\Supplier;
use App\Models\Unit;
use Carbon\Carbon;
use Exception;
use Image;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SellerProductController extends Controller
{
    public function ProductView()
    {

        $role = Auth::guard('seller')->user()->role;
        $position = '';
        if (Auth::guard('seller')->user()->role == '9') {
            $products = Product::where('seller_id', Auth::guard('seller')->user()->id)->latest()->get();
            return view('seller.template.product.product_view', compact('products'));
        }
    } // end method

    /*=================== Start ProductAdd Methoed ===================*/
    public function ProductAdd()
    {
        $role = Auth::guard('seller')->user()->role;
        $categories = Category::where('parent_id', 0)->with('childrenCategories')->orderBy('name_en', 'asc')->get();
        $brands = Brand::latest()->get();
        $sellers = Seller::latest()->get();
        $suppliers = Supplier::latest()->get();
        $units = Unit::latest()->get();
        $attributes = Attribute::latest()->get();
        if ($role == '9') {

            return view('seller.template.product.product_add', compact('categories', 'brands', 'sellers', 'suppliers', 'attributes', 'units'));
        }
    } // end method

    /*=================== Start StoreProduct Methoed ===================*/
    public function StoreProduct(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name_en'           => 'required|max:150',
            'description_en'    => 'nullable|string',
            'category_id'       => 'required|integer',
            'unit_weight'       => 'nullable|numeric',
            'unit_id'           => 'nullable|integer',
            'product_thumbnail' => 'nullable|file',
        ]);

        if (!$request->name_bn) {
            $request->name_bn = $request->name_en;
        }

        if (!$request->description_bn) {
            $request->description_bn = $request->description_en;
        }

        // $slug = strtolower(str_replace(' ', '-', $request->name_en));




        if ($request->supplier_id == null || $request->supplier_id == "") {
            $request->supplier_id = 0;
        }

        if ($request->unit_id == null || $request->unit_id == "") {
            $request->unit_id = 0;
        }

        if ($request->hasFile('product_thumbnail')) {
            $image = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
            $save_url = 'upload/products/thumbnails/' . $name_gen;
        } else {
            $save_url = '';
        }

        if ($request->is_variant == 1) {

            if ($request->has('vpurchesprices')) {
                $i = 0;
                foreach ($request->vpurchesprices as $key => $purchasePrice) {

                    $product_name = $request->name_en;
                    $variant_name = $request->vnames[$i];
                    $combinedName = $variant_name . ' ' . $product_name;
                    // dd($combinedName);

                    $product = Product::create([
                        'brand_id'              => $request->brand_id,
                        'category_id'           => $request->category_id,
                        'seller_id'             => Auth::guard('seller')->user()->id,
                        'supplier_id'           => $request->supplier_id,
                        'unit_id'               => $request->unit_id,
                        'name_en'               => $combinedName,
                        'name_bn'               => $request->name_bn,
                        'variant_name'          => $request->vnames[$i],
                        'url'                   => $request->url,
                        'slug'                  => Str::slug($request->name_en) . '-' . Str::random(6),
                        'unit_weight'           => $request->unit_weight,
                        'purchase_price'        => $purchasePrice,
                        'purchase_code'        => $request->vpurchescodes[$i] ?? 0,
                        'wholesell_price'       => $request->vwholesaleprices[$i] ?? 0,
                        'wholesell_minimum_qty' => $request->vwholesaleqtys[$i] ?? 0,
                        'regular_price'         => $request->vprices[$i] ?? 0,
                        'discount_price'        => $request->vdis_prices[$i] ?? 0,
                        'product_code'          => rand(10000, 99999),
                        'description_en'        => $request->description_en,
                        'description_bn'        => $request->description_bn,
                        'is_featured'           => $request->is_featured ? 1 : 0,
                        'is_deals'              => $request->is_deals ? 1 : 0,
                        'is_digital'            => $request->is_digital ? 1 : 0,
                        'is_dealer'             => $request->is_dealer ? 1 : 0,
                        'status'                => $request->status ? 1 : 0,
                        'discount_type'         => $request->vdis_types[$i] ?? 0,
                        'is_varient'            => $request->is_variant,
                        'stock_qty'             => $request->vqtys[$i] ?? 0,
                        'body_rate'             => $request->vbodyrates[$i],
                        'finishing_rate'        => $request->vfinishingrates[$i],
                        'discount_type'         => $request->vdis_type[$i] ?? 0,
                        'model_number'          => $request->vskus[$i] ?? 0,
                        'approved'              => 0,
                        'created_by'            => Auth::guard('seller')->user()->id,

                    ]);



                    if ($request->vimages) {
                        $image = $request->vimages[$i];
                        if ($image) {
                            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                            Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
                            $save_url = 'upload/products/thumbnails/' . $name_gen;
                        } else {
                            $save_url = '';
                        }
                        $product->product_thumbnail = $save_url;
                    }
                    if ($request->vmanufimages) {
                        $image = $request->vmanufimages[$i];
                        if ($image) {
                            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                            Image::make($image)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gen);
                            $save_url_menufacture = 'upload/products/menufacturingimages/' . $name_gen;
                        } else {
                            $save_url_menufacture = '';
                        }
                        $product->menu_facture_image = $save_url_menufacture;
                    }

                    /* =========== Start Product Tags =========== */
                    $product->tags = implode(',', $request->tags);
                    /* =========== End Product Tags =========== */


                    /* ========= Product Attributes Start ========= */
                    $attribute_values = array();
                    if ($request->has('choice_attributes')) {
                        foreach ($request->choice_attributes as $key => $attribute) {
                            $atr = 'choice_options' . $attribute;
                            $item['attribute_id'] = $attribute;
                            $data = array();

                            foreach ($request[$atr] as $key => $value) {
                                array_push($data, $value);
                            }

                            $item['values'] = $data;
                            array_push($attribute_values, $item);
                        }
                    }

                    if (!empty($request->choice_attributes)) {
                        $product->attributes = json_encode($request->choice_attributes);
                        // $product->is_varient = 1;


                    } else {
                        $product->attributes = json_encode(array());
                    }

                    $attr_values = collect($attribute_values);
                    $attr_values_sorted = $attr_values->sortByDesc('attribute_id');

                    $sorted_array = array();
                    foreach ($attr_values_sorted as $attr) {
                        array_push($sorted_array, $attr);
                    }

                    $product->attribute_values = json_encode($sorted_array, JSON_UNESCAPED_UNICODE);
                    /* ========= End Product Attributes ========= */



                    // if ($request->vmanufimages) {
                    //     $menuimage = $request->vmanufimages[$i];
                    //     if ($menuimage) {
                    //         $name_gens = hexdec(uniqid()) . '.' . $menuimage->getClientOriginalExtension();
                    //         Image::make($menuimage)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gens);
                    //         $save_url_menu = 'upload/products/menufacturingimages/' . $name_gens;
                    //     } else {
                    //         $save_url_menu = '';
                    //     }
                    //     $stock->manufimage = $save_url_menu;
                    // }
                    $product->save();

                    $i++;
                }
            }
        } else {
            if ($request->slug != null) {
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            } else {
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
            }

            $product = Product::create([
                'brand_id'              => $request->brand_id,
                'category_id'           => $request->category_id,
                'seller_id'             =>  Auth::guard('seller')->user()->id,
                'supplier_id'           => $request->supplier_id,
                'model_number'           => $request->model_number,
                'unit_id'               => $request->unit_id,
                'name_en'               => $request->name_en,
                'name_bn'               => $request->name_bn,
                'slug'                  => $slug,
                'unit_weight'           => $request->unit_weight,
                'url'                   => $request->url,
                'purchase_price'        => $request->purchase_price ?? 0,
                'purchase_code'         => $request->purchase_code ?? '',
                'wholesell_price'       => $request->wholesell_price ?? 0,
                'wholesell_minimum_qty' => $request->wholesell_minimum_qty ?? 0,
                'regular_price'         => $request->regular_price ?? 0,
                'discount_price'        => $request->discount_price ?? 0,
                'discount_type'         => $request->discount_type ?? 0,
                'product_code'          => rand(10000, 99999),
                'minimum_buy_qty'       => $request->minimum_buy_qty ?? 0,
                'stock_qty'             => $request->stock_qty ?? 0,
                'description_en'        => $request->description_en,
                'description_bn'        => $request->description_bn,
                'is_featured'           => $request->is_featured ? 1 : 0,
                'is_deals'              => $request->is_deals ? 1 : 0,
                'is_digital'            => $request->is_digital ? 1 : 0,
                'is_dealer'             => $request->is_dealer ? 1 : 0,
                'status'                => $request->status ? 1 : 0,
                'product_thumbnail'     => $save_url,
                'approved'              => 0,
                'created_by'            => Auth::guard('seller')->user()->id,
            ]);

            /* =========== Start Product Tags =========== */
            $product->tags = implode(',', $request->tags);
            /* =========== End Product Tags =========== */

            /* ========= Product Attributes Start ========= */
            $attribute_values = array();

            if ($request->has('choice_attributes') && is_array($request->choice_attributes)) {
                foreach ($request->choice_attributes as $key => $attribute) {
                    $atr = 'choice_options' . $attribute;
                    $item['attribute_id'] = $attribute;
                    $data = array();

                    foreach ($request[$atr] ?? [] as $key => $value) {
                        array_push($data, $value);
                    }

                    $item['values'] = $data;
                    array_push($attribute_values, $item);
                }
            }

            if (!empty($request->choice_attributes)) {
                $product->attributes = json_encode($request->choice_attributes);
                // $product->is_varient = 1;


            } else {
                $product->attributes = json_encode(array());
            }

            $attr_values = collect($attribute_values);
            $attr_values_sorted = $attr_values->sortByDesc('attribute_id');

            $sorted_array = array();
            foreach ($attr_values_sorted as $attr) {
                array_push($sorted_array, $attr);
            }

            $product->attribute_values = json_encode($sorted_array, JSON_UNESCAPED_UNICODE);
            /* ========= End Product Attributes ========= */
        }




        $images = $request->file('multi_img');
        if ($images) {
            foreach ($images as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
                $uploadPath = 'upload/products/multi-image/' . $make_name;

                MultiImg::create([
                    'product_id' => $product->id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        /* ========= End Multiple Image Upload ========= */

        // Save the product after associating tags, attributes, and images
        $product->save();
        $ledger_balance = get_vendor_account_balance(Auth::guard('seller')->user()->id) - $product->purchase_price * $product->stock_qty;
        //Ledger Entry
        $ledger = AccountLedger::create([
            'account_head_id' => 1,
            'seller_id' => Auth::guard('seller')->user()->id,
            'particulars' => "Purchase Product",
            'debit' => $product->purchase_price * $product->stock_qty,
            'balance' => $ledger_balance,
            'product_id' => $product->id,
            'type' => 1,
        ]);

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('seller.product.all')->with($notification);
    } // end method

    /*=================== Start EditProduct Methoed ===================*/
    public function EditProduct($id)
    {
        $role = Auth::guard('seller')->user()->role;
        $product = Product::findOrFail($id);

        $multiImgs = MultiImg::where('product_id', $id)->get();

        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $sellers = Seller::latest()->get();
        $suppliers = Supplier::latest()->get();
        $units = Unit::latest()->get();
        $attributes = Attribute::latest()->get();

        if ($role == '9') {
            return view('seller.template.product.product_edit', compact('categories', 'sellers', 'suppliers', 'brands', 'attributes', 'product', 'multiImgs', 'units'));
        }
    } // end method


    public function barcodeGenarate($id)
    {
        $role = Auth::guard('seller')->user()->role;
        if($role == '9'){
            $product = Product::where('seller_id', Auth::guard('seller')->user()->id)->find($id);
            return view('seller.template.product.barcode_generate', compact('product'));
        }

        // dd($product);
    }

    public function duplicateProduct($id)
    {
        $product = Product::find($id);
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {
        $product = Product::create([
            'brand_id'              => $product->brand_id ?? '',
            'category_id'           => $product->category_id ?? '',
            'sub_category_id'       => $product->sub_category_id ?? null,
            'sub_sub_category_id'   => $product->sub_sub_category_id ?? null,
            'seller_id'             => Auth::guard('seller')->user()->id ?? '',
            'supplier_id'           => $product->supplier_id ?? '',
            'unit_id'               => $product->unit_id ?? '',
            'tags'                  => $product->tags ?? '',
            "campaing_id"           => $product->campaing_id ?? null,
            'is_wholesell'          => $product->is_wholesell ?? 0,
            'name_en'               => $product->name_en ?? '',
            'name_bn'               => $product->name_bn ?? '',
            'variant_name'          => $product->variant_name ?? '',
            'url'                   => $product->url ?? '',
            'slug'                  => Str::slug($product->name_en) . '-' . Str::random(6),
            'unit_weight'           => $product->unit_weight ?? '',
            'purchase_price'        => $product->purchase_price ?? '',
            'purchase_code'         => $product->purchase_code ?? '',
            'wholesell_price'       => $product->wholesell_price ?? 0,
            'wholesell_minimum_qty' => $product->wholesell_minimum_qty ?? 0,
            'regular_price'         => $product->regular_price ?? 0,
            'discount_price'        => $product->discount_price ?? 0,
            'product_code'          => rand(10000, 99999),
            'description_en'        => $product->description_en ?? '',
            'description_bn'        => $product->description_bn ?? '',
            'is_featured'           => $product->is_featured ? 1 : 0,
            'is_deals'              => $product->is_deals ? 1 : 0,
            'is_digital'            => $product->is_digital ? 1 : 0,
            'is_dealer'             => $product->is_dealer ? 1 : 0,
            'status'                => $product->status ? 1 : 0,
            'discount_type'         => $product->discount_type ?? 0,
            'is_varient'            => $product->is_variant ?? 0,
            'stock_qty'             => $product->stock_qty ?? 0,
            'body_rate'             => $product->body_rate ?? 0,
            'finishing_rate'        => $product->finishing_rate ?? 0,
            'model_number'          => $product->model_number ?? 0,
            'product_thumbnail'     =>  null,
            'menu_facture_image'    =>  null,
            'attributes'            => $product->attributes ?? null,
            'attribute_values'      => $product->attribute_values ?? null,
            'variations'            => $product->variations ?? null,
            'approved'              => 1,
            'created_by'            => Auth::guard('seller')->user()->id,

        ]);

        $ledger_balance = get_account_balance() - $product->purchase_price * $product->stock_qty;
        //Ledger Entry
        $ledger = AccountLedger::create([
            'account_head_id' => 1,
            'particulars' => $product->name_en,
            'debit' => $product->purchase_price * $product->stock_qty,
            'balance' => $ledger_balance,
            'product_id' => $product->id,
            'type' => 1,
        ]);

        $notification = array(
            'message' => 'Product duplicated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
     }
    }

    /*=================== Start ProductUpdate Methoed ===================*/
    public function ProductUpdate(Request $request, $id)
    {

        //return $request;
        $product = Product::find($id);
        // return $request;
        $this->validate($request, [
            'name_en'           => 'required|max:150',
            // 'purchase_price'    => 'nullable|numeric',
            // 'wholesell_price'   => 'nullable|numeric',
            // 'discount_price'    => 'nullable|numeric',
            // 'regular_price'     => 'nullable|numeric',
            'stock_qty'         => 'nullable|integer',
            'description_en'    => 'nullable|string',
            'category_id'       => 'required|integer',
            'brand_id'          => 'nullable|integer',
            'unit_id'           => 'nullable|integer',
            'unit_weight'       => 'nullable|numeric',
        ]);

        if (!$request->name_bn) {
            $request->name_bn = $request->name_en;
        }

        if (!$request->description_bn) {
            $request->description_bn = $request->description_en;
        }

        if ($request->name_en != $product->name_en) {
            if ($request->slug != null) {
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            } else {
                $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
            }
        } else {
            $slug = $product->slug;
        }



        if ($request->supplier_id == null || $request->supplier_id == "") {
            $request->supplier_id = 0;
        }

        if ($request->unit_id == null || $request->unit_id == "") {
            $request->unit_id = 0;
        }

        if ($product->approved == 1) {
            $approved = 1;
        } else {
            $approved = 0;
        }

        if ($request->hasFile('product_thumbnail')) {
            try {
                if (file_exists($product->product_thumbnail)) {
                    unlink($product->product_thumbnail);
                }
            } catch (Exception $e) {
            }
            $image = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
            $save_url = 'upload/products/thumbnails/' . $name_gen;
        } else {
            $save_url = $product->product_thumbnail;
        }

        if ($request->hasFile('menu_facture_image')) {
            try {
                if (file_exists($product->menu_facture_image)) {
                    unlink($product->menu_facture_image);
                }
            } catch (Exception $e) {
            }
            $menufactureImage = $request->file('menu_facture_image');
            $name_gen = hexdec(uniqid()) . '.' . $menufactureImage->getClientOriginalExtension();
            Image::make($menufactureImage)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gen);
            $save_url_menufacture = 'upload/products/menufacturingimages/' . $name_gen;
        } else {
            $save_url_menufacture = $product->menu_facture_image;
        }

        $product->update([
            'brand_id'              => $request->brand_id,
            'category_id'           => $request->category_id,
            'seller_id'             => $request->seller_id,
            'supplier_id'           => $request->supplier_id,
            'unit_id'               => $request->unit_id,
            'name_en'               => $request->name_en,
            'name_bn'               => $request->name_bn,
            'slug'                  => $slug,
            'url'                   => $request->url,
            'unit_weight'           => $request->unit_weight,
            'purchase_price'        => $request->purchase_price ?? 0,
            'purchase_code'         => $request->purchase_code ?? '',
            'wholesell_price'       => $request->wholesell_price ?? 0,
            'wholesell_minimum_qty' => $request->wholesell_minimum_qty ?? 0,
            'regular_price'         => $request->regular_price ?? 0,
            'discount_price'        => $request->discount_price ?? 0,
            'discount_type'         => $request->discount_type ?? 0,
            'model_number'          => $request->model_number ?? null,
            'body_rate'             => $request->body_rate ?? null,
            'finishing_rate'        => $request->finishing_rate ?? null,
            'minimum_buy_qty'       => $request->minimum_buy_qty ?? 0,
            'stock_qty'             => $request->stock_qty ?? 0,
            'description_en'        => $request->description_en,
            'description_bn'        => $request->description_bn,
            'is_featured'           => $request->is_featured ? 1 : 0,
            'is_deals'              => $request->is_deals ? 1 : 0,
            'is_digital'            => $request->is_digital ? 1 : 0,
            'is_dealer'             => $request->is_dealer ? 1 : 0,
            'status'                => $request->status ? 1 : 0,
            'product_thumbnail'     => $save_url,
            'menu_facture_image'    => $save_url_menufacture,
            'approved'              => $approved,
            'created_by'            => Auth::guard('seller')->user()->id,
        ]);

        /* ========= Product Previous Stock Clear ========= */
        $product_stocks = $product->stocks;
        if (count($product_stocks) > 0) {
            if ($request->is_variation_changed) {
                foreach ($product_stocks as $stock) {
                    // unlink($stock->image);
                    try {
                        if (file_exists($stock->image)) {
                            unlink($stock->image);
                        }
                    } catch (Exception $e) {
                    }

                    try {
                        if (file_exists($stock->vmanufimage)) {
                            unlink($stock->vmanufimage);
                        }
                    } catch (Exception $e) {
                    }
                    $stock->delete();
                }
            } else {
                foreach ($product_stocks as $stock) {
                    $variant = $stock->id . "_variant";
                    $price = $stock->id . "_price";
                    $bodyrate = $stock->id . "_bodyrate";
                    // dd($bodyrate);
                    $finishingrate = $stock->id . "_finishingrate";
                    $purchesprice = $stock->id . "_purchesprice";
                    $wholesaleprice = $stock->id . "_wholesaleprice";
                    $wholesaleqty = $stock->id . "_wholesaleqty";
                    $sku = $stock->id . "_sku";
                    $qty = $stock->id . "_qty";
                    $dis_price = $stock->id . "_dis_price";
                    // $dis_type = $stock->id."_dis_type";
                    $image = $stock->id . "_image";
                    $vmanufimage = $stock->id . "_vmanufimage";
                    // dd($vmanufimage);
                    $stock->update([
                        'sku'               => $request->$sku,
                        'price'             => $request->$price,
                        'purchesprice'      => $request->$purchesprice,
                        'bodyrate'          => $request->$bodyrate,
                        'finishingrate'     => $request->$finishingrate,
                        'wholesaleprice'    => $request->$wholesaleprice,
                        'wholesaleqty'      => $request->$wholesaleqty,
                        'qty'               => $request->$qty,
                        'dis_price'         => $request->$dis_price,
                        // 'dis_type'          => $request->$dis_type,
                    ]);
                }
            }
        }

        if ($request->is_variation_changed) {
            /* ========= Product Attributes Start ========= */
            $attribute_values = array();
            if ($request->has('choice_attributes')) {
                foreach ($request->choice_attributes as $key => $attribute) {
                    $atr = 'choice_options' . $attribute;
                    $item['attribute_id'] = $attribute;
                    $data = array();

                    foreach ($request[$atr] as $key => $value) {
                        array_push($data, $value);
                    }

                    $item['values'] = $data;
                    array_push($attribute_values, $item);
                }
            }

            if (!empty($request->choice_attributes)) {
                $product->attributes = json_encode($request->choice_attributes);
                $product->is_varient = 1;

                if ($request->has('vnames')) {
                    $i = 0;
                    foreach ($request->vnames as $key => $name) {
                        $stock = ProductStock::create([
                            'product_id'        => $product->id,
                            'varient'           => $name,
                            'sku'               => $request->vskus[$i],
                            'price'             => $request->vprices[$i],
                            'bodyrate'          => $request->vbodyrates[$i],
                            'finishingrate'     => $request->vfinishingrates[$i],
                            'purchesprice'      => $request->purchesprices[$i],
                            'wholesaleprice'    => $request->vwholesaleprices[$i],
                            'wholesaleqty'      => $request->vwholesaleqtys[$i],
                            'qty'               => $request->vqtys[$i],
                            'dis_price'         => $request->vdis_prices[$i],
                            // 'dis_type'          => $request->vdis_types[$i],
                        ]);
                        if ($request->vimages) {
                            $image = $request->vimages[$i];
                            if ($image) {
                                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                                Image::make($image)->resize(438, 438)->save('upload/products/variations/' . $name_gen);
                                $save_url = 'upload/products/variations/' . $name_gen;
                            } else {
                                $save_url = '';
                            }
                            $stock->image = $save_url;
                        }
                        if ($request->vmanufimages) {
                            $vmanufimage = $request->vmanufimages[$i];
                            if ($vmanufimage) {
                                $name_gen_v = hexdec(uniqid()) . '.' . $vmanufimage->getClientOriginalExtension();
                                Image::make($image)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gen_v);
                                $save_url_v = 'upload/products/menufacturingimages/' . $name_gen_v;
                            } else {
                                $save_url_v = '';
                            }
                            $stock->vmanufimage = $save_url_v;
                        }
                        $stock->save();
                        $i++;
                    }
                }
            } else {
                $product->attributes = json_encode(array());
                $product->is_varient = 0;
            }

            $attr_values = collect($attribute_values);
            $attr_values_sorted = $attr_values->sortByDesc('attribute_id');

            $sorted_array = array();
            foreach ($attr_values_sorted as $attr) {
                array_push($sorted_array, $attr);
            }

            $product->attribute_values = json_encode($sorted_array, JSON_UNESCAPED_UNICODE);
            /* ========= End Product Attributes ========= */
        }


        /* =========== Start Product Tags =========== */
        $product->tags = implode(',', $request->tags);
        /* =========== End Product Tags =========== */

        /* =========== Multiple Image Update =========== */

        $images = $request->file('multi_img');

        if ($images == Null) {
            $product->multi_imgs->photo_name = $request->multi_img;
            $product->update();
        } else {
            foreach ($images as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
                $uploadPath = 'upload/products/multi-image/' . $make_name;

                MultiImg::insert([
                    'product_id' => $product->id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $product->save();


        Session::flash('success', 'Product Updated Successfully');
        // return redirect()->route('vendor.product.all');
        return redirect()->back();
    } // end method
    /*=================== End ProductUpdate Methoed ===================*/

    /*=================== Start Multi Image Delete =================*/
    public function MultiImageDelete($id)
    {
        $oldimg = MultiImg::findOrFail($id);
        try {
            if (file_exists($oldimg->photo_name)) {
                unlink($oldimg->photo_name);
            }
        } catch (Exception $e) {
        }
        MultiImg::findOrFail($id)->delete();


        return response()->json(['success' => 'Product Deleted Successfully']);
    } // end method
    /*=================== End Multi Image Delete =================*/

    /*=================== Start ProductDelete Method =================*/
    public function ProductDelete($id)
    {
        $role = Auth::guard('seller')->user()->role;

        // dd($product);
        if ($role == '9') {
        if (!demo_mode()) {
            $product = Product::findOrFail($id);

            try {
                if (file_exists($product->product_thumbnail)) {
                    unlink($product->product_thumbnail);
                }
            } catch (Exception $e) {
            }

            $product->delete();

            $images = MultiImg::where('product_id', $id)->get();
            foreach ($images as $img) {
                try {
                    if (file_exists($img->photo_name)) {
                        unlink($img->photo_name);
                    }
                } catch (Exception $e) {
                }
                MultiImg::where('product_id', $id)->delete();
            }

            $notification = array(
                'message' => 'Product Deleted Successfully',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Product can not be deleted on demo mode.',
                'alert-type' => 'error'
            );
        }

        return redirect()->back()->with($notification);
    }
    } // end method
    /*=================== End ProductDelete Method =================*/

    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->save();

        $notification = array(
            'message' => 'Product Active Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function inactive($id)
    {
        $product = Product::find($id);
        $product->status = 0;
        $product->save();

        $notification = array(
            'message' => 'Product Inactive Successfully.',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    } // end method

    /*=================== Start Featured Methoed ===================*/
    public function featured($id)
    {
        $product = Product::find($id);
        if ($product->is_featured == 1) {
            $product->is_featured = 0;
        } else {
            $product->is_featured = 1;
        }
        $product->save();
        $notification = array(
            'message' => 'Product Feature Status Changed Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    /*=================== Start Category With SubCategory  Ajax ===================*/
    public function GetSubProductCategory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderBy('subcategory_name_en', 'ASC')->get();
        return json_encode($subcat);
    } // end method

    /*=================== Start SubCategory With Childe Ajax ===================*/
    public function GetSubSubCategory($subcategory_id)
    {
        $childe = SubSubCategory::where('subcategory_id', $subcategory_id)->orderBy('subsubcategory_name_en', 'ASC')->get();
        return json_encode($childe);
    } // end method

    public function add_more_choice_option(Request $request)
    {
        $attributes = Attribute::whereIn('id', $request->attribute_ids)->get();
        // dd($attributes);
        return view('backend.product.attribute_select_value', compact('attributes'));
    }


    /* ============== Category Store Ajax ============ */
    public function categoryInsert(Request $request)
    {
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {

        if ($request->name_en == Null) {
            return response()->json(['error' => 'Category Field  Required']);
        }

        $category = new Category();

        $category->name_en = $request->name_en;

        /* ======== Category Name English ======= */
        $category->name_en = $request->name_en;
        if ($request->name_bn == '') {
            $category->name_bn = $request->name_en;
        } else {
            $category->name_bn = $request->name_bn;
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/category/' . $name_gen);
            $save_url = 'upload/category/' . $name_gen;
        } else {
            $save_url = '';
        }

        $category->image = $save_url;
        $category->created_by = Auth::guard('seller')->user()->id;
        $category->save();

        $categories = Category::with('childrenCategories')->orderBy('name_en', 'asc')->get();

        return response()->json([
            'success' => 'Category Inserted Successfully',
            'categories' => $categories,
        ]);
      }
    }

    /* ============== Brand Store Ajax ============ */

    /* ============== Brand Store Ajax ============== */
    public function brandInsert(Request $request)
    {
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {

        if ($request->name_en == Null) {
            return response()->json(['error' => 'Brand Field  Required']);
        }

        $brand = new Brand();

        $brand->name_en = $request->name_en;

        /* ======== brand Name English ======= */
        $brand->name_en = $request->name_en;
        if ($request->name_bn == '') {
            $brand->name_bn = $request->name_en;
        } else {
            $brand->name_bn = $request->name_bn;
        }

        /* ======== Category Slug   ======= */
        if ($request->slug != null) {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
        }



        // dd($request->image);


        if ($request->hasFile('brand_image')) {
            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);
            $save_url = 'upload/brand/' . $name_gen;
        } else {
            $save_url = '';
        }

        $brand->brand_image = $save_url;
        $brand->created_by = Auth::guard('seller')->user()->id;

        $brand->save();
        $brands = Brand::all();

        return response()->json([
            'success' => 'Brand Inserted Successfully',
            'brands' => $brands,
        ]);
    }
    }

}
