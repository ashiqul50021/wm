@extends('admin.admin_master')
@section('admin')
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
                <a href="{{ route('roles.index') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Role
                    List</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-white">Role Information</h5>
                    </div>
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
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
                            @endphp

                            {{-- pos  --}}
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Pos</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">Place Pos Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="1000" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(1000, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show Pos
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="1001" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(1001, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            {{-- product  --}}
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
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>

                            <!--product category start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Category</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">Add New Product Category
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="5" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(5, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Category
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="6" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(6, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Product Category
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="7" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(7, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Product Category
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="8" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(8, $permissions)) echo "checked"; @endphp>
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
                                                    <label class="control-label" id="flexSwitch1">Add New Attribute
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="9" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(9, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Attribute
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
                                                    <label class="control-label" id="flexSwitch1">Add New Unit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="13" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(13, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Unit
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
                                                    <label class="control-label" id="flexSwitch1">Add New Brand
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="17" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(17, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Show All Brand
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


                            <!--Product Review Start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Product Review</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Review
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
                                                    <label class="control-label" id="flexSwitch2">Published Review
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
                                                    <label class="control-label" id="flexSwitch2">Delete Review
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="23" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(23, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Product Review End-->


                            <!--Manufacture Order Start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Manufacture</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">Order Create
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="24" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(24, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Order
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
                                                    <label class="control-label" id="flexSwitch2">Delete Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="26" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(26, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Receive Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="27" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(27, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Manufacture Stock
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="28" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(28, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Body Order
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="29" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(29, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Manufacture Payment
                                                        Info
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
                                                    <label class="control-label" id="flexSwitch2">Delete Manufacture
                                                        Payment Info
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
                                                    <label class="control-label" id="flexSwitch2">View Worker Balance
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
                                                    <label class="control-label" id="flexSwitch2">Make Worker Payment
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="33" type="checkbox" id="flexSwitch2"
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
                            <!--Manufacture Order End -->


                            <!--seller start--->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Branch</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Branch List
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="34" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(34, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Branch
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="35" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(35, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Branch
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
                                                    <label class="control-label" id="flexSwitch2">Delete Branch
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="37" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(37, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--seller end--->

                            <!-- Dealer Start -->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Dealer</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Dealer List
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="38" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(38, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Dealer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="39" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(39, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Dealer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="40" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(40, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Dealer
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="41" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(41, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Dealer Request
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="42" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(42, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Confirm Dealer Request
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="43" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(43, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Dealer Request
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="44" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(44, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Dealer Order
                                                        Confirm
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="45" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(45, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Dealer Due Product Show
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="46" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(46, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Dealer Due
                                                        Product
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="47" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(47, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Dealer View
                                                        Profit
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                   value="481" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(481, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Dealer End -->


                            <!--Worker start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Worker</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Worker List
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="48" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(48, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Add Worker
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="49" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(49, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Worker
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="50" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(50, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Worker
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="51" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(51, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">View Register Request
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="52" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(52, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Worker Request Confirm
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="520" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(520, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Worker Request Delete
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="5201" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(5201, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br>
                            <!--Worker End-->


                            <!--campaign start--->

                            {{-- <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Campaign</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View campaign
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="53" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(53, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">add campaign
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="54" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(54, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit campaign
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="55" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(55, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete campaign
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="56" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(56, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br> --}}
                            <!--campaign end-->



                            <!--coupon start-->
                            {{-- <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Coupon</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Coupon list
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="57" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(57, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">add Coupon
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="58" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(58, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Edit Coupon
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="59" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(59, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch2">Delete Coupon
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" name="permissions[]"
                                                                value="60" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(60, $permissions)) echo "checked"; @endphp>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>


                                        </div>
                                    </li>
                                </ul>
                            </div><br>
                            <br> --}}
                            <!--coupon end--->



                            <!--supplier start-->
                            <div class="bd-example">
                                <ul class="list-group">
                                    <li class="list-group-item bg-light" aria-current="true">Supplier</li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                    <label class="control-label" id="flexSwitch1">View Supplier List
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
                            <br>

                            <!--supplier end-->

                        {{-- sales part start  --}}


            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Sales</li>
                </ul>
            </div><br>


             {{-- all orders  --}}
             <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">All Orders</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">Show All Orders
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="65"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="65" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(65, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Order Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="66"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="66" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(66, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Download Order
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="67"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="67" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(67, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Delete Order
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="68"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="68" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(68, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
             {{-- pos order  --}}
             <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Pos Orders</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">Show Pos All Orders
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="69"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="69" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(69, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Pos Order Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="70"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="70" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(70, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Download Pos Order
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="71"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="71" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(71, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Delete Pos Order
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="72"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="72" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(72, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>

             {{-- customer Due --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Customer Due</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Customer Due page
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="73"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="73" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(73, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Collect Payment
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="74"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="74" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(74, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Show Due Collect Page
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="75"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="75" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(75, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Due Collect
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="76"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="76" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(76, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
             {{-- Due Collect  --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Due Collect</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Due Collect Page
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="77"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="77" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(77, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
            {{-- sale --}}
            {{-- <div class="bd-example">
               <ul class="list-group">
                  <li class="list-group-item bg-light" aria-current="true">Sale</li>
                  <li class="list-group-item">
                     <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                            <label class="control-label" id="flexSwitch1">View All Orders
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" name="permissions[]" value="17"  type="checkbox" id="flexSwitch1">
                                  </div>
                            </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">View Order Details
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]" value="18"  type="checkbox" id="flexSwitch2">
                                      </div>
                                </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Update Order Payment Status
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]" value="19"  type="checkbox" id="flexSwitch2">
                                      </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Delete Order
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]" value="20"  type="checkbox" id="flexSwitch2">
                                      </div>
                                </label>
                            </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div><br> --}}


            {{-- Report part  --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Report</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Report
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="86"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="780" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(780, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Product Stock
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="86"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="78" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(78, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Pos Sale Report
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="87"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="79" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(79, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View All Order Sale Report
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="88"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="80" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(80, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View All Order Profit Report
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="88"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="800" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(800, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>

            {{-- Banner Part --}}
            <div class="bd-example">
                <ul class="list-group">
                <li class="list-group-item bg-light" aria-current="true">Banner</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Banner List
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="89"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="81" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(81, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Banner Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="90"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="82" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(82, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Banner Edit
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="91"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="83" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(83, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Banner Delete
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="92"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="84" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(84, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Banner Add
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="93"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="85" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(85, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Banner Create
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="94"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="86" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(86, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
            {{-- Subscribers  --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Subscribers</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Subscribers List
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="permissions[]"
                                        value="87" type="checkbox" id="flexSwitch1"
                                        @php if(in_array(87, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">Delete Subscriber
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="permissions[]"
                                        value="877" type="checkbox" id="flexSwitch2"
                                        @php if(in_array(877, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
            {{-- pages --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Pages</li>
                   <li class="list-group-item">
                     <div class="row">
                         <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                             <label class="control-label" id="flexSwitch1">View All Page
                                   <div class="form-check form-switch">
                                       {{-- <input class="form-check-input" name="permissions[]" value="96"  type="checkbox" id="flexSwitch1"> --}}
                                       <input class="form-check-input" name="permissions[]"
                                                                value="88" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(88, $permissions)) echo "checked"; @endphp>
                                   </div>
                             </label>
                            </div>
                         </div>
                         <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                    <label class="control-label" id="flexSwitch2">Add Page
                                       <div class="form-check form-switch">
                                           {{-- <input class="form-check-input" name="permissions[]" value="97"  type="checkbox" id="flexSwitch2"> --}}
                                           <input class="form-check-input" name="permissions[]"
                                                                value="89" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(89, $permissions)) echo "checked"; @endphp>
                                       </div>
                                 </label>
                            </div>
                         </div>
                         <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                             <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                    <label class="control-label" id="flexSwitch2">Edit Page
                                       <div class="form-check form-switch">
                                           {{-- <input class="form-check-input" name="permissions[]" value="98"  type="checkbox" id="flexSwitch2"> --}}
                                           <input class="form-check-input" name="permissions[]"
                                                                value="90" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(90, $permissions)) echo "checked"; @endphp>
                                       </div>
                                 </label>
                             </div>
                         </div>
                         <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                             <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                    <label class="control-label" id="flexSwitch2">Delete Page
                                       <div class="form-check form-switch">
                                           {{-- <input class="form-check-input" name="permissions[]" value="99"  type="checkbox" id="flexSwitch2"> --}}
                                           <input class="form-check-input" name="permissions[]"
                                                                value="91" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(91, $permissions)) echo "checked"; @endphp>
                                       </div>
                                 </label>
                             </div>
                         </div>
                     </div>
                   </li>
                </ul>
            </div><br>

            {{-- Accounts --}}
            <div class="bd-example">
                 <ul class="list-group">
                    <li class="list-group-item bg-light" aria-current="true">Accounts</li>
                     <li class="list-group-item">
                         <div class="row">
                             <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                 <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                 <label class="control-label" id="flexSwitch1">View Cashbook
                                     <div class="form-check form-switch">
                                         {{-- <input class="form-check-input" name="permissions[]" value="100"  type="checkbox" id="flexSwitch1"> --}}
                                         <input class="form-check-input" name="permissions[]"
                                                                value="92" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(92, $permissions)) echo "checked"; @endphp>
                                     </div>
                                 </label>
                                 </div>
                             </div>
                             <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                 <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                         <label class="control-label" id="flexSwitch2">Account Ledger Add
                                         <div class="form-check form-switch">
                                             {{-- <input class="form-check-input" name="permissions[]" value="101"  type="checkbox" id="flexSwitch2"> --}}
                                             <input class="form-check-input" name="permissions[]"
                                                                value="93" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(93, $permissions)) echo "checked"; @endphp>
                                         </div>
                                     </label>
                                 </div>
                             </div>
                         </div>
                     </li>
                 </ul>
              </div><br>
            {{-- User Setting --}}
            <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">User Setting</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View User List
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="102"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="94" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(94, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>ff
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">View Out User List
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="103"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="95" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(95, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Out User Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="104"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="96" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(96, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Out User Edit
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="105"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="97" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(97, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Out User Delete
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="106"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="98" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(98, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">User Create
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="107"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="99" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(99, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">User Edit
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="108"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="100" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(100, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">User Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="109"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="101" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(101, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">User Delete
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="110"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="102" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(102, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div><br>
            {{-- Blog --}}
            {{-- <div class="bd-example">
               <ul class="list-group">
                  <li class="list-group-item bg-light" aria-current="true">Blog</li>
                  <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                            <label class="control-label" id="flexSwitch1">View Blogs
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" name="permissions[]"
                                                                value="103" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(103, $permissions)) echo "checked"; @endphp>
                                  </div>
                            </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Add Blog
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="104" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(104, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Edit Blog
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="105" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(105, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Delete Blog
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="106" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(106, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                    </div>
                  </li>
               </ul>
            </div><br> --}}

            {{-- Otp System --}}
            {{-- <div class="bd-example">
               <ul class="list-group">
                  <li class="list-group-item bg-light" aria-current="true">OTP System</li>
                  <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                            <label class="control-label" id="flexSwitch1">OTP Configurations
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" name="permissions[]"
                                                                value="107" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(107, $permissions)) echo "checked"; @endphp>
                                  </div>
                            </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">SMS Templates
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="108" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(108, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Sms Providers Configurations
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="109" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(109, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Send Bulk SMS
                                      <div class="form-check form-switch">
                                          <input class="form-check-input" name="permissions[]"
                                                                value="110" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(110, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                    </div>
                  </li>
               </ul>
            </div><br> --}}
            {{-- Slider --}}
            <div class="bd-example">
               <ul class="list-group">
                  <li class="list-group-item bg-light" aria-current="true">Slider</li>
                  <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                            <label class="control-label" id="flexSwitch1">View All Slider
                                  <div class="form-check form-switch">
                                      {{-- <input class="form-check-input" name="permissions[]" value="119"  type="checkbox" id="flexSwitch1"> --}}
                                      <input class="form-check-input" name="permissions[]"
                                                                value="111" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(111, $permissions)) echo "checked"; @endphp>
                                  </div>
                            </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                           <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Add Slider
                                      <div class="form-check form-switch">
                                          {{-- <input class="form-check-input" name="permissions[]" value="120"  type="checkbox" id="flexSwitch2"> --}}
                                          <input class="form-check-input" name="permissions[]"
                                                                value="112" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(112, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Edit Slider
                                      <div class="form-check form-switch">
                                          {{-- <input class="form-check-input" name="permissions[]" value="121"  type="checkbox" id="flexSwitch2"> --}}
                                          <input class="form-check-input" name="permissions[]"
                                                                value="113" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(113, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                   <label class="control-label" id="flexSwitch2">Delete Slider
                                      <div class="form-check form-switch">
                                          {{-- <input class="form-check-input" name="permissions[]" value="122"  type="checkbox" id="flexSwitch2"> --}}
                                          <input class="form-check-input" name="permissions[]"
                                                                value="114" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(114, $permissions)) echo "checked"; @endphp>
                                      </div>
                                </label>
                            </div>
                        </div>
                    </div>
                  </li>
               </ul>
            </div><br>
            {{-- Settings  --}}
             <div class="bd-example">
                <ul class="list-group">
                   <li class="list-group-item bg-light" aria-current="true">Settings</li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                <label class="control-label" id="flexSwitch1">View Home setting
                                    <div class="form-check form-switch">
                                        {{-- <input class="form-check-input" name="permissions[]" value="123"  type="checkbox" id="flexSwitch1"> --}}
                                        <input class="form-check-input" name="permissions[]"
                                                                value="115" type="checkbox" id="flexSwitch1"
                                                                @php if(in_array(115, $permissions)) echo "checked"; @endphp>
                                    </div>
                                </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Update Home Setting
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="124"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="116" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(116, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Activation View
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="125"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="117" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(117, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Activation Update
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="126"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="118" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(118, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Facebook Plugin View
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="127"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="119" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(119, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Facebook Plugin Update
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="128"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="120" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(120, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shopping Methods View
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="129"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="121" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(121, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shopping Methods Details
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="130"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="122" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(122, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shopping Methods Edit
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="131"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="123" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(123, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shopping Methods Update
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="132"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="124" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(124, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shopping Methods Delete
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="133"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="125" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(125, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Payment Methods View
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="134"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="126" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(126, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Payment Methods Update
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="135"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="127" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(127, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                        <label class="control-label" id="flexSwitch2">Shipping Method Create
                                        <div class="form-check form-switch">
                                            {{-- <input class="form-check-input" name="permissions[]" value="135"  type="checkbox" id="flexSwitch2"> --}}
                                            <input class="form-check-input" name="permissions[]"
                                                                value="128" type="checkbox" id="flexSwitch2"
                                                                @php if(in_array(128, $permissions)) echo "checked"; @endphp>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
             </div><br>




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

@endsection