<?php

use App\Models\History;
use Illuminate\Support\Facades\Auth;

function navActive($url)
{
    $class = '';
    if (url()->full() == $url) {
        $class = 'active';
    }
    return $class;
}

function getUserRedirectUrl()
{
    return route('product.list');
}

function createHistory($model, $type)
{
    $history = new History();

    $history->model_type = get_class($model);
    $history->model_id = $model->id;
    $history->type = $type;
    $history->user_id = Auth::id();
    $history->payload = $model->toArray();
    $history->save();
}

function calculateInvoiceDetails($items): array               // Calculate total quantity and price of invoice
{
    $TotAmount = 0;
    $TotQty = 0;

    foreach ($items as $v) {
        $TotAmount += $v['quantity'] * $v['product_price'];
        $TotQty += $v['quantity'];
    }

    return ['TotAmount' => $TotAmount, 'TotQty' => $TotQty];
}

function adjustInvoiceTotal($invoice, $price, $quantity = false)
{
    if(!$quantity){
        $invoice->quantity--;
        $invoice->amount -= $price;
        $invoice->save();
    } else {
        $invoice->quantity -= $quantity;
        $invoice->amount -= $price;
        $invoice->save();
    }

    return $invoice;
}
