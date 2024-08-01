@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Dealers Show</h2>
        <div class="">
            <a href="{{ route('dealer.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Dealer List</a>
        </div>
    </div>
    <div class="row justify-content-center">
    	<div class="col-sm-10">
    		<div class="card">
		        <div class="card-body">
					<div class="row">
						<div class="col-md-6 mb-4">
							<label for="name" class="col-form-label col-md-4" style="font-weight: bold;"> Name : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer name" value="{{ $dealer->user->name ?? '' }}" readonly>
						</div>
						<div class="col-md-6 mb-4">
							<label for="username" class="col-form-label col-md-4" style="font-weight: bold;"> User Name : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer user name" value="{{ $dealer->user->username ?? '' }}" readonly>
						</div>
						<div class="col-md-6 mb-4">
							<label for="username" class="col-form-label col-md-4" style="font-weight: bold;"> Shop Name : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer user name" value="{{ $dealer->shop_name ?? '' }}" readonly>
						</div>

						<div class="col-md-6 mb-4">
						<label for="phone" class="col-form-label col-md-4" style="font-weight: bold;"> Phone : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer phone number" value="{{ $dealer->user->phone ?? '' }}" readonly>
						</div>

						<div class="col-md-6 mb-4">
						<label for="email" class="col-form-label col-md-4" style="font-weight: bold;"> Email : <span class="text-danger">*</span></label>
							<input class="form-control" type="email" placeholder="Write Dealer email address" value="{{ $dealer->user->email ?? '' }}" readonly>
						</div>

						<div class="col-md-6 mb-4">
							<label for="address" class="col-form-label col-md-4" style="font-weight: bold;">Address : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer address" value="{{ $dealer->user->address ?? '' }}" readonly>
						</div>


						<div class="col-md-6 mb-4">
							<label for="description" class="col-form-label col-md-4" style="font-weight: bold;">Description :</label>
							<textarea cols="5" placeholder="Write Dealer description" class="form-control" readonly>{{ $dealer->description }}</textarea>
						</div>
                        <div class="col-md-6 mb-4">
							<label for="google_map_url" class="col-form-label col-md-4" style="font-weight: bold;">Google Map Url : <span class="text-danger">*</span></label>
							<input class="form-control" type="text" placeholder="Write Dealer Google Map Url" value="{{ $dealer->google_map_url ?? '' }}" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="mb-4">
								<label for="image" class="col-form-label" style="font-weight: bold;">Profile: <span class="text-danger">*</span></label>
							</div>
							<div class="mb-4">
								<img id="showImage" class="rounded avatar-lg" src="{{ (!empty($dealer->profile_image))? url($dealer->profile_image):url('upload/no_image.jpg') }}" alt="Card image cap" width="100px" height="80px;">
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-4">
								<label for="image2" class="col-form-label" style="font-weight: bold;">Shop Image: <span class="text-danger">*</span></label>
							</div>
							<div class="mb-4">
								<img id="showImage2" class="rounded avatar-lg" src="{{ (!empty($dealer->shop_image))? url($dealer->shop_image):url('upload/no_image.jpg') }}" alt="Card image cap" width="100px" height="80px;">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="mb-4">
								<label for="image3" class="col-form-label" style="font-weight: bold;">Nid Card:<span class="text-danger">*</span></label>
							</div>
							<div class="mb-4">
								<img id="showImage3" class="rounded avatar-lg" src="{{ (!empty($dealer->nid))? url($dealer->nid): url('upload/no_image.jpg') }}" alt="Card image cap" width="100px" height="80px;">
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-4">
								<label for="image4" class="col-form-label" style="font-weight: bold;">Trade license:<span class="text-danger">*</span></label>
							</div>
							<div class="mb-4">
								<img id="showImage4" class="rounded avatar-lg" src="{{ (!empty($dealer->trade_license))? url($dealer->trade_license): url('upload/no_image.jpg') }}" alt="Card image cap" width="100px" height="80px;">
							</div>
						</div>
					</div>

					<div class="mb-4">
						<div class="custom-control custom-switch">
							<input type="checkbox" class="form-check-input me-2 cursor" name="status" id="status" checked value="1">
							<label class="form-check-label cursor" for="status">Status</label>
						</div>
					</div>
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
        $(document).ready(function(){
            $('#image2').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage2').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Nid Card Show -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image3').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage3').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <!-- Trade license Show -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image4').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage4').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush
