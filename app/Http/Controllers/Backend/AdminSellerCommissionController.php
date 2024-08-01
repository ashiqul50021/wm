<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SellerCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminSellerCommissionController extends Controller
{
    public function index()
    {
        $sellerCommissions = SellerCommission::latest()->get();
        return view('backend.seller_commission.view', compact('sellerCommissions'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('backend.seller_commission.add', compact('categories'));
    }

    public function store(Request $request)
    {

        $validator = $request->validate(
            [
                'category_id' => 'required|unique:seller_commissions,category_id',
                'commission_percentage' => 'required',
            ],
            [
                'category_id.unique' => 'This Category wise Percentage Already Taken',
            ]
        );

        SellerCommission::create([
            'category_id' => $request->category_id,
            'commission_percentage' => $request->commission_percentage,
        ]);
        Session::flash('success', 'Commission Inserted Successfully');
        return redirect()->route('sellerCommission.index');
    }

    public function edit($id)
    {
        $commission = SellerCommission::find($id);
        $categories = Category::latest()->get();
        return view('backend.seller_commission.edit', compact('commission', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $validator = $request->validate(
            [
                'category_id' => 'required|unique:seller_commissions,category_id',
                'commission_percentage' => 'required',
            ],
            [
                'category_id.unique' => 'This Category wise Percentage Already Taken',
            ]
        );

        SellerCommission::find($id)->update([
            'category_id' => $request->category_id,
            'commission_percentage' => $request->commission_percentage,
        ]);
        Session::flash('success', 'Commission Updated Successfully');
        return redirect()->route('sellerCommission.index');
    }
  
    public function destroy($id)
    {
        $commission = SellerCommission::find($id);

        if (!$commission) {
            Session::flash('error', 'Commission not found.');
            return redirect()->route('sellerCommission.index');
        }

        $commission->delete();

        Session::flash('success', 'Commission Deleted Successfully');
        return redirect()->route('sellerCommission.index');
    }
}
