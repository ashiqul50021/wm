<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dealer Register</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/assets/imgs/theme/favicon.svg ') }}" />
    <!-- Template CSS -->
    <link href="{{ asset('backend/assets/css/main.css?v=1.1 ') }}" rel="stylesheet" type="text/css" />
    <!-- toastr css -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <main>
        <section class="content-main">
            <div class="card mx-auto card-login shadow-lg" style="margin-top: 0px;max-width: 600px;">
                <div class="card-body">

                    <!-- start login aleart message show -->
                    @if (Session::has('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session::get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- end login aleart message show -->

                    <h4 class="card-title mb-4 text-center">Sign Up</h4>
                    <form action="{{ route('dealer.register.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name">User Name</label>
                                    <input class="form-control" id="name" placeholder="User Name " type="text"
                                        name="name" />
                                    @error('name')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class=" mb-4">
                                    <label for="shop_name" class="col-form-label col-md-4" style="font-weight: bold;">Shop
                                        Name:</label>
                                    <input class="form-control" id="shop_name" type="text" name="shop_name"
                                        placeholder="Write Dealer shop name" value="{{ old('shop_name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" id="email" placeholder="Your email" type="text"
                                        name="email" />
                                    @error('email')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>

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


                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control" placeholder="Password" id="password" type="password"
                                        name="password" />
                                    @error('password')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- form-group// -->
                                <!-- form-group// -->
                                <div class="mb-3">
                                    <label class="form-label" for="rtpassword">Re-type Password</label>
                                    <input class="form-control" placeholder="Confirm Password" type="password"
                                        name="password_confirmation" id="rtpassword" />
                                    @error('password_confirmation')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <img id="showImage4" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <div class="mb-4">
                                    <label for="image4" class="col-form-label" style="font-weight: bold;">Trade
                                        license:</label>
                                    <input name="trade_license" class="form-control" type="file" id="image4">
                                </div>



                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="form-check-input me-2 cursor" name="status"
                                        id="status" checked value="1">
                                    <label class="form-check-label cursor" for="status">Status</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input class="form-control" id="phone" placeholder="User Phone "
                                        type="number" name="phone" />
                                    @error('name')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="address" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Address : <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        placeholder="Write Dealer address" value="{{ old('address') }}">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
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

                                <div class="mb-4">
                                    <label for="description" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Description :</label>
                                    <textarea name="description" id="description" cols="5" placeholder="Write Dealer description"
                                        class="form-control ">{{ old('description') }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="shop_name" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Google Map Url:</label>
                                    <input class="form-control" id="google_map_url" type="url" name="google_map_url"
                                        placeholder="Write Google Map Url" value="{{ old('google_map_url') }}">
                                </div>

                                <div class="mb-4">
                                    <img id="showImage3" class="rounded avatar-lg"
                                        src="{{ !empty($editData->profile_image) ? url('upload/admin_images/' . $editData->profile_image) : url('upload/no_image.jpg') }}"
                                        alt="Card image cap" width="100px" height="80px;">
                                </div>
                                <div class="mb-4">
                                    <label for="image3" class="col-form-label" style="font-weight: bold;">Nid
                                        Card:</label>
                                    <input name="nid" class="form-control" type="file" id="image3">
                                </div>



                            </div>
                        </div>
                        <!-- form-group// -->
                        <div class="mb-4">
                            <button type="submit"
                                class="btn btn-primary w-100 justify-content-center">Register</button>
                        </div>
                        <!-- form-group// -->
                    </form>
                    <p class="text-center small text-muted mb-15">or sign up with</p>

                    <p class="text-center mb-4">Already have an account? <a
                            href="{{ route('dealer.login_form') }}">Sign in now</a></p>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('backend/assets/js/vendors/jquery-3.6.0.min.js ') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/bootstrap.bundle.min.js ') }}"></script>
    <script src="{{ asset('backend/assets/js/vendors/jquery.fullscreen.min.js ') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('backend/assets/js/main.js?v=1.1" type="text/javascript ') }}"></script>

    <!-- toastr js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        @if (Session::has('success'))
            toastr.warning("{{ Session::get('success') }}");
        @endif
        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>


    <!-- profile Cover Photo Show -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
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
    <!-- shop Image license Show -->
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
</body>

</html>
