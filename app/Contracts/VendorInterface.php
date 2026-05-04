<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


interface VendorInterface
{
    /**
     * Add new Model.
     * @return Model
     */
    public function add($data): Model;

    /**
     * Update existing Model.
     * @return Model|boolean
     */
    public function update($data): Model|null;

    /**
     * get model list.
     * @return Collection
     */
    public function getlist(): Collection;

    /**
     * Delete model.
     * @return bool
     */
    public function destroy($id): bool;

}
