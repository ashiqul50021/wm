@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Customer Show</h2>
            <div class="">
                <a href="{{ route('customer.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>
                    Customer List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    @csrf

                                    <div class="mb-4">
                                        <label for="name" class="col-form-label" style="font-weight: bold;">
                                            Name:</label>
                                        <input class="form-control" readonly id="name" type="text" name="name"
                                            placeholder="Write User Name" value="{{ old('name',$customer->name ?? '') }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="phone" class="col-form-label"
                                            style="font-weight: bold;">Phone:</label>
                                        <input class="form-control" readonly id="phone" type="text" name="phone"
                                            placeholder="Write Phone Number" value="{{ old('phone',$customer->phone ?? '') }}">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>



                                    <div class="mb-4">
                                        <label for="email" class="col-form-label"
                                            style="font-weight: bold;">Email:</label>
                                        <input class="form-control" id="email" type="email" name="email"
                                            placeholder="Write User Email" readonly value="{{ old('email', $customer->email ?? '') }}">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>



                                    <div class="mb-4">
                                        <label for="address" class="col-form-label"
                                            style="font-weight: bold;">Address:</label>
                                        <input class="form-control" id="address" type="text" name="address"
                                            placeholder="Write User Address" readonly value="{{ old('address',$customer->address ?? '') }}">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>





                                    <div class="mb-4">
                                        <img src="{{asset($customer->profile_image?? '')}}" alt="profile image" class="p-2" ><br>

                                    </div>

                                    <div class="mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor" name="status"
                                                id="status" value="1" @if ($customer->status == '1')
                                                checked

                                                @endif readonly>
                                            <label class="form-check-label cursor" for="status"
                                                style="font-weight: bold;">Status</label>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor" name="is_approved"
                                                id="is_approved" value="1" @if ($customer->is_approved == '1')
                                                checked

                                                @endif>
                                            <label class="form-check-label cursor" for="is_approved"
                                                style="font-weight: bold;">Approved</label>
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
    </script>
@endpush
