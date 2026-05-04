@extends('admin.layouts.master')
@section('title', 'Edit Invoice')
@section('head')

    <style>
        .price_div {
            width: 175px !important;
        }
    </style>

@endsection
@section('content')

    <!-- BEGIN: Content-->
    @can('invoice.edit')

        @include('admin.partials.session_msgs')

        <section class="invoice-add-wrapper">
            <form action="{{ route('invoice.update', $invoice->id) }}" method="post">
                @csrf
                <div class="row invoice-add">
                    <!-- Invoice Add Left starts -->
                    <div class="col-xl-9 col-md-8 col-12">
                        <div class="card invoice-preview-card">
                            <!-- Header starts -->
                            <div class="card-body invoice-padding pb-0">
                                <div
                                    class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                    <div>
                                        <div class="logo-wrapper">
                                            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                                <defs>
                                                    <linearGradient id="invoice-linearGradient-1" x1="100%"
                                                                    y1="10.5120544%" x2="50%" y2="89.4879456%">
                                                        <stop stop-color="#000000" offset="0%"></stop>
                                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                    </linearGradient>
                                                    <linearGradient id="invoice-linearGradient-2" x1="64.0437835%"
                                                                    y1="46.3276743%" x2="37.373316%" y2="100%">
                                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-400.000000, -178.000000)">
                                                        <g transform="translate(400.000000, 178.000000)">
                                                            <path class="text-primary"
                                                                  d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                                  style="fill: currentColor"></path>
                                                            <path
                                                                d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                                fill="url(#invoice-linearGradient-1)"
                                                                opacity="0.2"></path>
                                                            <polygon fill="#000000" opacity="0.049999997"
                                                                     points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                                            </polygon>
                                                            <polygon fill="#000000" opacity="0.099999994"
                                                                     points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                                            </polygon>
                                                            <polygon fill="url(#invoice-linearGradient-2)"
                                                                     opacity="0.099999994"
                                                                     points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                                            </polygon>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                            <h3 class="text-primary invoice-logo">Inventory</h3>
                                        </div>
                                    </div>
                                    <div class="invoice-number-date mt-md-0 mt-2">
                                        <div class="d-flex align-items-center justify-content-md-end mb-1">
                                            <h4 class="invoice-title">Invoice</h4>
                                            <div class="input-group input-group-merge invoice-edit-input-group">
                                                <div class="input-group-text">
                                                    <i data-feather="hash"></i>
                                                </div>
                                                <input type="text" class="form-control invoice-edit-input"
                                                       placeholder="12345" name="invoice_no"
                                                       value="{{$invoice->invoice_no}}" required/>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="title">Date:</span>
                                            <input type="date" name="date"
                                                   class="form-control invoice-edit-input date-picker @error('date') is-invalid @enderror"
                                                   value="{{$invoice->date}}" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Header ends -->

                            <hr class="invoice-spacing"/>

                            <!-- Address and Contact starts -->
                            <div class="card-body invoice-padding pt-0">
                                <div class="row row-bill-to invoice-spacing">
                                    <div class="col-xl-8 mb-lg-1 col-bill-to ps-0">
                                        <h6 class="invoice-to-title">Vendors</h6>
                                        <div class="invoice-customer" id="testing">
                                            <select class="invoiceto form-select @error('vendor_id') is-invalid @enderror" name="vendor_id" required>
                                                <option></option>
                                                @foreach ($vendors as $vendor)

                                                    <option value="{{ $vendor->id }}"
                                                        {{ $vendor->id == $invoice->vendor_id ? 'selected' : '' }}>

                                                        {{ $vendor->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('vendor_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Address and Contact ends -->

                            <!-- Product Details starts -->
                            <div class="card-body invoice-padding invoice-product-details">
                                <div class="source-item">
                                    <div data-repeater-list="items">

                                        @foreach($invoice->invoiceitems as $key => $item)

                                            <div class="repeater-wrapper" data-repeater-item>

                                                <input type="hidden" class="invoice_item_id" name="invoice_item_id" value="{{ $item->id }}">

                                                <div class="row">
                                                    <div
                                                        class="col-12 d-flex product-details-border position-relative pe-0">
                                                        <div class="row w-100 pe-lg-0 pe-1 py-2 product_div">
                                                            <div class="col-lg-5 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2">
                                                                <p class="card-text col-title mb-md-50 mb-0">
                                                                    Products</p>
                                                                <select class="form-select item-details select_product"
                                                                        name="product">
                                                                    <option selected disabled>Select Product</option>
                                                                    @foreach ($products as $product)

                                                                        <option value="{{ $product->id }}"
                                                                                {{$product->id == $item->product_id ? 'selected' : '' }}
                                                                                data-type="{{ $product->type }}">{{ $product->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <textarea class="form-control mt-2 d-none" rows="1">Customization & Bug Fixes</textarea>
                                                            </div>


                                                                <div
                                                                    class="col-lg-3 col-12 mb-lg-0 mb-2 mt-lg-0 mt-2 variation_div {{ $item->product->type != 'variable' ? 'd-none' : ''}}"
                                                                    data-product-id="">
                                                                    <p class="card-text col-title mb-md-50 mb-0">
                                                                        Variations</p>

                                                                    <select
                                                                        class="form-select item-details select_variation"
                                                                        name="variation">
                                                                        @foreach($item->product->variations as $variation)
                                                                            <option
                                                                                value="{{ $variation->id }}" {{ $variation->id == $item->variation_id ? 'selected' : '' }} data-price="{{ $variation->price }}">{{ $variation->title }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <textarea class="form-control mt-2 d-none" rows="1">Customization & Bug Fixes</textarea>
                                                                </div>

                                                            <div class="col-lg-2 col-12 my-lg-0 my-2">
                                                                <p class="card-text col-title mb-md-2 mb-0">Qty</p>
                                                                <input type="number" class="form-control product_QTY" min="1" oninput="validity.valid||(value='');"
                                                                       placeholder="Quantity" name="quantity"
                                                                       value="{{ $item->quantity }}" required/>
                                                            </div>

                                                            <div class="col-lg-2 col-12 my-lg-0 my-2 price_div">
                                                                <p class="card-text col-title mb-md-2 mb-0">Unit Price</p>

                                                                <input type="number" class="form-control product_price"
                                                                       value="{{ $item->unit_price }}" placeholder="Price"
                                                                       name="product_price"
                                                                       data-rate required/>
                                                            </div>


                                                        </div>
                                                        <div
                                                            class="d-flex flex-column align-items-center justify-content-between border-start WQinvoice-product-actions py-50 px-25">
                                                            <i data-feather="x"
                                                               class="cursor-pointer font-medium-3 delete_item" data-item-id="{{ $item->id }}"
                                                               data-repeater-delete></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12 px-0">
                                            <button type="button" class="btn btn-primary btn-sm btn-add-new"
                                                    data-repeater-create>
                                                <i data-feather="plus" class="me-25"></i>
                                                <span class="align-middle">Add Item</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Details ends -->

                            <!-- Invoice Total starts -->
                            <div class="card-body invoice-padding">
                                <div class="row invoice-sales-total-wrapper">
                                    <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">

                                    </div>
                                    <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                        <div class="invoice-total-wrapper">
                                            <div class="invoice-total-item">
                                                <p class="invoice-total-title">Subtotal:</p>
                                                <p class="invoice-total-amount ">PKR <b class="wqSubTotal">{{ number_format($invoice->amount) }}</b></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice Total ends -->

                            <hr class="invoice-spacing mt-0"/>

                            <div class="card-body invoice-padding py-0">
                                <!-- Invoice Note starts -->
                                <div class="row">
                                    <div class="col-12">

                                    </div>
                                </div>
                                <!-- Invoice Note ends -->
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Add Left ends -->

                    <!-- Invoice Add Right starts -->
                    <div class="col-xl-3 col-md-4 col-12">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-outline-primary w-100">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Invoice Add Right ends -->
                </div>
            </form>

            <!-- Add New Customer Sidebar -->
            <div class="modal modal-slide-in fade" id="add-new-customer-sidebar" aria-hidden="true">
                <div class="modal-dialog sidebar-lg">
                    <div class="modal-content p-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title">
                                <span class="align-middle">Add Customer</span>
                            </h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <form>
                                <div class="mb-1">
                                    <label for="customer-name" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" id="customer-name" placeholder="John Doe"/>
                                </div>
                                <div class="mb-1">
                                    <label for="customer-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="customer-email"
                                           placeholder="example@domain.com"/>
                                </div>
                                <div class="mb-1">
                                    <label for="customer-address" class="form-label">Customer Address</label>
                                    <textarea class="form-control" id="customer-address" cols="2" rows="2"
                                              placeholder="1307 Lady Bug Drive New York"></textarea>
                                </div>
                                <div class="mb-1 position-relative">
                                    <label for="customer-country" class="form-label">Country</label>
                                    <select class="form-select" id="customer-country" name="customer-country">
                                        <option label="select country"></option>
                                        <option value="Australia">Australia</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United States of America">United States of America</option>
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <label for="customer-contact" class="form-label">Contact</label>
                                    <input type="number" class="form-control" id="customer-contact"
                                           placeholder="763-242-9206"/>
                                </div>
                                <div class="mb-1 d-flex flex-wrap mt-2">
                                    <button type="button" class="btn btn-primary me-1" data-bs-dismiss="modal">Add
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Add New Customer Sidebar -->
        </section>

    @endcan

@endsection

@section('scripts')

    <!-- BEGIN: Vendor JS-->
    <script src="{{ url('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ url('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ url('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ url('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <script>

        //   $('.invoice-repeater, .repeater-default, .source-item').repeater({
        //     show: function () {
        //         console.log("wqAdding");
        //       $(this).slideDown();
        //       // Feather Icons
        //       if (feather) {
        //         feather.replace({ width: 14, height: 14 });
        //       }

        //     },

        //   });


        // form repeater jquery
        $('.invoice-repeater, .repeater-default , .source-item').repeater({
            show: function () {
                $(this).slideDown();
                $(this).find('.select_product').select2();
                $(this).find('.select_variation').select2();
                // Feather Icons
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            },
            hide: function (deleteElement) {
                var cnt = $('.repeater-wrapper').length;

                if (cnt < 2) {
                    IsDeleted = false;
                } else {
                    if (confirm('Are you sure you want to delete this element?')) {
                        var $this = $(this);
                        var item_id = $this.find('.delete_item').data('item-id');

                        var invoice_item_id = $this.find('.invoice_item_id').val();

                        if(invoice_item_id != '') {

                            IsDeleted = true;

                            var route = '{{ route('productitem.invoice.item.delete',':item_id') }}';
                            route = route.replace(':item_id', item_id);

                            $.ajax({
                                type: "GET",
                                url: route,
                                data: {item_id: item_id},
                                success: function (response) {
                                    if (response.success) {
                                        $this.slideUp(deleteElement);
                                        setTimeout(() => {
                                            CalcTotal();
                                        }, 500);
                                    }
                                }
                            });
                        } else {
                            $this.slideUp(deleteElement);
                            setTimeout(() => {
                                CalcTotal();
                            }, 500);
                            IsDeleted = false;
                        }

                    } else {
                        IsDeleted = false;
                    }
                }
            }
        });

        // ==============================================================================
        var IsDeleted = false;

        function CalcTotal() {
            var v = 0;
            var tot = 0;

            $('.product_div').each(function () {
                var $this = $(this);
                v = v + 1;

                var ProdQty = $this.find('.product_QTY').val();
                var ProdPrice = $this.find('.product_price').val();

                if (ProdQty) {

                    tot = tot + (ProdQty * ProdPrice);
                }
            });

            var r = NumWithComma(tot);

            $('.wqSubTotal').text(r);
            // $('.wqSubTotal').text("PKR " + r);

            return tot;
        }

        function getDefaultPrice(){                                         // To get the default subtotal price
            var product_sections = $('.product_div');
            var subTotal = 0;
            product_sections.each(function (){
                var $this = $(this);
                var price = parseInt($this.find('.product_price').val());
                var quantity = parseInt($this.find('.product_QTY').val());

                if(isNaN(price) == true){
                    price = parseInt(0);
                }
                if(isNaN(quantity) == true){
                    quantity = parseInt(0);
                }
                var single_product_total = quantity * price;
                subTotal += single_product_total;
            });
            subTotal = NumWithComma(subTotal);
            $('.wqSubTotal').html(subTotal);
        }

        function NumWithComma(value) {
            return value.toLocaleString(undefined, {
                maximumFractionDigits: 2
            });
        }

        $(document).ready(function () {
            $(window).on('load', function () {
                if (feather) {
                    feather.replace({
                        width: 14,
                        height: 14
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('input', '.product_QTY', function () {
                var $this = $(this);
                var PQ = $this.val();
                var PrRate = $this.parent().closest('.product_div').find('.product_price');
                CalcTotal();
            });

            $('body').on('input', '.product_price', function() {
               var $this = $(this);
               getDefaultPrice();
            });

            $('body').on('change', '.select_variation', function () {
                var $this = $(this);
                var price = $("option:selected", $this).data('price');

                $this.parent().closest('.product_div').find('.product_price').val(price);

                var Qv = $this.parent().closest('.product_div').find('.product_QTY').val();
                var t = $("option:selected", $this).val();

                CalcTotal();
            });

            $('body').on('change', '.select_product', function () {
                var $this = $(this);
                var product_id = $this.val();
                var type = $("option:selected", $this).data('type');

                if (type == 'fixed') {
                    $this.parent().closest('.product_div').find('.variation_div').addClass('d-none');

                } else {
                    $this.parent().closest('.product_div').find('.variation_div').removeClass('d-none');
                }

                var product_price = $this.parent().closest('.product_div').find('.product_price');
                var route = '{{ route('invoice.get.product.price') }}';

                $.ajax({
                    type: "GET",
                    url: route,
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            var Qf = $this.parent().closest('.product_div').find('.product_QTY').val();
                            var PrRate = $this.parent().closest('.product_div').find('.product_price');

                            PrRate.attr('data-rate', response.price);
                            PrRate.data('rate', response.price);

                            var t = $("option:selected", $this).text();

                            product_price.val(response.price);

                            var qty = $this.parent().closest('.product_div').find('.product_QTY').val();
                            if(qty === '' || qty === undefined){
                                $this.parent().closest('.product_div').find('.product_QTY').val(1);
                            }

                            if(type == 'fixed') {
                                getDefaultPrice();
                            }

                            if (response.type == 'variable') {

                                var product_sections_length = $('.product_div').length;             // To reset subtotal on having only 1 variable product
                                if(product_sections_length == 1){
                                    getDefaultPrice();
                                }

                                var variation_html = "";
                                $.each(response.variations, function (k, v) {
                                    var id = v.id;
                                    var title = v.title;
                                    var price = v.price;
                                    variation_html += "<option value='" + id +
                                        "' data-price='" + price + "'>" +
                                        title + "</option>";
                                });

                                $this.parent().closest('.product_div').find('.variation_div').removeClass('d-none');
                                $this.parent().closest('.product_div').find('.select_variation').html(variation_html);
                                $this.parent().closest('.product_div').find('.select_variation').prepend("<option selected disabled>Select Variation</option>");
                            }

                        }
                    }
                });
            });

            $(document).on('click', '.WQinvoice-product-actions', function () {
                var cnt = $('.repeater-wrapper').length;
                if (IsDeleted) {
                    CalcTotal();
                }
            });


        });

        $(window).on('load', function () {
            $('select').select2();
        });

    </script>
@endsection
