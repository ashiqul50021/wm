@extends('admin.admin_master')
@section('admin')
@php
    $manufacturePriceSum = 0;
    $totalPriceSum = 0;
    $totalQuantitySum = 0;
@endphp
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Manufacture Confirmed Order List <span class="badge rounded-pill alert-success">
                    @if (!empty($confirmedOrders))
                        {{ count($confirmedOrders) }}
                    @endif
                </span></h2>

        </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('confirmedDateSearch') }}" method="get" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            @php

                                $users = App\Models\User::where('role', 7)->latest()->get();
                            @endphp
                         <label for="">Select Worker Name</label>
                            <select class="select2 form-control " name="worker" id="end_date">
                                <option value="" selected> Select worker</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mt-4">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Product Image</th>
                                <th scope="col">Manufacture Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Worker Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Manufacture Part</th>
                                <th scope="col">Manufacture Price</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Confirmation</th>
                                <th scope="col">Status</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order update Date</th>
                                <th scope="col">Collected By</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($confirmedOrders->count() > 0)
                                @foreach ($confirmedOrders as $key => $item)
                                    <tr>
                                        <td> {{ $key + 1 }} </td>
                                        <td width="10%">
                                            <a href="#" class="itemside">
                                                <div class="left">
                                                    @if ($item->product->product_thumbnail ?? '')
                                                        <img src="{{ asset($item->product->product_thumbnail) }}"
                                                            class="img-sm" alt="Userpic"
                                                            style="width: 80px; height: 70px;">
                                                    @else
                                                        <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                            alt="Userpic" style="width: 80px; height: 70px;" />
                                                    @endif
                                                </div>
                                            </a>
                                        </td>
                                        <td width="10%">
                                            <a href="{{ route('manufacture.printOrder', $item->id) }}" target="_blank" class="itemside">
                                                <div class="left">
                                                    @if ($item->product->menu_facture_image?? '')
                                                        <img src="{{ asset($item->product->menu_facture_image) }}"
                                                            class="img-sm" alt="Userpic"
                                                            style="width: 80px; height: 70px;">
                                                    @else
                                                        <img class="img-lg mb-3" src="{{ asset('upload/no_image.jpg') }}"
                                                            alt="Userpic" style="width: 80px; height: 70px;" />
                                                    @endif
                                                </div>
                                            </a>
                                        </td>
                                        <td> {{ $item->product->name_en ?? 'NULL' }} </td>
                                        <td> {{ $item->user->name ?? 'NULL' }} </td>
                                        <td>{{$item->customer_name ?? 'NULL'}}</td>
                                        <td> {{ $item->manufacture_quantity ?? 'NULL' }} </td>
                                        <td> {{ $item->manufacture_part ?? '-' }} </td>
                                        <td> {{ $item->manufacture_price ?? '' }} </td>
                                        <td width="8%" > {{ $item->total_price ?? '' }} </td>
                                        <td>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input flexSwitchCheckDefault" type="checkbox" data-id={{ $item->id }}
                                                   @if ($item->is_confirm ==1)
                                                    checked
                                                    @endif>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckDefault">Confirmation</label>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->is_complete == 1)
                                                <span class="badge rounded-pill alert-success">Completed</span>
                                                <span>Order by: {{ $item->userOrderBy->name ?? '' }}</span>
                                                <span>Collected by: {{ $item->userOrderBy->name ?? '' }}</span>
                                            @else
                                                <span class="badge rounded-pill alert-warning">Pending</span><br>
                                                <span>Order by: {{ $item->userOrderBy->name ?? '' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->created_at->format('M j, Y h:i A') }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at->format('M j, Y h:i A') }}
                                        </td>
                                        <td>{{$item->userCollectedBy->username ?? ''}}</td>

                                        <td class="text-end">
                                            <div class="dropdown">
                                                <a href="#" data-bs-toggle="dropdown"
                                                    class="btn btn-light rounded btn-sm font-sm"> <i
                                                        class="material-icons md-more_horiz"></i> </a>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item" href="{{ route('manufacture.edit', $item->id) }}">Edit
                                                info</a> --}}
                                                    {{-- <a class="dropdown-item" href="{{ route('manufacture.printOrder', $item->id) }}">Print Order</a> --}}

                                                    @if (Auth::guard('admin')->user()->role == '2')
                                                        <a class="dropdown-item text-danger"
                                                            href="{{ route('product.delete', $item->id) }}"
                                                            id="delete">Delete</a>
                                                    @else
                                                        @if (Auth::guard('admin')->user()->role == '1' ||
                                                                in_array('4', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                                            <a class="dropdown-item text-danger"
                                                                href="{{ route('manufacture.delete', $item->id) }}"
                                                                id="delete">Delete</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- dropdown //end -->
                                        </td>

                                    </tr>

                                    @php
                                    $manufacturePriceSum += $item->manufacture_price ?? 0;
                                    $totalPriceSum += $item->total_price ?? 0;
                                    $totalQuantitySum += $item->manufacture_quantity ?? 0;
                                    @endphp

                                @endforeach
                            @else
                                <p class="text-center">no data found</p>
                            @endif

                        </tbody>
                        <tr class="text-bold">
                            <td colspan="5"></td>
                            <td style="font-weight: 900;">Total Quantity: {{ $totalQuantitySum }}</td>
                            <td></td>
                            <td style="font-weight: 900;"></td>
                            <td style="font-weight: 900;">Total Price: {{ $totalPriceSum }}</td>
                            <td colspan="5"></td>
                        </tr>

                    </table>
                </div>
                <!-- table-responsive //end -->
            </div>
            <!-- card-body end// -->
        </div>
    </section>
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

          <script>
              $(document).ready(function() {
                  $('#reportrange').daterangepicker({
                      locale: {
                          format: 'DD-MM-Y'
                      },
                      ranges: {
                          'Today': [moment(), moment()],
                          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                          'This Month': [moment().startOf('month'), moment().endOf('month')],
                          'This Year': [moment().startOf('year'), moment().endOf('year')]
                      }
                  });
              });
          </script>
          <link rel="stylesheet" href="path/to/select2.min.css">
          <script src="path/to/select2.min.js"></script>

          <!-- Initialize Select2 -->
          <script>
              $(document).ready(function () {
                  $('.select2').select2();
              });
          </script>

    @endpush
@endsection