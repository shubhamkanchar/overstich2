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
                    <a href="{{ route('admin.dashboard') }}" class="accordion-button1" type="button">
                        Dashboard
                    </a>
                </h6>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingUser">
                    <button class="accordion-button @if(Route::is('user.*') ) @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseuser" aria-expanded="false" aria-controls="flush-collapseuser">
                        Users
                    </button>
                </h2>
                <div id="flush-collapseuser" class="accordion-collapse collapse @if(Route::is('user.*') ) show @endif" aria-labelledby="flush-headingUser" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('user.list')}}">View Users</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button @if(Route::is('seller.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeller" aria-expanded="false" aria-controls="flush-collapseSeller">
                        Sellers
                    </button>
                </h2>
                <div id="flush-collapseSeller" class="accordion-collapse collapse @if(Route::is('seller.*') ) show @endif" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('seller.list') }}">View Sellers</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button @if(Request::is('admin.order.*')) @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Orders
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse @if(Request::is('admin.order.*')) show @endif" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('admin.order.list') }}">View Orders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button @if(str_contains(request()->url(), 'admin/product')) @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Products
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse @if(str_contains(request()->url(), 'admin/product')) show @endif" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('admin.product.list') }}">View Product</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                    <button class="accordion-button @if(Route::is('categories.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCategory" aria-expanded="false" aria-controls="flush-collapseCategory">
                        Category
                    </button>
                </h2>
                <div id="flush-collapseCategory" class="accordion-collapse collapse @if(Route::is('categories.*') ) show @endif" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('categories.create') }}">Add Category</a></li>
                            <li><a href="{{ route('categories.index') }}">View Category</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingSix">
                    <button class="accordion-button @if(Route::is('coupon.*') )  @else collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFilter" aria-expanded="false" aria-controls="flush-collapseFilter">
                        Filter
                    </button>
                </h2>
                <div id="flush-collapseFilter" class="accordion-collapse collapse @if(Route::is('filters.*') ) show @endif" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul>
                            <li><a href="{{ route('category.filters.add') }}">Add Filter</a></li>
                            <li><a href="{{ route('category.filters.view') }}">View</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>