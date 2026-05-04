<?php

namespace App\Modules;

use App\Contracts\BrandInterface;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

class Brands implements BrandInterface
{

    public function __construct(public Brand $brand)
    {
        //
    }

    /**
     * Add new user.
     * @return Brand
     */

    public function add($data): Brand
    {
        $brand = $this->brand;

        foreach ($data as $key => $value){
            $brand->{$key} = $value;
        }

        $brand->save();

        return $brand;
    }

    /**
     * Update existing user.
     * @return Brand
     */

    public function update($data): Brand
    {
        $brand = $this->brand->find($data['id']);

        unset($data['id']);

        foreach ($data as $key => $value){
            $brand->{$key} = $value;
        }

        $brand->save();

        return $brand;
    }

    /**
     * get users list.
     * @return Collection
     */

    public function getlist(): Collection
    {
        return $this->brand->all();
    }

    /**
     * Delete user.
     * @return bool
     */

    public function destroy($id): bool
    {
        return $this->brand->destroy($id);
    }

}
