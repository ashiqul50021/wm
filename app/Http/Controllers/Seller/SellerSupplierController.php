<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SellerSupplierController extends Controller
{
    public function SupplierView()
    {

            $role = Auth::guard('seller')->user()->role;
            if($role == '9'){
                $suppliers = Supplier::where('vendor_id', 0)->where('seller_id', NULL)->where('status',1)->latest()->get();
                return view('seller.template.supplier.supplier_view', compact('suppliers'));
            }
    }

    public function create()
    {
        $role = Auth::guard('seller')->user()->role;
        if ($role == '9') {
            return view('seller.template.supplier.create');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $supplier = Supplier::where('phone', $request->phone)->first();

        if ($supplier) {
            $notification = array(
                'message' => 'Supplier Phone Already Created.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            Supplier::insert([
                'name' => $request->name,
                'seller_id' => Auth::guard('seller')->user()->id,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'status' => $request->status ? 1 : 0,
                'created_by' => Auth::guard('seller')->user()->id,
            ]);

            Session::flash('success', 'Supplier Inserted Successfully');
            return redirect()->route('seller.supplier.all');
        }
    }

    public function edit($id)
    {
        $role = Auth::guard('seller')->user()->role;
        if($role == "9"){
            $supplier = Supplier::where('seller_id', Auth::guard('seller')->user()->id)->findOrFail($id);
            return view('seller.template.supplier.edit', compact('supplier'));
        }
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        Supplier::findOrFail($id)->update([
            'name' => $request->name,
            'seller_id' => Auth::guard('seller')->user()->id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status ? 1 : 0,
            'created_by' => Auth::guard('seller')->user()->id,
        ]);

        Session::flash('success', 'Supplier Updated Successfully');
        return redirect()->route('seller.supplier.all');
    }

    public function destroy($id)
    {
        $role = Auth::guard('seller')->user()->role;
        // dd($product);
        if ($role == '9') {
        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully.',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
    }


    /*=================== Start Active/Inactive Methoed ===================*/
    public function active($id)
    {
        $supplier = Supplier::find($id);
        $supplier->status = 1;
        $supplier->save();

        $notification = array(
            'message' => 'Supplier Active Successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function inactive($id)
    {
        $supplier = Supplier::find($id);
        $supplier->status = 0;
        $supplier->save();

        $notification = array(
            'message' => 'Supplier Inactive Successfully.',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
