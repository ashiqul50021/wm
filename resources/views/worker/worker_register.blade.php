<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Worker Signup</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    @php
        $logo = get_setting('site_favicon');
    @endphp
    @if ($logo != null)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')->value ?? ' ') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('upload/no_image.jpg') }}"
            alt="{{ env('APP_NAME') }}" />
    @endif
    <!-- Template CSS -->
    <link href="{{ asset('backend/assets/css/main.css?v=1.1 ') }}" rel="stylesheet" type="text/css" />
    <!-- toastr css -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <main>
        <section class="content-main">
            <div class="card mx-auto card-login shadow-lg" style="margin-top: 70px; max-width: 600px">
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

                    <h4 class="card-title mb-4 text-center">Worker Signup</h4>
                    <form action="{{ route('worker.registerRequest') }}" method="post"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input class="form-control" placeholder="Name" type="text" id="email"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('email')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" placeholder="Email" type="text" id="email"
                                        name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- form-group// -->
                                <div class="mb-3">
                                    <input class="form-control" placeholder="Password" id="password" type="password"
                                        name="password" required>
                                    @error('password')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" placeholder="Confirm Password" id="password"
                                        type="password" name="confirm_password" required>
                                    @error('confirm_password')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <select name="selectePart" id="" class="form-select" required>
                                        <option value="" disabled selected>--select part---</option>
                                        <option value="body-part">Body Part</option>
                                        <option value="finishing-part">Finishing Part</option>
                                    </select>
                                    @error('selectePart')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label" style="font: bold">Profile Image</label>
                                    <div id="image-preview">
                                        <img id="selected-image" src="{{ asset('upload/no_image.jpg') }}"
                                            width="100" height="100" alt="Selected Image">
                                    </div>
                                    <label for="image" class="col-form-label" style="font-weight: bold;">Profile:
                                        <span class="text-danger">*</span></label>
                                    <input name="profile_image" class="form-control" type="file" id="image">
                                    @error('profile_image')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input class="form-control" placeholder="Phone" type="text" id="phone"
                                        name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Address</label>
                                    <textarea name="address" id="" class="form-control" cols="30" rows="10">{{old('address')}}</textarea>
                                    @error('address')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Description</label>
                                    <textarea name="description" id="" class="form-control" cols="30" rows="10">{{old('description')}}</textarea>
                                    @error('description')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <input class="form-control" placeholder="Nid Number" type="number" id="nid"
                                        name="nid" value="{{ old('nid') }}" >
                                    @error('phone')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label" style="font: bold">Nid Photo</label>
                                    <div id="image-preview">
                                        <img id="selected-nid" src="{{ asset('upload/no_image.jpg') }}"
                                            width="100" height="100" alt="Selected Image">
                                    </div>
                                    <input class="form-control" id="nidphoto" type="file" name="nid_photo" >
                                    @error('nid_photo')
                                        <span class="text-danger" style="font-weight: bold;">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <!-- form-group// -->
                        {{-- <div class="mb-3">
                                <a href="{{ route('dealer.password.request') }}" class="float-end font-sm text-muted">Forgot password?</a>
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" checked="" />
                                    <span class="form-check-label">Remember</span>
                                </label>
                            </div> --}}
                        <!-- form-group form-check .// -->
                        <div class="mb-4">
                            <button type="submit"
                                class="btn btn-primary w-100 justify-content-center">Register</button>
                        </div>
                        <!-- form-group// -->
                    </form>
                    <style type="text/css">
                        table,
                        tbody,
                        tfoot,
                        thead,
                        tr,
                        th,
                        td {
                            border: 1px solid #dee2e6 !important;
                        }

                        th {
                            font-weight: bolder !important;
                        }

                        .custom_input input,
                        button,
                        select,
                        optgroup,
                        textarea {
                            margin: 0;
                            font-family: inherit;
                            font-size: inherit;
                            line-height: inherit;
                            border: none;
                            width: 72px;
                        }
                    </style>
                    {{-- <div class="mt-4">
                            <table class="table table-bordered custom_input">
                                <tbody>
                                    <tr>
                                        <td>admin@gmail.com</td>
                                        <td><input type="password" name="" value="12345678" disabled></td>
                                        <td><button  class="btn btn-info btn-xs" onclick="autoFill()">Copy</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
                    <p class="text-center small text-muted mb-15">or sign In with</p>

                    <p class="text-center mb-4">Already have account? <a href="{{ route('worker.login_form') }}">Sign
                            In</a></p>
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

    <!-- all toastr message show -->
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <!-- 3 color toastr message show -->
    <script type="text/javascript">
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>

    <!-- copy to password show  -->
    <script type="text/javascript">
        function autoFill() {
            $('#email').val('admin@gmail.com');
            $('#password').val('12345678');
        }


        $('#image').change(function(e) {
            e.preventDefault();

            // Get the selected file
            var file = this.files[0];

            // Check if a file was selected
            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Display the selected image instantly
                    $('#selected-image').attr('src', e.target.result);
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(file);
            }
        });
        $('#nidphoto').change(function(e) {
            e.preventDefault();

            // Get the selected file
            var file = this.files[0];

            // Check if a file was selected
            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Display the selected image instantly
                    $('#selected-nid').attr('src', e.target.result);
                };

                // Read the selected file as a data URL
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
