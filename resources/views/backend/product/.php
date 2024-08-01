@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@push('css')
<style>
.form-control, .form-select {
    border: 1px solid #4f5d77 !important;
    padding-left: 10px !important;
}
</style>
@endpush
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Manufacturing Images <span class="badge rounded-pill alert-success"> {{ count($products) }} </span></h2>
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
               <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Name (English)</th>
                            <th scope="col">Product Image</th>
                             <th scope="col">Size/Color</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Parts</th>
                            <th scope="col">Staff</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                            @if($product->is_varient)
                                @foreach ($product->stocks as $key => $stock)
                                    <tr>
                                        <td> {{ $product->name_en ?? 'NULL' }} </td>
                                        <td>
                                            <a href="{{route('menufacturing.print',$stock->id)}}" target="_blank" class="itemside">
                                                <div class="left">
                                                    <img src="{{ asset($stock->manufimage) }}" class="img-sm" id="print-image" alt="Not image found" style="width: 80px; height: 70px;">
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $stock->varient }}</td>
                                        <td>
                                            <input type="text" name="manu_qty" id="getQty{{$stock->id}}" onchange="sendQty({{$stock->id}})" placeholder="Quantity" value="{{$stock->manu_qty}}">
                                        </td>
                                        <td>
                                            <form>
                                                <label class="radio-inline"><input type="radio" name="optradio" id="Body_Parts" onclick="selectType('Body-Parts')">&nbsp; Body Parts</label>&nbsp;
                                                  
                                                <label class="radio-inline"><input type="radio" name="optradio" id="Finishing_Parts" onclick="selectType('Finishing-Parts')">&nbsp; Finishing Parts</label>
                                            </form>
                                        </td>
                                        <td>
                                            <select name="staff_id" class="form-control select-active w-100 form-select" id="staff_id(id)" onchange="sendStaff({{$stock->id}})">
                                                <option value='0'>-- Assaign By --</option>
                                                @foreach($staffs as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->user->name }}</option>
                                                @endforeach
                                            </select> 
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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

@push('footer-script')
<script>
    $(document).ready(function() {
      $('.print-image').on('click', function() {
        var imageSrc = $(this).data('src');
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print Image</title></head><body><img src="' + imageSrc + '" onload="window.print();" /></body></html>');
        printWindow.document.close();
      });
    });
  </script>
  
 <script>
    function sendQty(id) {
         const manu_qty = document.getElementById('getQty'+id).value;
         $.ajax({
            type: "get",
            url: "{{url('/admin/product/save-qty/')}}/"+id+"/"+manu_qty,
            success: function(response) {
                //console.log(response)
                $("#getQty").val(manu_qty)
            }
         });
    }
</script>

 <script>
    function sendStaff(id) {
         const staff_id = document.getElementById('staff_id').value;
        //  console.log(staff_id);
         $.ajax({
            type: "get",
            url: "{{url('/admin/product/save-staff/')}}/+staff_id,
            success: function(response) {
                console.log(response)
                $("#staff_id").val(staff_id)
            }
         });
    }
</script>

 <script>
    function selectType(type) {
       $.ajax({
           type:"get",
           url:"{{url('/admin/product/menufacturing-image/type/')}}/"+type,
           success: function(response) {
                // console.log(response)
                $("#staff_id").html(response)
            }
       });
    }
</script>
@endpush