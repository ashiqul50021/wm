@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Account Ledgers <span class="badge rounded-pill alert-success"> {{ count($account_ledgers) }} </span></h3>
        <div>
            <!--<a href="{{ route('accounts.ledgers.report_print') }}" class="btn btn-primary">-->
            <!--    <i class="material-icons md-print"></i>-->
            <!--</a>-->
        </div>
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
               <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Account Head</th> 
                            <th scope="col">Particulars</th> 
                            <th scope="col">Created At</th>
                            @if($account  == 'debit')
                            <th scope="col">Deposit</th>
                            @else
                            <th scope="col">Expense</th>
                            @endif
                            <th scope="col">Balance</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    @php
                        $amount=0;
                        $sum1=0;
                        $sum2=0;
                    @endphp
                    <tbody>
                        @foreach($account_ledgers as $key => $ledger)
                        <tr>
                            <td> {{ $ledger->account_head->title ?? '' }} </td>
                            <td> {{ $ledger->particulars }} </td>
                            <td> {{ date_format(date_create($ledger->created_at),"Y/m/d" ) }} </td>
                            @if($account  == 'debit')
                                <td> {{ $ledger->credit }} </td>
                            @else
                                <td> {{ $ledger->debit }} </td>
                            @endif
                            <td> {{ $ledger->balance }} </td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        @if(Auth::guard('admin')->user()->role == '1' || in_array('52', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                            <a class="dropdown-item text-danger" href="{{ route('accounts.ledgers.delete',$ledger->id) }}" id="delete">Delete</a>
                                        @endif
                                    </div>
                                </div>
                                <!-- dropdown //end -->
                            </td>
                        </tr> 
                        @php
                          $amount+=$ledger->credit;
                          $sum1+=$ledger->debit;
                          $sum2=$ledger->balance;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center"></td>
                            <!--<td>Sum : {{ $amount }}</td>-->
                            <!--<td>Sum : {{ $sum1 }}</td>-->
                            @if($account  == 'debit')
                                <td>Sum : {{ $amount }} </td>
                            @else
                                <td>Sum : {{ $sum1 }} </td>
                            @endif
                            <td >Balance : {{ $sum2 }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
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
        $(document).ready(function(){
            $(document).on('click', '.viweBtn', function(){
                var p_name = $(this).closest('tr').find('.p_name').text();
                // alert(p_name);
                $.ajax({
                    type: "POST",
                    url: "",
                    data: {
                        'checking_view': true,
                        'p_name': p_name,
                    },
                    success: function(response){
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush