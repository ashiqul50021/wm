@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Add Commission</h2>
            <div class="">
                <a href="{{ route('sellerCommission.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Commission
                    List</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mx-auto">
                <form method="post" action="{{ route('sellerCommission.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h3>Basic Info</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="category_id" class="col-form-label"
                                        style="font-weight: bold;">Category Name:</label>
                                    <div class="custom_select">
                                        <select class="form-control select-active w-100 form-select select-nice"
                                            name="category_id" >
                                            <option {{ old('category_id') ? '' : 'selected' }} readonly value="">
                                                --Select Category--</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="commission_percentage" class="col-form-label" style="font-weight: bold;">Commission Percentage: <span class="text-danger">*</span></label>
                                    <input class="form-control" id="commission_percentage" type="text" name="commission_percentage"
                                        placeholder="Write product name english" value="{{ old('commission_percentage') }}">
                                    @error('commission_percentage')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- card body .// -->
                    </div>
                    <!-- card .// -->

                    <div class="row mb-4 justify-content-sm-end">
                        <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
