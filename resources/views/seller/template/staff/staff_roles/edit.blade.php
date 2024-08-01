@extends('vendor.vendor_master')
@section('vendor')
    <style type="text/css">
        .checkbox_custom .form-switch .form-check-input {
            width: 4em;
            margin-left: -1.5em;
            border-radius: 2em;
        }

        .checkbox_custom .form-check-input {
            width: 1em;
            height: 2em;
            margin-top: 1.25em;
            margin-bottom: 1.25em;
            cursor: pointer
        }
    </style>
    <section class="content-main">
        <div class="content-header">
            <h2 class="content-title">Role Information</h2>
            <div class="">
                <a href="{{ route('vendor.roles.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Role
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-white">Role Information</h5>
                    </div>
                    <form action="{{ route('vendor.roles.update', $role->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label" for="name">Name</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Name" id="name" name="name"
                                        class="form-control" value="{{ $role->name }}" required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h5 class="">Permissions</h5>
                            </div>
                            <hr>
                            @php
                                $permissions = json_decode($role->permissions);
                                // dd($permissions)
                            @endphp
                            <!----product--->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">Add New product
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="1" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(1, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Products
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="2" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(2, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Products Edit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="3" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(3, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Products Delete
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="4" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(4, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Products duplicate
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="73" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(73, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Products Barcode Generate
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="74" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(74, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--product end-->
                            <!--product category start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Category</li>
                                    <li class="list-group-item">
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Product Categories
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="5" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(5, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--product category end--->


                            <!--product attribute start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Attribute</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Product Attributes
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="9" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(9, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Product Attribute
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="10" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(10, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Product Attribute
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="11" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(11, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Product Attribute
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="12" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(12, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--product attribute end-->


                            <!--product unit start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Unit</li>
                                    <li class="list-group-item">
                                        <div class="row">

                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Unit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="13" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(13, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Unit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="14" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(14, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Unit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="15" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(15, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Unit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="16" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(16, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--product unit end-->

                            <!--product brand start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Brand</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Brand
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="17" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(17, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Brand
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="18" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(18, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Brand
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="19" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(19, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Brand
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="20" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(20, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--product brand end-->

                            <!--supplier-->
                                 {{-- <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true">Supplier</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <label class="control-label" id="flexSwitch1">View Supplier list
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" name="permissions[]"
                                                                    value="61" type="checkbox" id="flexSwitch1"
                                                                    @php if(in_array(61, $permissions)) echo "checked"; @endphp>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <label class="control-label" id="flexSwitch2">Supplier Edit
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" name="permissions[]"
                                                                    value="62" type="checkbox" id="flexSwitch2"
                                                                    @php if(in_array(62, $permissions)) echo "checked"; @endphp>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <label class="control-label" id="flexSwitch2">Supplier Create
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" name="permissions[]"
                                                                    value="63" type="checkbox" id="flexSwitch2"
                                                                    @php if(in_array(63, $permissions)) echo "checked"; @endphp>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <label class="control-label" id="flexSwitch2">Delete Supplier
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" name="permissions[]"
                                                                    value="64" type="checkbox" id="flexSwitch2"
                                                                    @php if(in_array(64, $permissions)) echo "checked"; @endphp>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>


                                            </div>
                                        </li>
                                    </ul>
                                </div><br>
                                <br> --}}

                            <!--supplier end-->

                            <!--sales-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Sales</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Pos Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="21" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(21, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Pos Order Details
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="22" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(22, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Download Pos Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="23" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(23, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Pos Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="24" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(24, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Customer Due
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="25" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(25, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Due Collect Info
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="26" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(26, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--sales end-->

                            <!--Report Start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Report</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Product Stock
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="27" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(27, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Pos Sale Report
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="28" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(28, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Report End-->

                            <!--Customer Start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Customer</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View All Customer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="29" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(29, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Customer Details
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="30" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(30, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Customer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="31" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(31, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Customer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="32" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(32, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Customer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="33" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(33, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Customer End-->
                            <!--Account Start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Accounts</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Cashbook
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="34" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(34, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Account End-->

                            {{-- supplier part --}}
 <!--Customer Start-->
 <div class="bd-example">
    <ul class="list-group">
        <li class="list-group-item bg-light" aria-current="true">Suppliers</li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                        <label class="control-label" id="flexSwitch1">View All Supplier
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="permissions[]"
                                    value="35" type="checkbox" id="flexSwitch1"
                                    @php if(in_array(35, $permissions)) echo "checked"; @endphp>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                        <label class="control-label" id="flexSwitch2">Add Supplier
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="permissions[]"
                                    value="36" type="checkbox" id="flexSwitch2"
                                    @php if(in_array(36, $permissions)) echo "checked"; @endphp>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                        <label class="control-label" id="flexSwitch2">Edit Supplier
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="permissions[]"
                                    value="37" type="checkbox" id="flexSwitch2"
                                    @php if(in_array(37, $permissions)) echo "checked"; @endphp>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                        <label class="control-label" id="flexSwitch2">Delete Supplier
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="permissions[]"
                                    value="38" type="checkbox" id="flexSwitch2"
                                    @php if(in_array(38, $permissions)) echo "checked"; @endphp>
                            </div>
                        </label>
                    </div>
                </div>

            </div>
        </li>
    </ul>
</div><br>
<br>
                            <div class="row mb-4 mt-3 justify-content-sm-end">
                                <div class="col-lg-2 col-md-4 col-sm-5 col-6">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </div>
                        <!-- card body .// -->
                    </form>
                </div>
                <!-- card .// -->
            </div>
        </div>
    </section>
    k
@endsection
