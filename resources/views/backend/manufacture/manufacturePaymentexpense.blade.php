@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Manufacture Payments list <span class="badge rounded-pill alert-success">
                    @if (!empty($manufactureLedger))
                        {{ count($manufactureLedger) }}
                    @endif
                </span></h2>
            <div>
                {{-- <a href="{{ route('manufacture.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Add
                    Product</a>
                <a href="{{ route('manufacture.orderPayment') }}" class="btn btn-primary"><i
                        class="material-icons md-plus"></i>Order Payment</a> --}}
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>

                                <th scope="col">Worker Name</th>
                                <th scope="col">Expenses</th>
                                <th scope="col">Date</th>
                                <th scope="col">Collected By</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($manufactureLedger->count() > 0)
                                @foreach ($manufactureLedger as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td>{{$item->user->name ?? 'N/A'}}</td>
                                        <td>{{$item->credit ?? 'N/A'}}</td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $item->collectedBy->name ?? 'N/A' }}</td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm"> <i
                                                        class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">

                                                    @if (Auth::guard('admin')->user()->role == '2')
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('manufacture.delete.expense', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @else
                                                        @if (Auth::guard('admin')->user()->role == '1' ||
                                                                in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('manufacture.delete.expense', $item->id) }}"
                                                                id="delete">Delete</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- dropdown //end -->
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p class="text-center">no data found</p>
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.flexSwitchCheckDefault').change(function() {
                var id = $(this).attr('data-id');
                var url = "{{ route('manufacture.confirmOrder', '') }}" + "/" + id;
                var value = 0;
                console.log(id)
                console.log(url)
                if (this.checked) {
                    value = 1;
                    console.log("Checkbox checked", value);
                } else {
                    value = 0;
                    console.log("Checkbox unchecked", value);
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        value: value,
                        _token: '{{ csrf_token() }}'

                    },
                    success: function(response) {
                        // Handle the response here
                        console.log(response)
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                    }
                });



            })
        })
    </script>
@endpush