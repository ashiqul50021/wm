@extends('dealer.dealer_master')
@section('dealer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Attribute list <span class="badge rounded-pill alert-success"> {{ count($attributes) }}</span></h3>
        {{-- <div>
            <a href="{{ route('dealer.attribute.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Attribute Create</a>
        </div> --}}
    </div>
    </div>
    <div class="card mb-4 col-10 mx-auto">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Name</th> 
                            <th scope="col">Value</th> 
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attributes as $key => $attribute)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $attribute->name ?? 'NULL' }} </td>

                            <td>
                            @foreach($attribute->attribute_values as $value)
                                 {{ $value->value ?? 'NULL' }} ,
                            @endforeach
                            </td>
                            <td class="text-end">
                                <a href="{{ route('dealer.attribute.show',$attribute->id) }}" class="btn btn-md rounded font-sm">Detail</a>
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