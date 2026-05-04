<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Modules\Students;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Brand;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Invoice;
use App\Models\ProductItem;
use App\Models\ProductsMaintenanceHistory;

class ProductItemController extends Controller
{
    public function list($id)
    {
        $product = Product::find($id);
        $employees = Employee::all();
        return view('admin.products.items.list', compact('product', 'employees'));
    }
    public function edit($id)
    {
        try {
            $item = ProductItem::find($id);
            $products = Product::all();
            return view('admin.products.items.edit', compact('item', 'products'));

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'price' => 'required',
            'product_id' => 'required'
        ], [
            'product_id.required' => 'The product field is required',
        ]);

        try {
            $item = ProductItem::find($id);
            $product = Product::find($request->product_id);

            $item->serial_no = $request->serial_no;
            $item->product_code = $request->product_code;
            $item->product_id = $request->product_id;
            $item->price = $request->price;
            $item->variation_id = $product->type == 'variable' ? $request->variation_id : null;
            $item->save();

            return redirect()->back()->with('success', 'Item Successfully Updated');
        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());
        }

    }

    public function delete($id)                                                 // Delete Product Item
    {
        try {
            $product_item = ProductItem::find($id);
            if($product_item){

                $product_item->item_histories->each->delete();

                $invoice = adjustInvoiceTotal($product_item->invoice, $product_item->price);

                $invoice_item = $product_item->invoice_item;
                if($invoice_item->quantity == 1){
                    $product_item->delete();
                    $invoice_item->delete();
                } else {
                    $invoice_item->quantity--;
                    $invoice_item->total_amount -= $product_item->price;
                    $invoice_item->save();
                    $product_item->delete();
                }

            }

            return redirect()->back()->with('success', 'Item Successfully Deleted');
        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());
        }
    }

    public function deleteInvoiceItem($id)                                      // Delete Invoice Item
    {
        try {
            $invoice_item = InvoiceItem::find($id);

            if($invoice_item){

                foreach ($invoice_item->product_items as $product_item)
                {
                    $product_item->item_histories->each->delete();
                    $product_item->delete();
                }

                $invoice = adjustInvoiceTotal($invoice_item->invoice, $invoice_item->total_amount, $invoice_item->quantity);

                $invoice_item->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Invoice Item Successfully Deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getemployee(Request $request)
    {
        try{
            $item = ProductItem::find($request->productitem_id);
            $employees = Employee::all();
            $html = view('admin.products.items.partials.assign_inner', compact('item','employees'))->render();

           return response()->json([
            'success' => true,
            'html' => $html
           ]);
        }
        catch(\Exception $exception)
        {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }

    public function assignemployee(Request $request)
    {
        try {
            $item = ProductItem::find($request->productitem_id);
            $item->employee_id = $request->employee_id;
            $item->save();

            return redirect()->back()->with('success', 'Item Successfully Assigned');
        } catch (\Exception $exception){
            return redirect()->back()->with('failed', $exception->getMessage());
        }

    }

}
