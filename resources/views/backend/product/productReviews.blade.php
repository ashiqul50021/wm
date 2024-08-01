@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Product Reviews <span class="badge rounded-pill alert-success">
                    {{ count($productReviews) }} </span></h2>

        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Name (English)</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Comment </th>
                                <th scope="col">Rating </th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productReviews as $key => $review)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td width="15%">
                                        <a href="#" class="itemside">
                                            <div class="left">
                                                {{-- @dd($review->product->product_thumbnail) --}}
                                                @if ($review->product->product_thumbnail ?? '')
                                                    <img src="{{ asset($review->product->product_thumbnail ) }}"
                                                        class="img-sm" alt="Userpic" style="width: 80px; height: 70px;">
                                                @else
                                                    <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                        alt="Userpic" style="width: 80px; height: 70px;" />
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td> {{ $review->product->name_en ?? 'NULL' }} </td>
                                    <td> {{ $review->user_name ?? 'NULL' }} </td>
                                    <td> {{ $review->comment ?? 'NULL' }} </td>
                                    <td>
                                        @if ($review->start_rating == '1')
                                            <div class="d-flex">
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                            </div>
                                        @elseif ($review->start_rating == '2')
                                            <div class="d-flex">
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                            </div>
                                        @elseif ($review->start_rating == '3')
                                            <div class="d-flex">
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                            </div>
                                        @elseif ($review->start_rating == '4')
                                            <div class="d-flex">
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                            </div>
                                        @elseif ($review->start_rating == '5')
                                            <div class="d-flex">
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                                <p style="color: orange"><i class="fas fa-star"></i></p>
                                            </div>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input flexSwitchCheckDefault" type="checkbox" data-id={{ $review->id }}
                                               @if ($review->status ==1)
                                                checked
                                                @endif>
                                            <label class="form-check-label"
                                                for="flexSwitchCheckDefault">Published</label>
                                        </div>
                                    </td>


                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                            <div class="dropdown-menu">

                                                <!-- <a class="dropdown-item" href="">View Details</a> -->
                                                @if (Auth::guard('admin')->user()->role == '2')
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('product.productReviewsDelete', $review->id) }}"
                                                        id="delete">Delete</a>
                                                @else
                                                    @if (Auth::guard('admin')->user()->role == '1' ||
                                                            in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('product.productReviewsDelete', $review->id) }}"
                                                            id="delete">Delete</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <!-- dropdown //end -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.flexSwitchCheckDefault').change(function() {
                var id = $(this).attr('data-id');
                console.log(id)
                var url = "{{ route('product.productReviewsPublished', '') }}" + "/" + id;
                var value = 0;
                console.log(id)
                console.log(url)
                if (this.checked) {
                    value = 1;
                    console.log("Checkbox checked", value);
                } else {
                    value = 0;
                    console.log("Checkbox unchecked", value);
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        value: value,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        // Handle the response here
                        console.log(response)
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                    }
                });



            })
        })
    </script>
@endpush
