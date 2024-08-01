@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Dealers Create</h2>
            <div class="">
                <a href="{{ route('dealer.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Dealer
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('dealer.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="col-form-label col-md-4" style="font-weight: bold;"> Name :
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" type="text" name="name"
                                        placeholder="Write Dealer name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="shop_name" class="col-form-label col-md-4" style="font-weight: bold;">Shop
                                        Name:</label>
                                    <input class="form-control" id="shop_name" type="text" name="shop_name"
                                        placeholder="Write Dealer shop name" value="{{ old('shop_name') }}">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="col-form-label col-md-4" style="font-weight: bold;"> Phone
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="phone" type="text" name="phone"
                                        placeholder="Write Dealer phone number" value="{{ old('phone') }}">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="col-form-label col-md-4" style="font-weight: bold;"> Email
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" type="email" name="email"
                                        placeholder="Write Dealer email address" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="address" class="col-form-label col-md-4" style="font-weight: bold;">Address
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        placeholder="Write Dealer address" value="{{ old('address') }}">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-6 mb-4">
								<label for="bank_name" class="col-form-label col-md-4" style="font-weight: bold;">Bank Name :</label>
								<input class="form-control" id="bank_name" type="text" name="bank_name" placeholder="Write Dealer bank name" value="{{old('bank_name')}}">
							</div>
							<div class="col-md-6 mb-4">
								<label for="bank_account" class="col-form-label col-md-4" style="font-weight: bold;">Bank Account No: </label>
								<input class="form-control" id="bank_account" type="text" name="bank_account" placeholder="Write Dealer bank name" value="{{old('bank_account')}}">
							</div> --}}

                                <div class="col-md-6 mb-4">
                                    <label for="description" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Description :</label>
                                    <textarea name="description" id="description" cols="5" placeholder="Write Dealer description"
                                        class="form-control ">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                            alt="Card image cap" width="100px" height="80px;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="image" class="col-form-label" style="font-weight: bold;">Profile:
                                            <span class="text-danger">*</span></label>
                                        <input name="profile_image" class="form-control" type="file" id="image">
                                        @error('profile_image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <img id="showImage5" class="rounded avatar-lg"
                                            src="{{ !empty($editData->shop_image) ? url('upload/admin_images/' . $editData->shop_image) : url('upload/no_image.jpg') }}"
                                            alt="Card image cap" width="100px" height="80px;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="image5" class="col-form-label" style="font-weight: bold;">Shop
                                            Image:</label>
                                        <input name="shop_image" class="form-control" type="file" id="image5">
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <img id="showImage3" class="rounded avatar-lg"
                                            src="{{ !empty($editData->nid) ? url('upload/admin_images/' . $editData->nid) : url('upload/no_image.jpg') }}"
                                            alt="Card image cap" width="100px" height="80px;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="image3" class="col-form-label" style="font-weight: bold;">Nid
                                            Card:</label>
                                        <input name="nid" class="form-control" type="file" id="image3">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <img id="showImage4" class="rounded avatar-lg"
                                            src="{{ !empty($editData->trade_license) ? url('upload/admin_images/' . $editData->trade_license) : url('upload/no_image.jpg') }}"
                                            alt="Card image cap" width="100px" height="80px;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="image4" class="col-form-label" style="font-weight: bold;">Trade
                                            license:</label>
                                        <input name="trade_license" class="form-control" type="file" id="image4">
                                    </div>

                                </div>

                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6">
                                    <label for="password" class="col-form-label col-md-4" style="font-weight: bold;">
                                        Password : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="password" type="password" name="password"
                                        placeholder="Write vendor Password">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label col-md-4" style="font-weight: bold;"
                                        for="rtpassword">Confirm Password: <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Confirm Password" type="password"
                                        name="password_confirmation" id="rtpassword" />
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="shop_name" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Google Map Url:</label>
                                    <input class="form-control" id="google_map_url" type="url" name="google_map_url"
                                        placeholder="Write Google Map Url" value="{{ old('google_map_url') }}">
                                </div>
                            </div>
                            <!-- form-group// -->

                            <div class="mb-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="form-check-input me-2 cursor" name="status"
                                        id="status" checked value="1">
                                    <label class="form-check-label cursor" for="status">Status</label>
                                </div>
                            </div>

                            <div class="row mb-4 justify-content-sm-end">
                                <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- card body .// -->
                </div>
                <!-- card .// -->
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    <!-- Shop Cover Photo Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image2').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage2').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Nid Card Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image3').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage3').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Trade license Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image4').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage4').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Shop Image Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image5').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage5').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
