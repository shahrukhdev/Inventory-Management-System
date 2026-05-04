<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductItemsInterface
{
    /**
     * Add new Model.
     * @return Model
     */
    public function add($data): Model;

    /**
     * Update existing Model.
     * @return Model|bool
     */
    public function update($id, $data, $invoice_id): Collection|bool;
}
