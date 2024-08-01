<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AccountHead;
use App\Models\AccountLedger;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\MultiImg;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductMenufactureInfo;
use App\Models\ProductReview;
use App\Models\ProductStock;
use App\Models\Unit;
use App\Models\Staff;
use Carbon\Carbon;
use Image;
use Session;
use Illuminate\Support\Str;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /*=================== Start ProductView Methoed ===================*/
    public function ProductView()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('2', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            $products = Product::where('vendor_id', 0)->latest()->get();
            // dd($products);
            return view('backend.product.product_view', compact('products'));
        } else {
            $notification = array(
                'message' => 'Sorry! you cannot Access This page!',
                'alert-type' => 'Warning'
            );
            return redirect()->back()->with($notification);
        }
    } // end method



    // public function updateQuantity(Request $request, $id)
    // {
    //     $product = Product::find($id);

    //     if (!$product) {
    //         return response()->json(['success' => false, 'message' => 'Product not found']);
    //     }
    //     $request->validate([
    //         'quantity' => 'required|numeric|min:0',
    //     ]);

    //     $product->stock_qty = $request->quantity;
    //     $product->save();

    //     return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    // }


    //     public function updateQuantity(Request $request, $id)
    // {
    //     $product = Product::find($id);

    //     if (!$product) {
    //         return response()->json(['success' => false, 'message' => 'Product not found']);
    //     }

    //     $request->validate([
    //         'quantity' => 'required|numeric|min:0',
    //     ]);

    //     $product->stock_qty += $request->quantity;
    //     $product->quantity_update_info

    //     $product->save();

    //     return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    // }

    public function updateQuantity(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);
        $previousQuantity = $product->stock_qty;
        $product->stock_qty += $request->quantity;
        $product->quantity_update_info = [
            'updated_at' => now(),
            'user_id' => Auth::guard('admin')->user()->id,
            'quantity_update' => $request->quantity,
            'previous_quantity' => $previousQuantity,
        ];

        $product->save();

        return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
    }

    /*=================== Start ProductAdd Method ===================*/
    public function ProductAdd()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('1', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            $categories = Category::where('parent_id', 0)->with('childrenCategories')->orderBy('name_en', 'asc')->get();
            $brands = Brand::latest()->get();
            $vendors = Vendor::latest()->get();
            $suppliers = Supplier::latest()->get();
            $units = Unit::latest()->get();
            $attributes = Attribute::latest()->get();
            return view('backend.product.product_add', compact('categories', 'brands', 'vendors', 'suppliers', 'attributes', 'units'));
        } else {
            $notification = array(
                'message' => 'Sorry! you cannot Access This page!',
                'alert-type' => 'Warning'
            );
            return redirect()->back()->with($notification);
        }
    } // end method

    /*=================== Start StoreProduct Methoed ===================*/
    public function StoreProduct(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name_en'           => 'required|max:150',
            'purchase_price'    => 'nullable|numeric',
            'wholesell_price'   => 'nullable|numeric',
            'discount_price'    => 'nullable|numeric',
            'regular_price'     => 'nullable|numeric',
            // 'stock_qty'         => 'required|integer',
            // 'minimum_buy_qty'   => 'required|integer',
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


        if ($request->vendor_id == null || $request->vendor_id == "") {
            $request->vendor_id = 0;
        }

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
                        'vendor_id'             => $request->vendor_id,
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
                        'whole_sell_dis_type'   => $request->vwhole_dis_type[$i] ?? 0,
                        'whole_sell_dis'        => $request->vwholesalediscount[$i] ?? 0,
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
                        'approved'              => 1,
                        'created_by'            => Auth::guard('admin')->user()->id,
                        // 'product_id'        => $product->id,
                        // 'varient'           => $name,
                        // 'sku'               => $request->vskus[$i],
                        // 'price'             => $request->vprices[$i],
                        // 'bodyrate'          => $request->vbodyrates[$i],
                        // 'finishingrate'     => $request->vfinishingrates[$i],
                        // 'purchesprice'      => $request->vpurchesprices[$i],
                        // 'wholesaleprice'    => $request->vwholesaleprices[$i],
                        // 'wholesaleqty'      => $request->vwholesaleqtys[$i],
                        // 'qty'               => $request->vqtys[$i],
                        // 'dis_price'         => $request->vdis_prices[$i],
                        // 'dis_type'          => $request->vdis_types[$i],
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
                'vendor_id'             => $request->vendor_id ?? 0,
                'model_number'          => $request->model_number ?? 0,
                'supplier_id'           => $request->supplier_id,
                'unit_id'               => $request->unit_id,
                'name_en'               => $request->name_en,
                'name_bn'               => $request->name_bn,
                'slug'                  => $slug,
                'unit_weight'           => $request->unit_weight,
                'url'                   => $request->url,
                'purchase_price'        => $request->purchase_price ?? 0,
                'purchase_code'         => $request->purchase_code ?? '',
                'whole_sell_dis_type'   => $request->wholesell_discount_type ?? 0,
                'whole_sell_dis'        => $request->wholesell_discount ?? 0,
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
                'approved'              => 1,
                'created_by'            => Auth::guard('admin')->user()->id,
            ]);

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
        }




        /* ========= Start Multiple Image Upload ========= */
        $images = $request->file('multi_img');
        if ($images) {
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
        /* ========= End Multiple Image Upload ========= */



        $product->save();
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
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('product.all')->with($notification);
    } // end method

    // store duplicate product
    public function StoreDuplicateProduct(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name_en'           => 'required|max:150',
            'purchase_price'    => 'nullable|numeric',
            'wholesell_price'   => 'nullable|numeric',
            'discount_price'    => 'nullable|numeric',
            'regular_price'     => 'nullable|numeric',
            // 'stock_qty'         => 'required|integer',
            // 'minimum_buy_qty'   => 'required|integer',
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


        if ($request->vendor_id == null || $request->vendor_id == "") {
            $request->vendor_id = 0;
        }

        if ($request->supplier_id == null || $request->supplier_id == "") {
            $request->supplier_id = 0;
        }

        if ($request->unit_id == null || $request->unit_id == "") {
            $request->unit_id = 0;
        }



        if ($request->is_variant == 1) {


            $product = Product::create([
                'brand_id'              => $request->brand_id,
                'category_id'           => $request->category_id,
                'vendor_id'             => $request->vendor_id,
                'supplier_id'           => $request->supplier_id,
                'unit_id'               => $request->unit_id,
                'name_en'               => $request->name_en,
                'name_bn'               => $request->name_bn,
                'variant_name'          => $request->variant_name,
                'url'                   => $request->url,
                'slug'                  => Str::slug($request->name_en) . '-' . Str::random(6),
                'unit_weight'           => $request->unit_weight,
                'purchase_price'        => $request->purchase_price,
                'purchase_code'         => $request->purchase_code ?? '',
                'wholesell_price'       => $request->wholesell_price ?? 0,
                'whole_sell_dis_type'   => $request->wholesell_discount_type ?? 0,
                'whole_sell_dis'        => $request->wholesell_discount ?? 0,
                'wholesell_minimum_qty' => $request->wholesell_minimum_qty ?? 0,
                'regular_price'         => $request->regular_price ?? 0,
                'discount_price'        => $request->discount_price ?? 0,
                'product_code'          => rand(10000, 99999),
                'description_en'        => $request->description_en,
                'description_bn'        => $request->description_bn,
                'is_featured'           => $request->is_featured ? 1 : 0,
                'is_deals'              => $request->is_deals ? 1 : 0,
                'is_digital'            => $request->is_digital ? 1 : 0,
                'is_dealer'             => $request->is_dealer ? 1 : 0,
                'status'                => $request->status ? 1 : 0,
                'discount_type'         => $request->discount_type ?? 0,
                'is_varient'            => $request->is_variant,
                'stock_qty'             => $request->stock_qty ?? 0,
                'body_rate'             => $request->body_rate,
                'finishing_rate'        => $request->finishing_rate,
                'model_number'          => $request->model_number ?? 0,
                'approved'              => 1,
                'created_by'            => Auth::guard('admin')->user()->id,

            ]);

            if ($request->product_thumbnail) {
                $image = $request->product_thumbnail;
                if ($image) {
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
                    $save_url = 'upload/products/thumbnails/' . $name_gen;
                } else {
                    $save_url = '';
                }
                $product->product_thumbnail = $save_url;
            }
            if ($request->menu_facture_image) {
                $image = $request->menu_facture_image;
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

            $product->save();
        }

        /* ========= Start Multiple Image Upload ========= */
        $images = $request->file('multi_img');
        if ($images) {
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
        /* ========= End Multiple Image Upload ========= */



        $product->save();
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
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('product.all')->with($notification);
    }

    /*=================== Start EditProduct Methoed ===================*/
    public function EditProduct($id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('3', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            $product = Product::findOrFail($id);
            $multiImgs = MultiImg::where('product_id', $id)->get();
            // dd($multiImgs);
            $categories = Category::latest()->get();
            $brands = Brand::latest()->get();
            $vendors = Vendor::latest()->get();
            $suppliers = Supplier::latest()->get();
            $units = Unit::latest()->get();
            $attributes = Attribute::latest()->get();

            return view('backend.product.product_edit', compact('categories', 'vendors', 'suppliers', 'brands', 'attributes', 'product', 'multiImgs', 'units'));
        } else {
            $notification = array(
                'message' => 'Sorry! you cannot Access This page!',
                'alert-type' => 'Warning'
            );
            return redirect()->back()->with($notification);
        }
    } // end method

    // quantity information
    public function quantityInformation($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.product.update_quantity_info', compact('product'));
    }

    // barcode generate
    public function barcodeGenarate($id)
    {
        $product = Product::find($id);
        return view('backend.product.barcode_generate', compact('product'));
        // dd($product);
    }

    /*=================== Start DuplicateProduct Methoed ===================*/
    public function DuplicateProduct($id)
    {
        $product = Product::findOrFail($id);
        $multiImgs = MultiImg::where('product_id', $id)->get();
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $vendors = Vendor::latest()->get();
        $suppliers = Supplier::latest()->get();
        $units = Unit::latest()->get();
        $attributes = Attribute::latest()->get();

        return view('backend.product.product_duplicate', compact('categories', 'vendors', 'suppliers', 'brands', 'attributes', 'product', 'multiImgs', 'units'));
    } // end method

    /*=================== Start ProductUpdate Methoed ===================*/
    public function ProductUpdate(Request $request, $id)
    {
        //return $request;
        $product = Product::find($id);
        // return $request;
        $this->validate($request, [
            'name_en'           => 'required|max:150',
            'purchase_price'    => 'nullable|numeric',
            'wholesell_price'   => 'nullable|numeric',
            'discount_price'    => 'nullable|numeric',
            'regular_price'     => 'nullable|numeric',
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

        if ($request->vendor_id == null || $request->vendor_id == "") {
            $request->vendor_id = 0;
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

        if ($request->hasfile('product_thumbnail')) {
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

        if ($request->hasfile('menu_facture_image')) {
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
            'vendor_id'             => $request->vendor_id,
            'supplier_id'           => $request->supplier_id,
            'unit_id'               => $request->unit_id,
            'name_en'               => $request->name_en,
            'name_bn'               => $request->name_bn,
            'slug'                  => $slug,
            'url'                   => $request->url,
            'unit_weight'           => $request->unit_weight,
            'purchase_price'        => $request->purchase_price ?? 0,
            'purchase_code'         => $request->purchase_code ?? '',
            'whole_sell_dis_type'   => $request->wholesell_discount_type ?? 0,
            'whole_sell_dis'        => $request->wholesell_discount ?? 0,
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
            'created_by'            => Auth::guard('admin')->user()->id,
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
        // return redirect()->route('product.all');
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
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
        } else {
            $notification = array(
                'message' => 'Sorry! you cannot Access This page!',
                'alert-type' => 'Warning'
            );
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
    /*=================== Start approved Methoed ===================*/
    public function approved($id)
    {
        $product = Product::find($id);
        if ($product->approved == 1) {
            $product->approved = 0;
        } else {
            $product->approved = 1;
        }
        $product->save();
        $notification = array(
            'message' => 'Product approved Successfully.',
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('5', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            $products = Product::latest()->where('vendor_id', 0)->get();
            // dd($products);
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

            if ($request->hasfile('image')) {
                $image = $request->file('image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(300, 300)->save('upload/category/' . $name_gen);
                $save_url = 'upload/category/' . $name_gen;
            } else {
                $save_url = '';
            }

            $category->image = $save_url;
            $category->created_by = Auth::guard('admin')->user()->id;
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
        if (Auth::guard('admin')->user()->role == '1' || in_array('17', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            $products = Product::latest()->where('vendor_id', 0)->get();
            // dd($products);
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

            if ($request->hasfile('brand_image')) {
                $image = $request->file('brand_image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(300, 300)->save('upload/brand/' . $name_gen);
                $save_url = 'upload/brand/' . $name_gen;
            } else {
                $save_url = '';
            }

            $brand->brand_image = $save_url;
            $brand->created_by = Auth::guard('admin')->user()->id;

            $brand->save();
            $brands = Brand::all();

            return response()->json([
                'success' => 'Brand Inserted Successfully',
                'brands' => $brands,
            ]);
        }
    }

    public function menufacturingImage()
    {
        $products = Product::where('is_varient', '1')->with('productMenufacture')->latest()->get();
        $staffs = Staff::latest()->get();
        return view('backend.product.menufacturing', compact('products', 'staffs'));
    }

    public function saveQty($id, $qty)
    {
        // Find the product by its ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $manufacture = ProductMenufactureInfo::where('product_id', $product->id)->first();

        if ($manufacture) {
            $manufacture->menufacture_quantity = $qty;
            $manufacture->save();
        } else {
            $newManufacture = new ProductMenufactureInfo();
            $newManufacture->product_id = $product->id;
            $newManufacture->menufacture_quantity = $qty;
            $newManufacture->save();
        }

        return response()->json(['message' => 'Quantity saved successfully']);
    }


    public function menufacturingImageType($type)
    {
        $staffName = "<option value='0'>-- Assaign By --</option>";
        $staffs = Staff::select('staff.*', 'users.name')
            ->join('users', 'users.id', 'staff.user_id')
            ->where('staff.type', $type)
            ->get();

        foreach ($staffs as $staff) {
            $staffName .= '<option value=' . $staff->user_id . '>' . ucfirst($staff->name) . '</option>';
        }

        return response()->json($staffName);
    }

    public function saveStaff($staffId, $id)
    {
        $product = Product::find($id);
        $product->productMenufacture->user_id = $staffId;
        $product->productMenufacture->save();
        return response()->json(['message' => 'Staff saved successfully']);
    }

    public function menufacturingImageBarcode(Request $request)
    {
        $randomvalue = rand(1234567890, 5);
        $bodypart_code = null;
        $finishingpart_code = null;
        if ($request->type == 'Body-Parts') {
            $bodypart_code += $randomvalue;
            $finishingpart_code += null;
        } else if ($request->type == 'Finishing-Parts') {
            $finishingpart_code += $randomvalue;
            $bodypart_code += null;
        }
        $menufacture = ProductMenufactureInfo::where('product_id', $request->id)->with('product')->first();
        $menufacture->update([
            'body_part_varcode' => $bodypart_code,
            'finishing_part_varcode' => $finishingpart_code
        ]);
        return response()->json([
            'body_part' => $bodypart_code,
            'finishing_part' => $finishingpart_code,
            'data' => $menufacture
        ]);
    }

    public function menufacturingImagePrint($id)
    {
        $totalBodyPartPrice = null;
        $totalFinishingPrice = null;
        $productMenufacture = ProductMenufactureInfo::where('product_id', $id)->whereHas('product', function ($query) {
            $query->where('is_varient', '1');
        })->with('product')->first();
        if ($productMenufacture == null) {
            $notification = array(
                'message' => 'Please fill quantity',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
            // dd('product manufacture are null');
        } else {
            if ($productMenufacture->user_id == null || $productMenufacture->body_part_varcode == null || $productMenufacture->finishing_part_varcode == null) {
                $notification = array(
                    'message' => 'Please fill All field',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } else {
                $staff = Staff::where('user_id', $productMenufacture->user->id)->latest()->first();
                if ($staff->type == 'Body-Parts') {
                    $totalBodyPartPrice += $productMenufacture->product->body_rate * $productMenufacture->menufacture_quantity;
                } else if ($staff->type == 'Finishing-Parts') {
                    $totalFinishingPrice += $productMenufacture->product->finishing_rate * $productMenufacture->menufacture_quantity;
                }

                return view('backend.product.menufacturingprint', compact('productMenufacture', 'staff', 'totalBodyPartPrice', 'totalFinishingPrice'));
            }
        }
    }




    // product reviews
    public function productReviews()
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('21', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $productReviews = ProductReview::latest()->get();
            return view('backend.product.productReviews', compact('productReviews'));
        } else {
            $notification = array(
                'message' => 'Sorry, you Can not access the page',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }


    // product reviews published
    public function productReviewsPublished(Request $request, $id)
    {
        if (Auth::guard('admin')->user()->role == '1' || in_array('22', json_decode(Auth::guard('admin')->user()->staff->role->permissions))) {
            // dd($products);
            $productReview =  ProductReview::find($id);
            $productReview->update([
                'status' => $request->value
            ]);

            return response()->json([
                'message' => 'Review Status Change Successfully!',
                'data' => $productReview
            ]);
        } else {
            $notification = array(
                'message' => 'Sorry, you Can not access the page',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }



    public function productReviewsDelete($id)
    {
        $productReview = ProductReview::find($id);
        $productReview->delete();
        $notification = array(
            'message' => 'Review Deleted Succesfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
