<?php

namespace App\Http\Controllers\Invoice;

use App\Contracts\BrandInterface;
use App\Contracts\InvoiceInterface;
use App\Contracts\InvoiceItemInterface;
use App\Contracts\ProductItemsInterface;
use App\Contracts\TestInteface;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Brand;
use App\Models\History;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\User;
use App\Models\Vendor;
use App\Modules\Brands;
use App\Modules\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
    public $invoicemodule, $invoiceItemModule, $productItemModule;

    public function __construct(InvoiceInterface $invoicemodule, InvoiceItemInterface $invoiceItemModule, ProductItemsInterface $productItemModule)
    {
        $this->invoicemodule = $invoicemodule;
        $this->invoiceItemModule = $invoiceItemModule;
        $this->productItemModule = $productItemModule;
    }

    public function list()
    {
        $invoices = $this->invoicemodule->getlist();
        return view('admin.invoices.list', compact('invoices'));
    }

    public function addinvoicelist()
    {
        $vendors = Vendor::all();
        $products = Product::all();
        return view('admin.invoices.add', compact('vendors', 'products'));
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $invoice_details = calculateInvoiceDetails($request->items);

            $reqData = [
                'invoice_no' => $request->invoice_no,
                'date' => $request->date,
                'vendor_id' => $request->vendor_id,
                'department_id' => Auth::user()->department_id,
                'quantity' => $invoice_details['TotQty'],
                'amount' => $invoice_details['TotAmount']
            ];

            $invoice = $this->invoicemodule->add($reqData);                                     // For Invoice

            foreach ($request->items as $v) {

                $requestData = [
                    'product_id' => $v['product'],
                    'invoice_id' => $invoice->id,
                    'variation_id' => $v['variation'] ?? null,
                    'quantity' => $v['quantity'],
                    'unit_price' => $v['product_price'],
                    'total_amount' => $v['quantity'] * $v['product_price'],
                ];

                $invoice_item = $this->invoiceItemModule->add($requestData);                    // For Invoice Items

                for ($x = 0; $x < $v['quantity']; $x++) {

                    $reqData = [
                        'invoice_id' => $invoice->id,
                        'product_id' => $v['product'],
                        'invoice_item_id' => $invoice_item->id,
                        'variation_id' => $v['variation'] ?? null,
                        'department_id' => Auth::user()->department_id,
                        'price' => $v['product_price']
                    ];

                    $ProdItems = $this->productItemModule->add($reqData);                       // For Product Items

                }
            }

            return redirect()->route('invoice.list')->with('success', 'Invoice Successfully Added');
        } catch (\Exception $exception) {
            return redirect()->route('invoice.list')->with('failed', $exception->getMessage());
        }

    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $vendors = Vendor::all();
        $products = Product::all();

        return view('admin.invoices.edit', compact('invoice', 'vendors', 'products'));
    }

    public function update($id, InvoiceRequest $request)
    {
        try {
            $invoice = Invoice::find($id);

            $invoice_details = calculateInvoiceDetails($request->items);

            $reqData = [
                'id' => $invoice->id,
                'invoice_no' => $request->invoice_no,
                'vendor_id' => $request->vendor_id,
                'quantity' => $invoice_details['TotQty'],
                'amount' => $invoice_details['TotAmount'],
                'date' => $request->date
            ];

            $invoice = $this->invoicemodule->update($reqData);                                      // For Invoice

            foreach ($request->items as $v) {

                $requestData = [
                    'id' => $v['invoice_item_id'] ?? null,
                    'product_id' => $v['product'],
                    'invoice_id' => $invoice->id,
                    'variation_id' => $v['variation'] ?? null,
                    'quantity' => $v['quantity'],
                    'unit_price' => $v['product_price'],
                    'total_amount' => $v['quantity'] * $v['product_price']
                ];

                $invoice_item = $this->invoiceItemModule->update($requestData);                                       // For Invoice Items


                $product_items = $this->productItemModule->update($invoice_item->id, $v, $invoice->id);               // For Product Items

            }

            return redirect()->back()->with('success', 'Invoice Successfully Updated');
        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }

    }

    public function delete($id)
    {
        try {
            $deleted = $this->invoicemodule->destroy($id);

            if ($deleted) {

                return redirect()->back()->with('success', 'Invoice Successfully Deleted');
            }
            return redirect()->route('invoice.list')->with('failed', 'Something Went Wrong! Please try again later.');

        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function getproductprice(Request $request)
    {
        try {
            $product = Product::find($request->product_id);
            if ($product->type == 'fixed') {
                $price = $product->price;
            } elseif ($product->type == 'variable') {
                $variations = $product->variations;
            }


            return response()->json([
                'success' => true,
                'product_id' => $product->id,
                'price' => $price ?? '',
                'type' => $product->type,
                'variations' => $variations ?? ''
            ]);


        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }
}

