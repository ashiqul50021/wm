<?php

namespace App\Http\Controllers\API\Seller;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerAttributeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
        ]);
        $attribute = Attribute::create([
            'seller_id' => $user,
            'name' => $request->name,
            'created_by' => $user,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Attributes Inserted Successfully',
            'Attributes' => $attribute,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = Auth::user()->id;
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json([
                'message' => 'Attribute not found',
            ], 404);
        }
        if ($attribute->seller_id != $user) {
            return response()->json([
                'message' => 'No Access to Update this Attribute',
            ], 404);
        }

        $attribute->update([
            'seller_id' => $user,
            'name' => $request->name,
            'created_by' => $user,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Attribute Updated Successfully',
            'attribute' => $attribute,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user()->id;
        $attribute = Attribute::findOrFail($id);

        if ($attribute->seller_id != $user) {
            return response()->json([
                'message' => 'No Access to Delete the Attribute',
            ], 404);
        }
        $attribute->delete();

        return response()->json([
            'message' => 'Attribute Deleted Successfully',

        ], 200);
    }
    // Value Store
    public function value_store(Request $request)
    {
        $this->validate($request, [
            'value' => 'required',
        ]);
        $user = Auth::user()->id;

        $value = new AttributeValue();
        $value->attribute_id = $request->attribute_id;
        $value->value = $request->value;
        $value->created_by = $user;
        $value->created_at = Carbon::now();
        $value->save();

        return response()->json([
            'message' => 'Value Store Successfully',
        ], 200);
    }
    public function value_update(Request $request, $id)
    {
        $user = Auth::user()->id;
        $attribute_val = AttributeValue::find($id);
        if (!$attribute_val) {
            return response()->json([
                'message' => 'No Attribute value is Found'
            ], 404);
        }
        if ($attribute_val->created_by != $user) {
            return response()->json([
                'message' => 'No Access',
            ], 404);
        }

        $attribute_val->value = $request->value;
        $attribute_val->created_by = $user;
        $attribute_val->update();

        return response()->json([
            'message' => 'Attribute Value Updated Successfully.',
        ], 200);
    }

    public function value_destroy($id)
    {
        $user = Auth::user()->id;
        $attribute_value = AttributeValue::findOrFail($id);

        if($attribute_value->created_by != $user){
            return response()->json([
              'message' => 'No Access',
            ]);
        }
        $attribute_value->delete();

        return response()->json([
            'message' => 'Attribute Value Deleted Successfully.'
        ],200);
    }
}
