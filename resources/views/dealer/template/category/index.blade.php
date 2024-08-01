@extends('dealer.dealer_master')
@section('dealer')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Category List <span class="badge rounded-pill alert-success"> {{ count($categories) }} </span></h2>
        {{-- <div>
            <a href="{{ route('dealer.category.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Add Category</a>
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
                            <th scope="col">Image</th>
                            <th scope="col">Name (English)</th> 
                            <th scope="col">Name (Bangla)</th> 
                            <th scope="col">Type</th> 
                            <th scope="col">Parent</th>
                            <th scope="col">Status</th>
                            <th scope="col">Featured</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $category)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($category->image) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
	                        <td> {{ $category->name_en ?? '' }} </td> 
	                        <td> {{ $category->name_bn ?? '' }} </td> 
	                        <td>
                             @if($category->type==1)
                                Parent Category
                             @elseif($category->type==2)
                                Sub Category
                             @elseif($category->type==3)
                                Sub Sub Category
                             @endif
                            </td> 
	                        <td> {{ $category->parent_name ?? '-' }} </td> 
                            <td>
                                @if($category->status == 1)
                                  <a>
                                    <span class="badge rounded-pill alert-success">Active</span>
                                  </a>
                                @else
                                  <a> <span class="badge rounded-pill alert-danger">Disable</span></a>
                                @endif
                            </td>
                            <td>
                                @if($category->is_featured == 1)
                                  <a>
                                    <span class="badge rounded-pill alert-success"><i class="material-icons md-check"></i></span>
                                  </a>
                                @else
                                  <a> <span class="badge rounded-pill alert-danger"><i class="material-icons md-close"></i></span></a>
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