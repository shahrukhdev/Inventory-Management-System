<?php

namespace App\Modules;

use App\Contracts\InvoiceItemInterface;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems implements InvoiceItemInterface
{
    public function __construct(public InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Add new invoice item.
     * @return InvoiceItem
     */

    public function add($data): InvoiceItem
    {
        $invoiceItem = new $this->invoiceItem;

        foreach ($data as $key => $value){
            $invoiceItem->{$key} = $value;
        }

        $invoiceItem->save();

        return $invoiceItem;
    }

    /**
     * Update existing invoice item.
     * @return InvoiceItem
     */

    public function update($data): InvoiceItem
    {
        $invoiceItem = $this->invoiceItem->find($data['id']);
        if(!$invoiceItem){
            $invoiceItem = new $this->invoiceItem;
        }

        unset($data['id']);

        foreach ($data as $key => $value)
        {
            $invoiceItem->{$key} = $value;
        }

        $invoiceItem->save();

        return $invoiceItem;
    }

}
