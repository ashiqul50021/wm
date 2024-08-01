<div class="col-lg-1-5 col-md-4  col-sm-6 col-6" style=" flex-wrap: wrap; margin-bottom: 20px">
    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ route('product.details', $product->slug) }}">
                    @if ($product->product_thumbnail && $product->product_thumbnail != '' && $product->product_thumbnail != '')
                        <img class="default-img lazyload img-responsive"
                            data-original="{{ asset($product->product_thumbnail) }}"
                            src="{{ asset($product->product_thumbnail ?? 'upload/product-default.jpg') }}" alt="">
                        <img class="hover-img" data-original="{{ asset($product->product_thumbnail) }}"
                            alt="" src="{{ asset($product->product_thumbnail) }}" />
                    @else
                        <img class="img-lg mb-3" data-original="{{ asset('upload/no_image.jpg') }}" alt="" />
                    @endif
                </a>
            </div>
            <div class="product-action-1 d-flex">
                <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                <a aria-label="Quick view" id="{{ $product->id }}" onclick="productView(this.id)" class="action-btn"
                    data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
            </div>
            <!-- start product discount section -->
            @php
                if ($product->discount_type == 1) {
                    $price_after_discount = $product->regular_price - $product->discount_price;
                } elseif ($product->discount_type == 2) {
                    $price_after_discount = $product->regular_price - ($product->regular_price * $product->discount_price) / 100;
                }
            @endphp

            @if ($product->discount_price > 0)
                <div class="product-badges-right product-badges-position-right product-badges-mrg">
                    @if ($product->discount_type == 1)
                        <span class="hot">৳{{ $product->discount_price }} off</span>
                    @elseif($product->discount_type == 2)
                        <span class="hot">{{ $product->discount_price }}% off</span>
                    @endif
                </div>
            @endif

            <!-- <div class="product-badges product-badges-position product-badges-mrg">
           <span class="hot">New</span>
       </div> -->

        </div>
        <div class="product-content-wrap">
            <h2 class="mt-3" style="height: 40px;">
                <a href="{{ route('product.details', $product->slug) }}">
                    @if (session()->get('language') == 'bangla')
                        <?php $p_name_bn = strip_tags(html_entity_decode($product->name_bn)); ?>
                        {{ Str::limit($p_name_bn, $limit = 30, $end = '. . .') }}
                    @else
                        <?php $p_name_en = strip_tags(html_entity_decode($product->name_en)); ?>
                        {{ Str::limit($p_name_en, $limit = 30, $end = '. . .') }}
                    @endif
                </a>
            </h2>
            {{-- <small>Model: <span>{{$product->model_number}}</span></small> --}}
            <div class="product-category">

                <a href="{{ route('product.category', $product->category->slug) }}">
                    @if (session()->get('language') == 'bangla')
                        {{ $product->category->name_bn }}
                    @else
                        {{ $product->category->name_en }}
                    @endif
                </a>
            </div>
            <div class="product-rate-cover">
                @if ($product->productReview)
                    @php
                        $productReviewAverage = \App\Models\ProductReview::where('status', 1)
                            ->where('product_id', $product->id)
                            ->average('start_rating');
                        $productReviewCount = \App\Models\ProductReview::where('status', 1)
                            ->where('product_id', $product->id)
                            ->count();
                    @endphp



                    @if ($productReviewAverage > 0 && $productReviewAverage < 2)
                        <div class="d-flex">
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p> ({{ $productReviewCount }})</p>
                        </div>
                    @elseif ($productReviewAverage >= 2 && $productReviewAverage < 3)
                        <div class="d-flex">
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p> ({{ $productReviewCount }})</p>
                        </div>
                    @elseif ($productReviewAverage >= 3 && $productReviewAverage < 4)
                        <div class="d-flex">
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p> ({{ $productReviewCount }})</p>
                        </div>
                    @elseif ($productReviewAverage >= 4 && $productReviewAverage < 5)
                        <div class="d-flex">
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p><i class="fas fa-star"></i></p>
                            <p> ({{ $productReviewCount }})</p>
                        </div>
                    @elseif ($productReviewAverage == 5)
                        <div class="d-flex">
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p style="color: orange"><i class="fas fa-star"></i></p>
                            <p> ({{ $productReviewCount }})</p>
                        </div>
                    @endif
                @else
                    <div class="d-flex">
                        <p><i class="fas fa-star"></i></p>
                        <p><i class="fas fa-star"></i></p>
                        <p><i class="fas fa-star"></i></p>
                        <p><i class="fas fa-star"></i></p>
                        <p><i class="fas fa-star"></i></p>
                        <p>(0)</p>
                    </div>
                @endif

            </div>
            <!-- <div>
           <span class="font-small text-muted">By <a href="#">NestFood</a></span>
       </div> -->
            <div class="product-card-bottom">
                @if ($product->discount_price > 0)
                    <div class="product-price">
                        <span class="price">৳{{ $price_after_discount ?? ''}}</span>
                        <span class="old-price">৳{{ $product->regular_price }}</span>
                    </div>
                @else
                    <div class="product-price">
                        <span class="price">৳{{ $product->regular_price }}</span>
                    </div>
                @endif


                <div class="add-cart">
                    <input type="hidden" id="{{ $product->id }}-product_pname" value="{{ $product->name_en }}">
                    <a class="add" onclick="addToCartDirect({{ $product->id }})"><i
                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                </div>
            </div>
        </div>
    </div>



</div>