<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Invoice;
use App\Models\ProductItem;
use App\Models\ProductsMaintenanceHistory;

class ProductHistoryController extends Controller
{
    public function list($id)
    {
        try {
            $item = ProductItem::find($id);
            return view('admin.products.items.history.list', compact('item'));

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $history = new ProductsMaintenanceHistory();
            $history->product_item_id = $request->product_item_id;
            $history->title = $request->title;
            $history->description = $request->description;
            $history->amount = $request->amount;
            $history->save();

            return redirect()->back()->with('success', 'History Successfully Added');

        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());
        }
    }

    public function edit(Request $request)
    {
        try {
            $history = ProductsMaintenanceHistory::find($request->history_id);
            $html = view('admin.products.items.history.partials.edit_inner', compact('history'))->render();

            return response()->json([
                'success' => true, 'html' => $html
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $history = ProductsMaintenanceHistory::find($id);
            $history->title = $request->title;
            $history->description = $request->description;
            $history->amount = $request->amount;
            $history->save();

            return redirect()->back()->with('success', 'History Successfully Updated');

        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());

        }
    }


    public function delete($id)
    {
        try {
            $history = ProductsMaintenanceHistory::find($id);

            if($history){
                $history->delete();
            }
            return redirect()->back()->with('success', 'History Successfully Deleted');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }


}
