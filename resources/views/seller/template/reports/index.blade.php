@extends('seller.seller_master')
@section('seller')
<style type="text/css">
    table, tbody, tfoot, thead, tr, th, td{
        border: 1px solid #dee2e6 !important;
    }
    th{
        font-weight: bolder !important;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Product wise stock report</h2>
    </div>
    <div class="row justify-content-center">
    	<div class="col-sm-10">
    		<div class="card">
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-12">
		                   <div class="card-body">
				                <form action="{{ route('seller.stock_report.index') }}" method="GET">
				                    {{-- <div class="form-group row mb-3">
				                        <label class="col-md-6 col-form-label">Sort by Category :</label>
				                        <div class="col-md-4">
				                        	<div class="custom_select">
				                        		<select class="form-select select-active select-nice" aria-label="Default select example" name="category_id" required>
                                                    <option value="" disabled selected> select category</option>
											  @foreach (\App\Models\Category::all() as $key => $category)
				                                    <option value="{{ $category->id }}">{{ $category->name_en }}</option>
				                                @endforeach
											</select>
				                        	</div>
				                        </div>
				                        <div class="col-md-2">
				                            <button class="btn btn-primary" type="submit">Filter</button>
				                        </div>
				                    </div> --}}
				                </form>
				                <table id="example" class="table table-bordered table-hover mb-0">
				                    <thead>
				                        <tr>
				                            <th>Product Name</th>

				                            <th class="text-center">Stock</th>
				                        </tr>
				                    </thead>


				                    @if($products->count() > 0)
					                    <tbody>
						                        @foreach ($products as $key => $product)

							                            <tr>
							                                <td>{{ $product->name_en }}</td>
							                                <td class="text-center">{{ $product->stock_qty }}</td>
							                            </tr>

						                        @endforeach
					                    </tbody>
				                    @else
					                    <tbody>
					                       <tr>
				                                <td colspan="3" class="text-center">There Are No Products.</td>
				                            </tr>
					                    </tbody>
				                    @endif
				                </table>
				                <div class="pagination-area mt-25 mb-50">
		                            <nav aria-label="Page navigation example">
		                                <ul class="pagination justify-content-end">
		                                    {{-- {{ $products->links() }} --}}
		                                </ul>
		                            </nav>
		                        </div>
				            </div>
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
