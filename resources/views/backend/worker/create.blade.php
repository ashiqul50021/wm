@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Worker Create</h2>
            <div class="">
                <a href="{{ route('worker.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Dealer
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('worker.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="col-form-label col-md-4" style="font-weight: bold;"> Name :
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" type="text" name="name"
                                        placeholder="Write Worker name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="col-form-label col-md-4" style="font-weight: bold;"> Phone
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="phone" type="text" name="phone"
                                        placeholder="Write worker phone number" value="{{ old('phone') }}">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="email" class="col-form-label col-md-4" style="font-weight: bold;"> Email
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="email" type="email" name="email"
                                        placeholder="Write worker email address" value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="address" class="col-form-label col-md-4" style="font-weight: bold;">Address
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        placeholder="Write worker address" value="{{ old('address') }}">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="description" class="col-form-label col-md-4"
                                        style="font-weight: bold;">Description :</label>
                                    <textarea name="description" id="description" cols="5" placeholder="Write worker description"
                                        class="form-control ">{{ old('description') }}</textarea>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="nid" class="col-form-label col-md-4" style="font-weight: bold;"> NID
                                        : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="nid" type="number" name="nid"
                                        placeholder="Write Worker NID number" value="{{ old('nid') }}" required>
                                    @error('nid')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="col-md-6 md-4 mt-4">
                                    <div class="custom_select">
                                        <select
                                            class="form-control select-active w-100 form-select select-nice selectedpart"
                                            name="manufacture_part" id="manufacture_part">
                                            <option selected disabled value="">--Select Part--</option>
                                            <option value="body-part">Body Part</option>
                                            <option value="finishing-part">Finishing Part</option>
                                        </select>
                                        @error('manufacture_part')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
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
                                        <input name="image" class="form-control" type="file" id="image">
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="mb-4 row">
                                <div class="col-md-6">
                                    <label for="password" class="col-form-label col-md-4" style="font-weight: bold;">
                                        Password : <span class="text-danger">*</span></label>
                                    <input class="form-control" id="password" type="password" name="password"
                                        placeholder="Write worker Password">
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
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
