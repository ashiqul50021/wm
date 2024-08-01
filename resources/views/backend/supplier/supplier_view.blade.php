@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Supplier List <span class="badge rounded-pill alert-success"> {{ count($suppliers) }}
                </span></h2>
            <div>
                <a href="{{ route('supplier.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create
                    Supplier</a>
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Status</th>
                                @if (Auth::guard('admin')->user()->role != '2')
                                    <th scope="col" class="text-end">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->name ?? '' }} </td>
                                    <td> {{ $item->phone ?? '' }} </td>
                                    <td> {{ $item->email ?? '' }} </td>
                                    <td> {{ $item->address ?? '' }} </td>

                                    <td>
                                        @if ($item->status == 1)
                                            <a
                                                @if (Auth::guard('admin')->user()->role != '2') href="{{ route('supplier.in_active', ['id' => $item->id]) }}" @endif>
                                                <span class="badge rounded-pill alert-success">Active</span>
                                            </a>
                                        @else
                                            <a
                                                @if (Auth::guard('admin')->user()->role != '2') href="{{ route('supplier.active', ['id' => $item->id]) }}" @endif>
                                                <span class="badge rounded-pill alert-danger">Disable</span></a>
                                        @endif
                                    </td>
                                    @if (Auth::guard('admin')->user()->role != '2')
                                        <td class="text-end">
                                            {{-- <a href="#" class="btn btn-md rounded font-sm">Detail</a> --}}
                                            <button class="btn btn-md rounded font-sm"
                                                onclick="viewInfo({{ $item->id }})">view info</button>
                                                <a class="btn btn-md rounded font-sm"
                                                    href="{{ route('supplier.edit', $item->id) }}">Edit info</a>
                                                <a class="btn btn-md rounded font-sm bg-danger"
                                                    href="{{ route('supplier.destroy', $item->id) }}"
                                                    id="delete">Delete</a>
                                                {{-- <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('supplier.edit',$item->id) }}">Edit info</a>
                                            <a class="dropdown-item text-danger" href="{{ route('supplier.destroy',$item->id) }}" id="delete">Delete</a>
                                        </div>
                                    </div> --}}
                                                <!-- dropdown //end -->
                                        </td>
                                    @endif
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



    <!-- Modal HTML -->
    <div id="showInfoModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier Info</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name:</td>
                                <td id="supplierName"></td>
                            </tr>
                            <tr>
                                <td>Total Product</td>
                                <td id="totalProduct">

                                </td>
                            </tr>
                            <tr>
                                <td>Total Price Accoriding To Stock</td>
                                <td id="totalPriceAccordingToStock">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script>
        function viewInfo(id) {

            var url = "{{ route('supplier.viewInfo', '') }}" + "/" + id;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $("#supplierName").text(data?.supplier?.name)
                    $("#totalProduct").text(data?.count)
                    $("#totalPriceAccordingToStock").text(data?.supplierProducts)

                    $("#showInfoModal").modal('show')

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });

            ;
        }



        $(document).ready(function(){
            $('.close').click(function(){
            $("#showInfoModal").modal('hide');

        })
    });
    </script>
@endpush
