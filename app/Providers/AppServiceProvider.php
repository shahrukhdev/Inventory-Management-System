<?php

namespace App\Providers;

use App\Contracts\BrandInterface;
use App\Contracts\DepartmentInterface;
use App\Contracts\InvoiceInterface;
use App\Contracts\InvoiceItemInterface;
use App\Contracts\ProductInterface;
use App\Contracts\ProductItemsInterface;
use App\Contracts\TestInteface;
use App\Contracts\UserInterface;
use App\Contracts\VendorInterface;
use App\Modules\Brands;
use App\Modules\Departments;
use App\Modules\InvoiceItems;
use App\Modules\Invoices;
use App\Modules\ProductItems;
use App\Modules\Products;
use App\Modules\Users;
use App\Modules\Vendors;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, Users::class);
        $this->app->bind(BrandInterface::class, Brands::class);
        $this->app->bind(VendorInterface::class, Vendors::class);
        $this->app->bind(InvoiceInterface::class, Invoices::class);
        $this->app->bind(InvoiceItemInterface::class, InvoiceItems::class);
        $this->app->bind(ProductItemsInterface::class, ProductItems::class);
        $this->app->bind(DepartmentInterface::class, Departments::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
