<?php

namespace App\Modules;

use App\Contracts\VendorInterface;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;

class Vendors implements VendorInterface
{
    public function __construct(public Vendor $vendor)
    {
        //
    }

    /**
     * Add new user.
     * @return Vendor
     */

    public function add($data): Vendor
    {
        $vendor = $this->vendor;

        foreach ($data as $key => $value)
        {
            $vendor->{$key} = $value;
        }

        $vendor->save();

        return $vendor;
    }

    /**
     * Update existing user.
     * @return Vendor
     */

    public function update($data): Vendor
    {
        $vendor = $this->vendor->find($data['id']);

        foreach ($data as $key => $value)
        {
            $vendor->{$key} = $value;
        }

        $vendor->save();

        return $vendor;
    }

    /**
     * get users list.
     * @return Collection
     */

    public function getlist(): Collection
    {
        return $this->vendor->all();
    }

    /**
     * Delete user.
     * @return bool
     */

    public function destroy($id): bool
    {
        return $this->vendor->destroy($id);
    }


}
