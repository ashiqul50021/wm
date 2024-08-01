<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\SellerProductApiResource;
use App\Http\Resources\Seller\SellerProductResource;
use App\Models\AccountLedger;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\ProductStock;
use Carbon\Carbon;
use Exception;
use Image;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SellerProductApiController extends Controller
{
    public function ProductView()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            $products = Product::where('seller_id', $user->id)->latest()->get();

            if ($products->isEmpty()) {
                return response()->json(['message' => 'No products found for the user']);
            }

            $multiImages = [];
            foreach ($products as $product) {
                $multiImage = MultiImg::where('product_id', $product->id)->get(['photo_name']);
                // dd($multiImage);
                $multiImages[$product->id] = $multiImage;
            }

            return response()->json([
                'message' => 'View All Products',
                'data' => SellerProductResource::collection($products, $multiImages),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function singleProductView($id)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $product = Product::where('seller_id', $user->id)->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product not found or unauthorized'], 404);
            }

            $multiImages = MultiImg::where('product_id', $product->id)->pluck('photo_name')->toArray();

            return response()->json([
                new SellerProductResource($product, $multiImages),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error processing request'], 500);
        }
    }

    public function StoreProduct(Request $request)
    {
        $request->validate([

            'brand_id' => 'required',
            'category_id' => 'required',
            // 'supplier_id' => 'required',
            // 'model_number' => 'required',
            'unit_id' => 'required',
            'name_en' => 'required',
            'name_bn' => 'nullable',
            'unit_weight' => 'required',
            'url' => 'nullable',
            // 'purchase_price' => 'required',
            // 'purchase_code' => 'required',
            'wholesell_price' => 'required',
            'wholesell_minimum_qty' => 'required',
            'regular_price' => 'required',
            'discount_price' => 'required',
            // 'discount_type' => 'required',
            'minimum_buy_qty' => 'required',
            'stock_qty' => 'required',
            'description_en' => 'required',
            'description_bn' => 'required',
            'is_featured' => 'required',
            'is_deals' => 'required',
            'is_digital' => 'required',
            // 'is_dealer' => 'required',
            'status' => 'required',
            'product_thumbnail' => 'required',
        ]);

        if (!$request->name_bn) {
            $request->name_bn = $request->name_en;
        }

        if (!$request->description_bn) {
            $request->description_bn = $request->description_en;
        }


        if ($request->supplier_id == null || $request->supplier_id == "") {
            $request->supplier_id = 0;
        }

        if ($request->unit_id == null || $request->unit_id == "") {
            $request->unit_id = 0;
        }

        if ($request->hasfile('product_thumbnail')) {
            $image = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
            $save_url = 'upload/products/thumbnails/' . $name_gen;
        } else {
            $save_url = '';
        }

        // if ($request->is_variant == 1) {

        //     if ($request->has('vpurchesprices')) {
        //         $i = 0;
        //         foreach ($request->vpurchesprices as $key => $purchasePrice) {

        //             $product_name = $request->name_en;
        //             $variant_name = $request->vnames[$i];
        //             $combinedName = $variant_name . ' ' . $product_name;
        //             // dd($combinedName);
        //             $product = Product::create([
        //                 'brand_id'              => $request->brand_id,
        //                 'category_id'           => $request->category_id,
        //                 'seller_id'             => Auth::user()->id,
        //                 'supplier_id'           => $request->supplier_id,
        //                 'unit_id'               => $request->unit_id,
        //                 'name_en'               => $combinedName,
        //                 'name_bn'               => $request->name_bn,
        //                 'variant_name'          => $request->vnames[$i],
        //                 'url'                   => $request->url,
        //                 'slug'                  => Str::slug($request->name_en) . '-' . Str::random(6),
        //                 'unit_weight'           => $request->unit_weight,
        //                 'purchase_price'        => $purchasePrice,
        //                 'purchase_code'        => $request->vpurchescodes[$i] ?? 0,
        //                 'wholesell_price'       => $request->vwholesaleprices[$i] ?? 0,
        //                 'wholesell_minimum_qty' => $request->vwholesaleqtys[$i] ?? 0,
        //                 'regular_price'         => $request->vprices[$i] ?? 0,
        //                 'discount_price'        => $request->vdis_prices[$i] ?? 0,
        //                 'product_code'          => rand(10000, 99999),
        //                 'description_en'        => $request->description_en,
        //                 'description_bn'        => $request->description_bn,
        //                 'is_featured'           => $request->is_featured ? 1 : 0,
        //                 'is_deals'              => $request->is_deals ? 1 : 0,
        //                 'is_digital'            => $request->is_digital ? 1 : 0,
        //                 'is_dealer'             => $request->is_dealer ? 1 : 0,
        //                 'status'                => $request->status ? 1 : 0,
        //                 'discount_type'         => $request->vdis_types[$i] ?? 0,
        //                 'is_varient'            => $request->is_variant,
        //                 'stock_qty'             => $request->vqtys[$i] ?? 0,
        //                 'body_rate'             => $request->vbodyrates[$i],
        //                 'finishing_rate'        => $request->vfinishingrates[$i],
        //                 'discount_type'         => $request->vdis_type[$i] ?? 0,
        //                 'model_number'          => $request->vskus[$i] ?? 0,
        //                 'approved'              => 1,
        //                 'created_by'            => Auth::user()->id,

        //             ]);



        //             if ($request->vimages) {
        //                 $image = $request->vimages[$i];
        //                 if ($image) {
        //                     $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        //                     Image::make($image)->resize(438, 438)->save('upload/products/thumbnails/' . $name_gen);
        //                     $save_url = 'upload/products/thumbnails/' . $name_gen;
        //                 } else {
        //                     $save_url = '';
        //                 }
        //                 $product->product_thumbnail = $save_url;
        //             }
        //             if ($request->vmanufimages) {
        //                 $image = $request->vmanufimages[$i];
        //                 if ($image) {
        //                     $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        //                     Image::make($image)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gen);
        //                     $save_url_menufacture = 'upload/products/menufacturingimages/' . $name_gen;
        //                 } else {
        //                     $save_url_menufacture = '';
        //                 }
        //                 $product->menu_facture_image = $save_url_menufacture;
        //             }

        //             /* =========== Start Product Tags =========== */
        //             $product->tags = implode(',', $request->tags);
        //             /* =========== End Product Tags =========== */


        //             /* ========= Product Attributes Start ========= */
        //             $attribute_values = array();
        //             if ($request->has('choice_attributes')) {
        //                 foreach ($request->choice_attributes as $key => $attribute) {
        //                     $atr = 'choice_options' . $attribute;
        //                     $item['attribute_id'] = $attribute;
        //                     $data = array();
        //                     foreach ($request[$atr] as $key => $value) {
        //                         array_push($data, $value);
        //                     }
        //                     $item['values'] = $data;
        //                     array_push($attribute_values, $item);
        //                 }
        //             }

        //             if (!empty($request->choice_attributes)) {
        //                 $product->attributes = json_encode($request->choice_attributes);
        //             } else {
        //                 $product->attributes = json_encode(array());
        //             }
        //             $attr_values = collect($attribute_values);
        //             $attr_values_sorted = $attr_values->sortByDesc('attribute_id');

        //             $sorted_array = array();
        //             foreach ($attr_values_sorted as $attr) {
        //                 array_push($sorted_array, $attr);
        //             }

        //             $product->attribute_values = json_encode($sorted_array, JSON_UNESCAPED_UNICODE);
        //             /* ========= End Product Attributes ========= */
        //             $product->save();

        //             $i++;
        //         }
        //     }
        // } else {
        if ($request->slug != null) {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        } else {
            $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name_en)) . '-' . Str::random(5);
        }

        $product = Product::create([
            'brand_id'              => $request->brand_id,
            'category_id'           => $request->category_id,
            'seller_id'             =>  Auth::user()->id,
            'supplier_id'           => $request->supplier_id ?? 0,
            'model_number'          => $request->model_number ?? 0,
            'unit_id'               => $request->unit_id,
            'name_en'               => $request->name_en,
            'name_bn'               => $request->name_bn,
            'slug'                  => $slug,
            'unit_weight'           => $request->unit_weight,
            'url'                   => $request->url,
            'purchase_price'        => $request->purchase_price ?? 0,
            'purchase_code'         => $request->purchase_code ?? 0,
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
            'created_by'            => Auth::user()->id,
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
        // }




        $images = $request->file('multi_img');
        if ($images) {
            foreach ($images as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                Image::make($img)->resize(917, 1000)->save('upload/products/multi-image/' . $make_name);
                $uploadPath = 'upload/products/multi-image/' . $make_name;

                $multiImage = MultiImg::create([
                    'product_id' => $product->id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now(),
                ]);

                // Track the latest multi-image for the response
                $multiImages = $multiImage;
            }
        }

        /* ========= End Multiple Image Upload ========= */

        $product->save();
        $ledger_balance = get_vendor_account_balance(Auth::user()->id) - $product->purchase_price * $product->stock_qty;

        $ledger = AccountLedger::create([
            'account_head_id' => 1,
            'seller_id' => Auth::user()->id,
            'particulars' => "Purchase Product",
            'debit' => $product->purchase_price * $product->stock_qty,
            'balance' => $ledger_balance,
            'product_id' => $product->id,
            'type' => 1,
        ]);

        $recentMultiImages = MultiImg::where('product_id', $product->id)->latest()->pluck('photo_name')->toArray();

        return response()->json([
            'message' => 'Product Inserted Successfully',
            'inserted product' => new SellerProductResource($product, $recentMultiImages),
        ], 200);
    } // end method


    public function ProductUpdate(Request $request, $id)
    {
        $user = Auth::user()->id;
        $product = Product::findOrFail($id);

        if ($product->seller_id != $user) {
            return response()->json([
                'message' => 'You are not able to Edit this product',
            ], 403);
        }


        // return $request;
        $this->validate($request, [
            'name_en'           => 'required|max:150',
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
            'seller_id'             => Auth::user()->id,
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
            'created_by'            => Auth::user()->id,
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

        // if ($request->is_variation_changed) {
        //     /* ========= Product Attributes Start ========= */
        //     $attribute_values = array();
        //     if ($request->has('choice_attributes')) {
        //         foreach ($request->choice_attributes as $key => $attribute) {
        //             $atr = 'choice_options' . $attribute;
        //             $item['attribute_id'] = $attribute;
        //             $data = array();

        //             foreach ($request[$atr] as $key => $value) {
        //                 array_push($data, $value);
        //             }

        //             $item['values'] = $data;
        //             array_push($attribute_values, $item);
        //         }
        //     }

        //     if (!empty($request->choice_attributes)) {
        //         $product->attributes = json_encode($request->choice_attributes);
        //         $product->is_varient = 1;

        //         if ($request->has('vnames')) {
        //             $i = 0;
        //             foreach ($request->vnames as $key => $name) {
        //                 $stock = ProductStock::create([
        //                     'product_id'        => $product->id,
        //                     'varient'           => $name,
        //                     'sku'               => $request->vskus[$i],
        //                     'price'             => $request->vprices[$i],
        //                     'bodyrate'          => $request->vbodyrates[$i],
        //                     'finishingrate'     => $request->vfinishingrates[$i],
        //                     'purchesprice'      => $request->purchesprices[$i],
        //                     'wholesaleprice'    => $request->vwholesaleprices[$i],
        //                     'wholesaleqty'      => $request->vwholesaleqtys[$i],
        //                     'qty'               => $request->vqtys[$i],
        //                     'dis_price'         => $request->vdis_prices[$i],
        //                     // 'dis_type'          => $request->vdis_types[$i],
        //                 ]);
        //                 if ($request->vimages) {
        //                     $image = $request->vimages[$i];
        //                     if ($image) {
        //                         $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        //                         Image::make($image)->resize(438, 438)->save('upload/products/variations/' . $name_gen);
        //                         $save_url = 'upload/products/variations/' . $name_gen;
        //                     } else {
        //                         $save_url = '';
        //                     }
        //                     $stock->image = $save_url;
        //                 }
        //                 if ($request->vmanufimages) {
        //                     $vmanufimage = $request->vmanufimages[$i];
        //                     if ($vmanufimage) {
        //                         $name_gen_v = hexdec(uniqid()) . '.' . $vmanufimage->getClientOriginalExtension();
        //                         Image::make($image)->resize(438, 438)->save('upload/products/menufacturingimages/' . $name_gen_v);
        //                         $save_url_v = 'upload/products/menufacturingimages/' . $name_gen_v;
        //                     } else {
        //                         $save_url_v = '';
        //                     }
        //                     $stock->vmanufimage = $save_url_v;
        //                 }
        //                 $stock->save();
        //                 $i++;
        //             }
        //         }
        //     } else {
        //         $product->attributes = json_encode(array());
        //         $product->is_varient = 0;
        //     }

        //     $attr_values = collect($attribute_values);
        //     $attr_values_sorted = $attr_values->sortByDesc('attribute_id');

        //     $sorted_array = array();
        //     foreach ($attr_values_sorted as $attr) {
        //         array_push($sorted_array, $attr);
        //     }

        //     $product->attribute_values = json_encode($sorted_array, JSON_UNESCAPED_UNICODE);
        //     /* ========= End Product Attributes ========= */
        // }


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


        return response()->json([
            'message' => 'Product Successfully Updated',

        ]);
    } // end method


    public function ProductDelete($id)
    {
        $user = Auth::user()->id;
        $product = Product::findOrFail($id);

        if ($product->seller_id != $user || demo_mode()) {
            return response()->json([
                'message' => 'You are not able to Delete this product',
            ], 403);
        }

        try {
            if (file_exists($product->product_thumbnail)) {
                unlink($product->product_thumbnail);
            }

            $product->delete();

            $images = MultiImg::where('product_id', $id)->get();

            foreach ($images as $img) {
                if (file_exists($img->photo_name)) {
                    unlink($img->photo_name);
                }
            }

            // Delete all images in a single query
            MultiImg::where('product_id', $id)->delete();

            return response()->json([
                'message' => 'Product Deleted Successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting product'
            ], 500);
        }
    }

    public function active($id)
    {
        $user = Auth::user()->id;
        // dd($user);
        $product = Product::findOrFail($id);
        // dd($product);

        if ($product->seller_id != $user) {
            return response()->json([
                'message' => 'You are not able to Active this product',
            ], 403);
        }
        $product->status = 1;
        $product->save();

        return response()->json([
            'message' => 'Product Successfully Activated',
        ], 200);
    } // end method

    public function inactive($id)
    {
        $user = Auth::user()->id;
        $product = Product::findOrFail($id);

        if ($product->seller_id != $user) {
            return response()->json([
                'message' => 'You are not able to Inactive this product',
            ], 403);
        }
        $product->status = 0;
        $product->save();

        return response()->json([
            'message' => 'Product Successfully InActivated',
        ], 200);
    } // end method


    public function productStock(Request $request)
    {
        $user = Auth::user()->id;
        $products = Product::where('status', 1)
            ->where('approved', 1)
            ->where('seller_id', $user)
            ->orderBy('created_at', 'desc')->get();
        if (!$products) {
            return response()->json([
                'message' => 'No Access',
            ], 404);
        }

        return response()->json([
            'product_stock' => SellerProductApiResource::collection($products),
        ], 200);
    }
}
