@extends('vendor.vendor_master')
@section('vendor')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Customer Add</h2>
            <div class="">
                <a href="{{ route('vendor.customer.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>
                    Customer List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="{{ route('vendor.customer.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="name" class="col-form-label" style="font-weight: bold;">
                                            Name:</label>
                                        <input class="form-control" id="name" type="text" name="name"
                                            placeholder="Write User Name" value="{{ old('name') }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone" class="col-form-label"
                                            style="font-weight: bold;">Phone:</label>
                                        <input class="form-control" id="phone" type="text" name="phone"
                                            placeholder="Write Phone Number" value="{{ old('phone') }}">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>



                                    <div class="mb-4">
                                        <label for="email" class="col-form-label"
                                            style="font-weight: bold;">Email:</label>
                                        <input class="form-control" id="email" type="email" name="email"
                                            placeholder="Write User Email" value="{{ old('email') }}">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>



                                    <div class="mb-4">
                                        <label for="address" class="col-form-label"
                                            style="font-weight: bold;">Address:</label>
                                        <input class="form-control" id="address" type="text" name="address"
                                            placeholder="Write User Address" value="{{ old('address') }}">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>





                                    <div class="mb-4">
                                        <img src="" class="p-2" id="mainThmb"><br>
                                        <label for="image" class="col-form-label" style="font-weight: bold;">Profile
                                            Photo:</label>
                                        <input name="profile_image" class="form-control" type="file" id="image"
                                            onChange="mainThamUrl(this)">
                                        @error('profile_image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="col-form-label"
                                            style="font-weight: bold;">Password:</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" id="password" type="password" name="password"
                                                placeholder="Write User Password" value="{{ old('password') }}">
                                            <i class="far fa-eye" id="togglePassword1"
                                                style="margin-left: -30px; cursor: pointer;"></i>
                                        </div>
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="confirm_password" class="col-form-label"
                                            style="font-weight: bold;">Confirm Password:</label>
                                        <div class="d-flex align-items-center">
                                            <input class="form-control" id="confirm_password" type="password"
                                                name="confirm_password" placeholder="Write User confirm Password"
                                                value="{{ old('confirm_password') }}">
                                            <i class="far fa-eye" id="togglePassword2"
                                                style="margin-left: -30px; cursor: pointer;"></i>
                                        </div>
                                        @error('confirm_password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor" name="status"
                                                id="status" value="1" checked>
                                            <label class="form-check-label cursor" for="status"
                                                style="font-weight: bold;">Status</label>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor"
                                                name="is_approved" id="is_approved" value="1" checked>
                                            <label class="form-check-label cursor" for="is_approved"
                                                style="font-weight: bold;">Approved</label>
                                        </div>
                                    </div>


                                    <div class="row mb-4 justify-content-sm-end">
                                        <div class="col-lg-3 col-md-4 col-sm-5 col-6">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- .row // -->
                    </div>
                    <!-- card body .// -->
                </div>
                <!-- card .// -->
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
    <script type="text/javascript">
        function mainThamUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result).width(100).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


        $(document).on("click", "#togglePassword1", function() {
            var password1 = $("#password").attr('type');
            if (password1 == "password") {
                $("#password").attr('type', "text");
                $(this).removeClass("far fa-eye").addClass("far fa-eye-slash");
            } else {
                $("#password").attr('type', "password");
                $(this).removeClass("far fa-eye-slash").addClass("far fa-eye");
            }
            console.log("type of password 1", password1)
        })
        $(document).on("click", "#togglePassword2", function() {
            var password2 = $("#confirm_password").attr('type');
            if (password2 == "password") {
                $("#confirm_password").attr('type', "text");
                $(this).removeClass("far fa-eye").addClass("far fa-eye-slash");
            } else {
                $("#confirm_password").attr('type', "password");
                $(this).removeClass("far fa-eye-slash").addClass("far fa-eye");
            }
            console.log("type of password 2", password2)
        })
    </script>
@endpush