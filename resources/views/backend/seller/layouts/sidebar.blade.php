<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('image/logo1.png') }}" style="width:120px">
        </a>
        <button type="button" class="fs-3 text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="bi bi-x-square"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
            <div class="accordion-item">
                <h6 class="accordion-header1 p-3" id="flush-headingOne">
                    <a href="{{ route('seller.dashboard') }}" class="accordion-button1" type="button">
                        Dashboard
                    </a>
                </h6>
            </div>
            @if(auth()->user()->sellerInfo->is_completed && auth()->user()->sellerInfo->is_approved)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button @if(Route::is('seller.products.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseProduct" aria-expanded="false" aria-controls="flush-product">
                        Product
                    </button>
                </h2>
                <div id="flush-collapseProduct" class="accordion-collapse collapse  @if(Route::is('seller.products.*') ) show @endif" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('seller.products.create')}}">Add Product</a></li>
                            <li><a href="{{ route('seller.products.index')}}">View Product</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingfour">
                    <button class="accordion-button @if(Route::is('warehouses.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseWarehouse" aria-expanded="false" aria-controls="flush-collapseWarehouse">
                        Warehouse
                    </button>
                </h2>
                <div id="flush-collapseWarehouse" class="accordion-collapse collapse @if(Route::is('warehouses.*') ) show @endif" aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('seller.warehouse.create') }}">Add Warehouse</a></li>
                            <li><a href="{{ route('seller.warehouses.index') }}">View Warehouse</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button @if(Route::is('seller.order.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Orders
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse @if(Route::is('seller.order.*') ) show @endif" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('seller.order.list') }}">View Orders</a></li>
                            <li><a href="{{ route('seller.order.return') }}">View returned Orders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                    <button class="accordion-button @if(Route::is('coupon.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCoupon" aria-expanded="false" aria-controls="flush-collapseCoupon">
                        Coupon
                    </button>
                </h2>
                <div id="flush-collapseCoupon" class="accordion-collapse collapse @if(Route::is('coupon.*') ) show @endif" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('seller.coupon.create') }}">Add Coupon</a></li>
                            <li><a href="{{ route('seller.coupon.index') }}">View Coupon</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            {{-- <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Products
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">

                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>