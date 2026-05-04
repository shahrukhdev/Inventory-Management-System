@extends('admin.layouts.master')
@section('title', 'Edit Product Item')
@section('content')

    <section id="basic-input">
        <div class="row">
            <form class="invoice-repeater" id="SubmitForm" action="{{ route('productitem.update', $item->id) }}"
                method="POST">
                @csrf
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Product Item</h4>
                        </div>
                        <div class="card-body">

                            @include('admin.partials.session_msgs')

                            <div class="mb-1">
                                <label class="form-label" for="serialNo">Serial Number</label>
                                <input type="text"
                                    class="form-control"
                                    placeholder="Serial Number" name="serial_no" id="serialNo"
                                    value="{{ old('serial_no') ?? $item->serial_no }}" aria-label="Serial Number"
                                    aria-describedby="basic-addon1" />
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="productCode">Product Code</label>
                                <input type="text"
                                    class="form-control"
                                    placeholder="Product Code" name="product_code" id="productCode"
                                    value="{{ old('product_code') ?? $item->product_code }}"
                                    aria-label="Product Code" aria-describedby="basic-addon1" />
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="products">Products</label>
                                <select class="form-select item-details select_product @error('product_id') is-invalid @enderror" name="product_id" id="products" required>
                                    <option selected disabled>Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}
                                            data-type="{{ $product->type }}"
                                            data-variation_id="{{ $item->variation_id }}"
                                            data-isdefault= {{ $item->product_id == $product->id ? 'YES' : 'NO' }}
                                            >
                                            {{ $product->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                                    <div class="variation_div d-none">
                                        <label class="form-label" for="variation">Variation</label>
                                        <select class="form-select item-details select_variation" name="variation_id" id="variation">

                                            @foreach ($item->product->variations as $variation)
                                                <option value="{{ $variation->id }}"
                                                    data-price="{{$variation->price}}"
                                                    {{ $variation->id == $item->variation_id ? 'selected' : '' }}>
                                                    {{$variation->title}}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                            <div class="mt-1">
                                <label class="form-label" for="price">Price</label>
                                <input type="number"
                                    class="form-control product_price @error('price') is-invalid @enderror"
                                    placeholder="Price" name="price" id="price"
                                    value="{{ old('price') ?? $item->price }}"
                                    aria-label="Price" aria-describedby="basic-addon1" required/>
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn btn-primary mt-3" type="submit" id="save_btn">Save</button>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

@endsection


@section('scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ url('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ url('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ url('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ url('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ url('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->


    <script>
        $(document).ready(function() {

            $('body').on('change', '.select_variation', function() {
                var $this = $(this);
                var price = $("option:selected", $this).data('price');
                price = parseInt(price);
                $this.parent().closest('.card-body').find('.product_price').val(price);
            });

            $('body').on('change', '.select_product', function() {
                var $this = $(this);
                var product_id = $this.val();
                var type = $("option:selected", $this).data('type');
                var variation_id = $("option:selected", $this).data('variation_id');
                var isdefault  = $("option:selected", $this).data('isdefault');

                if (type == 'fixed') {
                    $this.parent().closest('.card-body').find('.variation_div').addClass('d-none');

                } else {
                    $this.parent().closest('.card-body').find('.variation_div').removeClass('d-none');
                }

                var route = '{{ route('invoice.get.product.price') }}';

                $.ajax({
                    type: "GET",
                    url: route,
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {

                            if (response.type == 'variable') {
                                var variation_html = "";
                                $.each(response.variations, function(k, v) {
                                    var id = v.id;
                                    var title = v.title;
                                    var price = v.price;
                                    var selectitem = "";

                                    if(isdefault == "YES" && variation_id == v.id)
                                    {
                                        selectitem = " selected ";
                                    }

                                     variation_html += "<option value='" + id + "'" +
                                     "data-price='" + price +" '" +
                                     selectitem + " >" +
                                     title + "" +
                                         "</option>";
                                });

                                $this.parent().closest('.card-body').find('.select_variation').html(variation_html);

                                var tmp = $(".select_variation option:selected").data('price');
                                tmp = parseInt(tmp);
                                $this.parent().closest('.card-body').find('.product_price').val(tmp);
                            }
                            else
                            {
                                $this.parent().closest('.card-body').find('.product_price').val(response.price);
                            }
                        }
                    }
                });
            });

        });

        $(window).on('load', function (){

            @if($item->product->type == 'variable')
            $('.variation_div').removeClass('d-none');
            @endif

        });

        $(window).on('load', function (){
            $('select').select2();
        });

    </script>

@endsection
