<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface InvoiceItemInterface
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
    public function update($data): Model|bool;

}
