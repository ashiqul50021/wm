@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Seller Change Passoword</h2>
            <div class="">
                <a href="{{ route('seller.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Vendor
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('seller.adminUpdatePassword',$seller->id)}}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="" class="form-label">New Password</label>
                                <input type="password" class="form-control" placeholder="Enter Passoword" name="password">
                            </div>
                            <div class="mb-4">
                                <label for="" class="form-label">Confirm Passoword</label>
                                <input type="password" class="form-control" placeholder="Enter Confirm Price" name="confirm_password">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
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
@endpush
