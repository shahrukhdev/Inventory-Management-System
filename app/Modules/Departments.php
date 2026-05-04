<?php

namespace App\Modules;

use App\Contracts\DepartmentInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Departments implements DepartmentInterface
{
    public function __construct(public Department $department)
    {
        //
    }

    /**
     * get users list.
     * @return Collection
     */

    public function getlist(): Collection
    {
        return $this->department->all();
    }

    /**
     * Add new user.
     * @return Department
     */

    public function add($data): Department
    {
        $department = $this->department;

        foreach ($data as $key => $value)
        {
            $department->{$key} = $value;
        }

        $department->save();

        return $department;
    }

    /**
     * Update existing user.
     * @return Department
     */

    public function update($data): Model|bool
    {
        $department = $this->department->find($data['id']);

        unset($data['id']);

        foreach ($data as $key => $value)
        {
            $department->{$key} = $value;
        }

        $department->save();

        return $department;
    }

    /**
     * Delete user.
     * @return bool
     */

    public function destroy($id): bool
    {
        return $this->department->destroy($id);
    }
}
