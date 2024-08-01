@extends('seller.seller_master')
@section('seller')
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Commission List <span class="badge rounded-pill alert-success"> {{ count($sellerCommission) }}
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellerCommission as $key => $item)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $item->category->name_bn ?? 'NULL' }} </td>
                                    <td> {{ $item->commission_percentage ?? 'NULL' }} </td>
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

