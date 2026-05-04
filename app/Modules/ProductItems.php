<?php

namespace App\Modules;

use App\Contracts\ProductItemsInterface;
use App\Models\ProductItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductItems implements ProductItemsInterface
{
    public function __construct(public ProductItem $productItem)
    {
        //
    }

    /**
     * Add new product item.
     * @return ProductItem
     */

    public function add($data): ProductItem
    {
        $productItem = new $this->productItem;

        foreach ($data as $key => $value){
            $productItem->{$key} = $value;
        }

        $productItem->save();

        return $productItem;
    }

    /**
     * Update existing product items.
         * @return Collection
     */

    public function update($id, $data, $invoice_id): Collection
    {
        $productItems = $this->productItem->where('invoice_item_id', $id)->get();

        if ($productItems->count() > $data['quantity']) {

            $diff = $productItems->count() - $data['quantity'];
            foreach ($productItems as $item) {
                if($diff > 0) {
                    $item->delete();
                    $diff--;
                }
            }
        } elseif ($productItems->count() < $data['quantity']) {             //      2 to 4

            $diff = $data['quantity'] - $productItems->count();

            for ($x = 0; $x < $diff; $x++)
            {
                $product_item = new $this->productItem;
                $product_item->invoice_id = $invoice_id;
                $product_item->product_id = $data['product'];
                $product_item->invoice_item_id = $id;
                $product_item->variation_id = $data['variation'] ?? null;
                $product_item->department_id = Auth::user()->department_id;
                $product_item->price = $data['product_price'];
                $product_item->save();
            }

        }

        foreach ($productItems as $product_item)
        {
            $product_item->invoice_id = $invoice_id;
            $product_item->product_id = $data['product'];
            $product_item->invoice_item_id = $id;
            $product_item->variation_id = $data['variation'] ?? null;

            if(!$product_item->department_id) {
                $product_item->department_id = Auth::user()->department_id;
            }
            $product_item->price = $data['product_price'];
            $product_item->save();
        }


        return $productItems;
    }

}
