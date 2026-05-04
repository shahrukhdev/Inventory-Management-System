<?php

namespace App\Modules;

use App\Contracts\InvoiceInterface;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Invoices implements InvoiceInterface
{

    public function __construct(public Invoice $invoice)
    {
        //
    }

    /**
     * Get model collection.
     * @return Collection
     */
    public function getlist(): Collection
    {
        return $this->invoice->all();
    }

    /**
     * Add new invoice.
     * @return Invoice
     */

    public function add($data): Invoice
    {
        $invoice = $this->invoice;

        foreach ($data as $key => $value){
            $invoice->{$key} = $value;
        }

        $invoice->save();

        return $invoice;
    }


    /**
     * Update existing invoice.
     * @return Invoice
     */

    public function update($data): Invoice
    {
        $invoice = $this->invoice->find($data['id']);

        unset($data['id']);

        foreach ($data as $key => $value){
            $invoice->{$key} = $value;
        }

        $invoice->save();

        return $invoice;
    }

    /**
     * Delete invoice.
     * @return bool
     */

    public function destroy($id): bool
    {
        $invoice = $this->invoice->find($id);
        $product_items = $invoice->productitems;
        foreach ($product_items as $product_item)
        {
            $product_item->item_histories->each->delete();
            $product_item->delete();
        }
        $invoice->invoiceitems->each->delete();

        return $invoice->destroy($id);
    }
}

