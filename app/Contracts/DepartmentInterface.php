<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface DepartmentInterface
{
    /**
     * Get Model list.
     * @return Collection
     */
    public function getlist(): Collection;

    /**
     * Add new Model.
     * @return Model
     */
    public function add($data): Model;

    /**
     * Update existing Model.
     * @return Model|boolean
     */
    public function update($data): Model|bool;

    /**
     * Delete model.
     * @return bool
     */
    public function destroy($id): bool;
}
