@extends('dealer.dealer_master')
@section('dealer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Show Product</h2>
            <div class="">
                <a href="{{ route('dealer.product.all') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Product
                    List</a>
            </div>
        </div>
        <div class="row">
            {{-- @if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif --}}
            <div class="col-md-12 mx-auto">
                <form method="post" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h3>Basic Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="product_name_en" class="col-form-label" style="font-weight: bold;">Product
                                        Name (En):</label>
                                    <input class="form-control" readonly id="product_name_en" type="text" name="name_en"
                                        placeholder="Write product name english" value="{{ $product->name_en }}">
                                    @error('product_name_en')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="product_name_bn" class="col-form-label" style="font-weight: bold;">Product
                                        Name (Bn):</label>
                                    <input class="form-control" readonly id="product_name_bn" type="text" name="name_bn"
                                        placeholder="Write product name bangla" value="{{ $product->name_bn }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4 d-none">
                                    <label for="product_code" class="col-form-label" style="font-weight: bold;">Product
                                        Code:</label>
                                    <input class="form-control" readonly id="product_code" type="text" name="product_code"
                                        placeholder="Write product code" value="{{ $product->product_code }}">
                                </div>
                                {{-- <div class="col-md-6 mb-4">
	                          <label for="category_id" class="col-form-label" style="font-weight: bold;">Category:</label>
				                <div class="custom_select">
                                    <select class="form-control select-active w-100 form-select select-nice" name="category_id" id="product_category" data-selected="{{ $product->category_id }}">
                                    	@foreach ($categories as $category)
	                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
		                                    @foreach ($category->childrenCategories as $childCategory)
		                                    	@include('backend.include.child_category', ['child_category' => $childCategory])
		                                    @endforeach
	                                    @endforeach
                                    </select>
                                </div>
	                        </div> --}}
                                <div class="col-md-6 mb-4">
                                    <label for="product_category" class="col-form-label"
                                        style="font-weight: bold;">Category:</label>
                                    <a style="background-color: #3BB77E; "class="btn btn-sm float-end"
                                        data-bs-toggle="modal" data-bs-target="#category"><i
                                            class="fa-solid fa-plus text-white"></i></a>
                                    @php
                                        $selectedCategory = $product->category_id;
                                    @endphp
                                    <div class="custom_select">
                                        <select disabled class="form-control select-active w-100 form-select select-nice"
                                            name="category_id" id="product_category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($category->id == $selectedCategory) selected @endif>
                                                    {{ $category->name_en }}</option>
                                                @foreach ($category->childrenCategories as $childCategory)
                                                    {{-- @include('backend.include.child_category', [
                                                        'child_category' => $childCategory,
                                                    ]) --}}
                                                    {{ $childCategory->name ?? '' }}
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 mb-4">
	                           <label for="brand_id" class="col-form-label" style="font-weight: bold;">Brand:</label>
				                <div class="custom_select">
                                    <select class="form-control select-active w-100 form-select select-nice" name="brand_id" id="product_brand" required>
                                    	<option value="">--Select Brand--</option>
		                                @foreach ($brands as $brand)
		                                    <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name_en ?? 'Null' }}</option>
		                                @endforeach
                                    </select>
                                </div>
	                        </div> --}}
                                <div class="col-md-6 mb-4">
                                    <a style="background-color: #3BB77E; " type="button" class="btn btn-sm float-end"
                                        id="closeModal1" data-bs-toggle="modal" data-bs-target="#brand"><i
                                            class="fa-solid fa-plus text-white"></i></a>
                                    <label for="brand_id" class="col-form-label" style="font-weight: bold;">Brand:</label>
                                    <div class="custom_select">
                                        <select disabled class="form-control select-active w-100 form-select select-nice"
                                            name="brand_id" id="brand_id">
                                            <option value="">--Select Brand--</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                    {{ $brand->name_en }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                @if (get_setting('multi_vendor')->value)


                                        <div class="col-md-6 mb-4">
                                            <label for="vendor_id" class="col-form-label"
                                                style="font-weight: bold;">Vendor:</label>
                                            <div class="custom_select">
                                                <select disabled class="form-control select-active w-100 form-select select-nice"
                                                    name="vendor_id" id="vendor_id">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ $vendor->id == $product->vendor_id ? 'selected' : '' }}>
                                                            {{ $vendor->shop_name ?? 'Null' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                @endif

                                <div class="col-md-6 mb-4">
                                    <label for="supplier_id" class="col-form-label"
                                        style="font-weight: bold;">Supplier:</label>
                                    <div class="custom_select">
                                        <select disabled class="form-control select-active w-100 form-select select-nice"
                                            name="supplier_id" id="supplier_id">
                                            <option value="">--Select Supplier--</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    @if ($product->supplier_id == $supplier->id) selected @endif>
                                                    {{ $supplier->name ?? 'Null' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="unit_id" class="col-form-label" style="font-weight: bold;">Unit
                                        Type:</label>
                                    <div class="custom_select">
                                        <select disabled class="form-control select-active w-100 form-select select-nice"
                                            name="unit_id" id="unit_id">
                                            <option disabled hidden {{ old('unit_id') ? '' : 'selected' }} readonly
                                                value="">--Select Unit Type--</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}"
                                                    @if ($product->unit_id == $unit->id) selected @endif>{{ $unit->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="unit_weight" class="col-form-label" style="font-weight: bold;">Unit
                                        Weight (e.g. 10 mg, 1 Carton, 15 Pcs)</label>
                                    <input class="form-control" readonly id="unit_weight" type="number" name="unit_weight"
                                        placeholder="Write unit weight" value="{{ $product->unit_weight }}">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="url" class="col-form-label" style="font-weight: bold;">Product Video Url</label>
                                    <input class="form-control" readonly id="url" type="text" name="url"
                                        placeholder="Write Video Url" value="{{ $product->url }}">
                                </div>
                                {{-- <div class="col-md-6 mb-4">
	                         	<label for="campaing_id" class="col-form-label" style="font-weight: bold;">Campaing:</label>
				                <div class="custom_select">
                                    <select class="form-control select-active w-100 form-select select-nice" name="campaing_id" id="campaing_id">
                                    	<option selected="">Select Campaing</option>
                                    </select>
                                </div>
	                        </div> --}}
                                <div class="col-md-6 mb-4">
                                    <label for="product_name_en" class="col-form-label"
                                        style="font-weight: bold;">Tags:</label>
                                    <input class="form-control tags-input" readonly type="text"name="tags[]"
                                        value="{{ $product->tags }}" placeholder="Type and hit enter to add a tag">
                                    <small class="text-muted d-block">This is used for search. </small>
                                </div>
                            </div>
                            <!-- row //-->
                        </div>
                        <!-- card body .// -->
                    </div>
                    <!-- card .// -->


                    <!-- card //-->

                    <div class="card">
                        <div class="card-header" style="background-color: #fff !important;">
                            <h3 style="color: #4f5d77 !important">Pricing</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- @if ($product->is_varient == 0) --}}
                                <div class="row" id="single_price">
                                    <div class="col-md-12 mb-4">
                                        <label for="bying_price" class="col-form-label"
                                            style="font-weight: bold;">Product Buying Price:</label>
                                        <input class="form-control" readonly id="purchase_price" type="number"
                                            name="purchase_price" placeholder="Write product bying price"
                                            value="{{ $product->purchase_price }}">
                                        @error('purchase_price')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="model_number" class="col-form-label"
                                            style="font-weight: bold;">Model No: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" readonly id="model_number" type="text"
                                            name="model_number" placeholder="Write product model No."
                                            value="{{ old('model_number', $product->model_number ?? 0) }}">
                                        @error('model_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="wholesell_discount" class="col-form-label"
                                            style="font-weight: bold;">Whole Sell Discount:</label>
                                        <input class="form-control wholeSellDiscount" readonly id="wholesell_discount" type="number"
                                            name="wholesell_discount" placeholder="Write product whole sell price"
                                            value="{{ $product->whole_sell_dis ?? '' }}">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="whole_sell_dis_type" class="col-form-label"
                                            style="font-weight: bold;">Wholesell Discount Type:</label>
                                        <div class="custom_select">
                                            <select disabled class="form-control select-active w-100 form-select select-nice wholesellDiscountType"
                                                name="whole_sell_dis_type" id="whole_sell_dis_type">
                                                <option value="1" <?php if ($product->whole_sell_dis_type == '1') {
                                                    echo 'selected';
                                                } ?>>Flat</option>
                                                <option value="2" <?php if ($product->whole_sell_dis_type == '2') {
                                                    echo 'selected';
                                                } ?>>Parcent %</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="wholesell_price" class="col-form-label"
                                            style="font-weight: bold;">Whole Sell Price:</label>
                                        <input class="form-control vwholesaleprices" readonly id="wholesell_price" type="number"
                                            name="wholesell_price" placeholder="Write product whole sell price"
                                            value="{{ $product->wholesell_price }}">
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="wholesell_minimum_qty" class="col-form-label"
                                            style="font-weight: bold;">Whole Sell Minimum Quantity:</label>
                                        <input class="form-control" readonly id="wholesell_minimum_qty" type="number"
                                            name="wholesell_minimum_qty" placeholder="Write product whole sell qty"
                                            value="{{ $product->wholesell_minimum_qty }}">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="regular_price" class="col-form-label"
                                            style="font-weight: bold;">Regular Price:</label>
                                        <input readonly class="form-control regularPrice" id="regular_price" type="number"
                                            name="regular_price" placeholder="Write product regular price"
                                            value="{{ $product->regular_price }}" min="0">
                                        @error('regular_price')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="discount_price" class="col-form-label"
                                            style="font-weight: bold;">Discount Price:</label>
                                        <input class="form-control" readonly id="discount_price" type="number"
                                            name="discount_price" value="{{ $product->discount_price }}" min="0"
                                            placeholder="Write product discount price">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="discount_type" class="col-form-label"
                                            style="font-weight: bold;">Discount Type:</label>
                                        <div class="custom_select">
                                            <select disabled class="form-control select-active w-100 form-select select-nice"
                                                name="discount_type" id="discount_type">
                                                <option value="1" <?php if ($product->discount_type == '1') {
                                                    echo 'selected';
                                                } ?>>Flat</option>
                                                <option value="2" <?php if ($product->discount_type == '2') {
                                                    echo 'selected';
                                                } ?>>Parcent %</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="minimum_buy_qty" class="col-form-label"
                                            style="font-weight: bold;">Minimum Buy Quantity:</label>
                                        <input readonly class="form-control" id="minimum_buy_qty" type="number"
                                            name="minimum_buy_qty" placeholder="Write product qty"
                                            value="{{ $product->minimum_buy_qty }}" min="1">
                                        @error('minimum_buy_qty')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="stock_qty" class="col-form-label" style="font-weight: bold;">Stock
                                            Quantity:</label>
                                        <input readonly class="form-control" id="stock_qty" type="number" name="stock_qty"
                                            value="{{ $product->stock_qty }}" min="0"
                                            placeholder="Write product stock qty">
                                        @error('stock_qty')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @if ($product->is_varient)
                                    <div class="col-md-6 mb-4">
                                        <label for="body_rate" class="col-form-label" style="font-weight: bold;">Body Rate:</label>
                                        <input readonly class="form-control" id="body_rate" type="number" name="body_rate"
                                            value="{{ $product->body_rate }}" min="0"
                                            placeholder="Write Body Rate">
                                        @error('body_rate')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="finishing_rate" class="col-form-label" style="font-weight: bold;">Finishing Rate:</label>
                                        <input readonly class="form-control" id="finishing_rate" type="number" name="finishing_rate"
                                            value="{{ $product->finishing_rate }}" min="0"
                                            placeholder="Write Finishing">
                                        @error('finishing_rate')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="model_number" class="col-form-label" style="font-weight: bold;">Model No:</label>
                                        <input readonly class="form-control" id="model_number" type="text" name="model_number"
                                            value="{{ $product->model_number }}"
                                            placeholder="Write Model No">
                                        @error('model_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>

                            </div>
                            <!-- Row //-->
                        </div>
                    </div>
                    <!-- card //-->

                    <div class="card">
                        <div class="card-header" style="background-color: #fff !important;">
                            <h3 style="color: #4f5d77 !important">Description</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Description Start -->
                                <div class="col-md-6 mb-4">
                                    <label for="long_descp_en" class="col-form-label"
                                        style="font-weight: bold;">Description (En):</label>
                                    <textarea name="description_en" id="long_descp_en" rows="2" cols="2" class="form-control summernote"
                                        placeholder="Write Long Description English">{{ $product->description_en }}</textarea>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="long_descp_bn" class="col-form-label"
                                        style="font-weight: bold;">Description (Bn):</label>
                                    <textarea name="description_bn" id="long_descp_bn" rows="2" cols="2" class="form-control summernote"
                                        placeholder="Write Long Description Bangla">{{ $product->description_bn }}</textarea>
                                </div>
                                <!-- Description End -->
                            </div>
                        </div>
                    </div>
                    <!-- card //-->

                    <div class="card">
                        <div class="card-header" style="background-color: #fff !important;">
                            <h3 style="color: #4f5d77 !important">Product Image</h3>
                        </div>
                        <div class="card-body">
                            <!-- Porduct Image Start -->
                            <div class="mb-4">
                                <label for="product_thumbnail" class="col-form-label" style="font-weight: bold;">Product
                                    Image:</label>
                                <input disabled type="file" name="product_thumbnail" class="form-control"
                                    id="product_thumbnail" onChange="mainThamUrl(this)">
                                <img src="{{ asset($product->product_thumbnail) }}" width="100" height="100"
                                    class="p-2" id="mainThmb">
                            </div><br><br>

                            @if ($product->is_varient)
                            <div class="mb-4">
                                <label for="menu_facture_image" class="col-form-label" style="font-weight: bold;">Menufacture Image:</label>
                                <input disabled type="file" name="menu_facture_image" class="form-control"
                                    id="menu_facture_image" onChange="menuThamUrl(this)">
                                <img src="{{ asset($product->menu_facture_image) }}" width="100" height="100"
                                    class="p-2" id="menuThmb">
                            </div><br><br>

                            @endif
                            <div class="col-md-12 mb-3">
                                <div class="box-header mb-3 d-flex">
                                    <h4 class="box-title">Product Multiple Image <strong>Update:</strong></h4>
                                </div>
                                <div class="box bt-3 border-info">
                                    <div class="row row-sm">
                                        {{-- @dd($multiImgs); --}}
                                        @foreach ($multiImgs as $img)
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <img src="{{ asset($img->photo_name) }}"
                                                        class="showImage{{ $img->id }}"
                                                        style="height: 130px; width: 280px;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">

                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  end col md 3		 -->
                                        @endforeach
                                        <div class="mb-4">
                                            <div class="row  p-2" id="preview_img">

                                            </div>
                                            <label for="multiImg" class="col-form-label" style="font-weight: bold;">Add
                                                More:</label>
                                            <input disabled type="file" name="multi_img[]" class="form-control" multiple=""
                                                id="multiImg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Porduct Image End -->
                            <!-- Checkbox Start -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" class="form-check-input me-2 cursor" name="is_dealer"
                                            id="is_dealer" {{ $product->is_dealer == 1 ? 'checked' : '' }} value="1">
                                        <label class="form-check-label cursor" for="is_dealer">Show Dealer</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" class="form-check-input me-2 cursor" name="is_deals"
                                            id="is_deals" {{ $product->is_deals == 1 ? 'checked' : '' }} value="1">
                                        <label class="form-check-label cursor" for="is_deals">Today's Deal</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" class="form-check-input me-2 cursor" name="is_digital"
                                            id="is_digital" {{ $product->is_digital == 1 ? 'checked' : '' }}
                                            value="1">
                                        <label class="form-check-label cursor" for="is_digital">Digital</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" class="form-check-input me-2 cursor" name="is_featured"
                                            id="is_featured" {{ $product->is_featured == 1 ? 'checked' : '' }}
                                            value="1">
                                        <label class="form-check-label cursor" for="is_featured">Featured</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" class="form-check-input me-2 cursor" name="status"
                                            id="status" {{ $product->status == 1 ? 'checked' : '' }} value="1">
                                        <label class="form-check-label cursor" for="status">Status</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Checkbox End -->
                        </div>
                    </div>
                    <!-- card -->


                </form>
            </div>
            <!-- col-6 //-->
        </div>
    </section>
@endsection
