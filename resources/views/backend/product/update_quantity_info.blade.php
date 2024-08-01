@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">

            <div>
                <a href="{{ route('product.add') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add
                    Product</a>
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Product ID</th>
                                <th scope="col">Update Date</th>
                                <th scope="col">Change Member Name</th>
                                <th scope="col">Previous Quantity</th>
                                <th scope="col">Updated Quantity </th>

                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($products->quantity_update_info->updated_at); --}}
                            {{-- @dd($item); --}}
                            <tr>
                                @if (isset($product))
                                    <td>Product ID: {{ $product->id }}</td>
                                    @if ($product->quantity_update_info)
                                        @php
                                            $quantityUpdateInfo = json_decode($product->quantity_update_info);
                                        @endphp
                                     <td>
                                        @if (isset($quantityUpdateInfo->updated_at))
                                            {{ \Carbon\Carbon::parse($quantityUpdateInfo->updated_at)->format('d F Y, h:i A') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @php
                                        $user = App\Models\User::where('id',$quantityUpdateInfo->user_id)->first();
                                    @endphp
                                        <td>{{ $user->name ?? 'N/A' }}</td>
                                        <td>{{ $quantityUpdateInfo->previous_quantity ?? 'N/A' }}</td>
                                        <td>{{ $quantityUpdateInfo->quantity_update ?? 'N/A' }}</td>
                                    @else
                                        <td colspan="4">No quantity update info available.</td>
                                    @endif
                                @else
                                    <td colspan="5">Product not found.</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>

    </section>
@endsection

