@extends('admin.admin_master')
@section('admin')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Commission List <span class="badge rounded-pill alert-success"> {{ count($sellerCommissions) }}
                </span></h2>
            <div>
                <a href="{{ route('sellerCommission.create') }}" class="btn btn-primary"><i
                        class="material-icons md-plus"></i>Add
                    Commission</a>
            </div>
        </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="example" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Commission Percentage(%) </th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellerCommissions as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->category->name_bn ?? 'NULL' }} </td>
                                    <td> {{ $item->commission_percentage ?? 'NULL' }} </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <a href="#" data-bs-toggle="dropdown"
                                                class="btn btn-light rounded btn-sm font-sm"> <i
                                                    class="material-icons md-more_horiz"></i> </a>
                                             @if (Auth::guard('admin')->user()->role == '1')
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item text-success"
                                                        href="{{ route('sellerCommission.edit', $item->id) }}"
                                                       >Edit</a>

                                                    {{-- <a class="dropdown-item text-danger"
                                                        href="{{ route('sellerCommission.destroy', $item->id) }}"
                                                        id="delete">Delete</a> --}}

                                                        <form action="{{ route('sellerCommission.destroy', $item->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-danger" id="delete">Delete</button>
                                                        </form>

                                                </div>
                                            @endif
                                        </div>
                                        <!-- dropdown //end -->
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

