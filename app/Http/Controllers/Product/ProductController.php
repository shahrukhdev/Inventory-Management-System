<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\History;
use App\Models\InvoiceItem;
use App\Traits\Histories;
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

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return view('admin.products.list', compact('products'));
    }

    public function addproduct()
    {
        $brands = Brand::all();
        return view('admin.products.add', compact('brands'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price == null ? 0 : $request->price,
                'type' => $request->type,
                'asset_type' => $request->asset_type,
                'brand_id' => $request->brand,
                'department_id' => Auth::user()->department_id
            ]);

            $variations = array_map('array_filter', $request->variation);
            $variations = array_filter($variations);

            if($variations && $request->type == 'variable') {
                foreach ($variations as $variation) {
                    $newvariation = new Variation();
                    $newvariation->title = $variation['title'];
                    $newvariation->price = $variation['price'];
                    $newvariation->product_id = $product->id;
                    $newvariation->save();
                }
            }

            if($product)
            {
                return redirect()->back()->with('success', 'Product Successfully Added');
            }
            return redirect()->back()->with('failed', 'Something Went Wrong! Please try again later.');

        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::find($id);
            $brands = Brand::all();
            $variations = $product->variations;
            return view('admin.products.edit', compact('product','brands', 'variations'));

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function update($id, UpdateProductRequest $request)
    {
        try {
            $product = Product::find($id);
            $type = $product->type;

            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price == null ? 0 : $request->price;
            $product->type = $request->type;
            $product->asset_type = $request->asset_type;
            $product->brand_id = $request->brand;
            $product->save();

            if($type != $request->type) {
                $existingvariations = Variation::where('product_id', $product->id)->delete();
            }

            $variations = array_map('array_filter', $request->variation);
            $variations = array_filter($variations);

            if($request->type == 'variable') {
                foreach ($variations as $variation) {
                    $variation_id = $variation['id'] ?? null;
                    $existingvariation = Variation::find($variation_id);
                    if (!$existingvariation) {
                        $newvariation = new Variation();
                        $newvariation->title = $variation['title'];
                        $newvariation->price = $variation['price'];
                        $newvariation->product_id = $product->id;
                        $newvariation->save();
                    } else {
                        $existingvariation->title = $variation['title'];
                        $existingvariation->price = $variation['price'];
                        $existingvariation->product_id = $product->id;
                        $existingvariation->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Product Successfully Updated');

        } catch (\Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);

            if($product) {

            $product_items = $product->productitems;                                  // To handle Invoice data
            foreach ($product_items as $product_item)
            {
                $invoice = $product_item->invoice;
                $invoice->amount -= $product_item->price;
                $invoice->quantity--;
                $invoice->save();

                $product_item->item_histories->each->delete();
            }
            $product->productitems->each->delete();
            $product->invoice_items->each->delete();

                Variation::where('product_id', $product->id)->delete();

                $product->delete();
            }

            return redirect()->back()->with('success', 'Product Successfully Deleted');

        } catch (\Exception $e) {

            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    public function deletevariation(Request $request)
    {
        try {
            $variation = Variation::find($request->variation_id);
            if($variation) {

                foreach ($variation->productitems as $productitem){
                    $invoice = $productitem->invoice;
                    $invoice->quantity--;
                    $invoice->amount -= $productitem->price;
                    $invoice->save();

                    $productitem->item_histories->each->delete();
                    $productitem->delete();
                }
                InvoiceItem::where('variation_id', $variation->id)->delete();
                $variation->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Variation Successfully Deleted'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
