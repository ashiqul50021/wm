@extends('dealer.dealer_master')
@section('dealer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Brand list <span class="badge rounded-pill alert-success"> {{ count($brands) }} </span></h3>
        {{-- <div>
            <a href="{{ route('dealer.brand.add') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Brand Create</a>
        </div> --}}
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Cover Photo</th> 
                            <th scope="col">Name (English)</th> 
                            <th scope="col">Name (Bangla)</th> 
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $key => $brand)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($brand->brand_image) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
                            <td> {{ $brand->name_en ?? 'NULL' }} </td>
                            <td> {{ $brand->name_bn ?? 'NULL' }} </td>
                            <td>
                                @if($brand->status == 1)
                                  <a>
                                    <span class="badge rounded-pill alert-success">Active</span>
                                  </a>
                                @else
                                  <a> <span class="badge rounded-pill alert-danger">Disable</span></a>
                                @endif
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