@extends('layouts.app')
@push('styles')
    <style>
        .img-container {
            float: left;
            width: 100%;
            height: 100% !important;
            object-fit: cover;
            background-repeat: no-repeat;
        }

        input[name="search"]:focus {
            box-shadow: none !important;
            border-color: #000 !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--bs-accordion-active-color);
            background-color: var(--bs-accordion-active-bg);
            box-shadow: none;
        }

        .accordion-button:focus {
            z-index: 3;
            border-color: var(--bs-accordion-btn-focus-border-color);
            outline: 0;
            box-shadow: none;
        }

        .translate-y-up:hover {
            transform: translateY(-0.5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .clear-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
        }

        .clear-icon:hover {
            color: #000;
        }

        .image-height {
            height: 250px;
        }

        @media (max-width: 575.98px) {
            .filters {
                position: absolute;
                top: 15%;
                right: auto;
                z-index: 999;
            }

            .image-height {
                height: 25vh;
            }

        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-5">
                    <li class="breadcrumb-item "><a class="text-decoration-none text-dark" href="{{ url('/') }}">Home</a>
                    </li>
                    
                    @if ($category->masterCategory)
                        <li class="breadcrumb-item"><a
                                href="{{ route('products.index', $category->masterCategory->id) }}">{{ $category->masterCategory->category }}</a>
                        </li>
                    @endif
                    @if ($category->parentSubCategory)
                        <li class="breadcrumb-item"><a
                                href="{{ route('products.index', $category->parentSubCategory->id) }}">{{ $category->parentSubCategory->category }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->category }}</li>
                    
                </ol>
            </nav>
        </div>
        <form action="{{ route('products.index', $category->id ?? '') }}" id="productForm" method="get">
            <div class="row mb-5 justify-content-between row-gap-5">
                <div class="col-md-3 col-12 filters d-none d-md-block">
                    <div class="card bg-white">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between position-relative" role="button">
                                <div class="card-title">
                                    <h4>Filters</h4>
                                </div>

                                @if ((count($filters) + count($selectedBrands) + count($selectedSizes)) > 0)
                                    <span class="clear-filter-icon d-none d-md-block fs-5 text-primary"
                                        onclick="clearFilters()">
                                        Clear All
                                    </span>
                                @endif
                                <span class="close-filter-icon d-block d-md-none fs-4 text-dark">
                                    <i class="bi bi-x"></i>
                                </span>
                            </div>
                        </div>
                        <div class="accordion m-2" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBrand" aria-expanded="false" aria-controls="collapseBrand">
                                        Brands
                                    </button>
                                </h2>
                                <div id="collapseBrand" class="accordion-collapse collapse" data-bs-parent="#collapseBrand">
                                    <div class="accordion-body">
                                        @foreach ($brands as $brandId => $brand) 
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" multiple type="checkbox" name="brand[{{ $brandId }}]" @checked(isset($selectedBrands[$brandId])) value="{{ $brandId }}">
                                                <label class="form-check-label" for="newOrder">
                                                    {{ $brand }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSize" aria-expanded="false" aria-controls="collapseSize">
                                        Size
                                    </button>
                                </h2>
                                <div id="collapseSize" class="accordion-collapse collapse" data-bs-parent="#collapseSize">
                                    <div class="accordion-body">

                                        @foreach ($sizes as $sizeId => $size) 
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" multiple type="checkbox" name="size[{{ $sizeId }}]" @checked(isset($selectedSizes[$sizeId])) value="{{ $size }}">
                                                <label class="form-check-label" for="newOrder">
                                                    {{ $size }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @foreach ($categoryFilters as $filter)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $filter->id }}" aria-expanded="false"
                                            aria-controls="collapse{{ $filter->id }}">
                                            {{ $filter->type }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $filter->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @php $currentFilters = isset($filters[$filter->type]) ? $filters[$filter->type] : [] ; @endphp
                                            @foreach (json_decode($filter->value) as $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" multiple type="checkbox"
                                                        @checked(!empty($currentFilters) && isset($currentFilters[$value]))
                                                        name="{{ $filter->type }}[{{ $value }}]"
                                                        value="{{ $value }}">
                                                    <label class="form-check-label" for="newOrder">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-dark ml-2 w-100" style="border-radius: 0%">Apply
                                Filters</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 all-product">
                    @if (count($products) == 0)
                        <h1 class="fw-bold ms-md-4 text-center text-md-start">Product</h1>
                        <p class="ms-md-5 fs-md-3 text-center text-md-start">No Product Found</p>
                        <div class="mb-3 d-flex align-items-center justify-content-between translate-y-up">
                            <div class="col-md-10 col-8 position-relative">
                                <input type="text" name="search" value="{{ $search }}" class="form-control"
                                    placeholder="Search Your Product Here" style="border-radius: 0%">
                                @if (!empty($search))
                                    <span class="clear-icon fs-4" onclick="clearSearch()">
                                        <i class="bi bi-x"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-2">
                                <button type="submit" class="btn btn-dark ml-2 w-100"
                                    style="border-radius: 0%">Search</button>
                            </div>
                            <div class="col-md-2 col-2">
                                <span class="d-md-none ms-4 bi bi-filter fs-3 show-filter"></span>
                            </div>
                        </div>
                    @else
                        <div class="mb-3 d-flex align-items-center justify-content-between translate-y-up">
                            <div class="col-md-10 col-8 position-relative">
                                <input type="text" name="search" value="{{ $search }}" class="form-control"
                                    placeholder="Search Your Product Here" style="border-radius: 0%">
                                @if (!empty($search))
                                    <span class="clear-icon fs-4" onclick="clearSearch()">
                                        <i class="bi bi-x"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-2">
                                <button type="submit" class="btn btn-dark ml-2 w-100"
                                    style="border-radius: 0%">Search</button>
                            </div>
                            <div class="col-md-2 col-2">
                                <span class="d-md-none ms-4 bi bi-filter fs-3 show-filter"></span>
                            </div>
                        </div>
                        <div class="row justify-content-md-start justify-content-around">
                            @foreach ($products as $product)
                                <div class="col-xl-3 col-lg-3 col-md-4 col-5 p-0 p-lg-2 p-md-2 text-sm">
                                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                                        <div class="card rounded mb-5 translate-y-up">
                                            <img class="aspect-img"
                                                src="{{ asset($product->images->first()->image_path) }}" alt=""
                                                srcset="">
                                            <div class="card-body">
                                                <span class=""><b>{{ ucfirst($product->brand) }}</b></span>
                                                <i class="bi  @if (in_array($product->id, $productIds)) bi-heart-fill text-danger @else bi-heart @endif float-end add-to-wishlist"
                                                    data-add-route="{{ route('wishlist.add-wishlist', $product->id) }}"
                                                    data-remove-route="{{ route('wishlist.remove-wishlist', $product->id) }}"></i>
                                                <span class=" d-block"> {{ ucfirst(mb_strimwidth($product->title, 0, 15, "...")) }}</span>

                                                @php $discountedPrice = $product->price - ($product->price * ($product->discount / 100));@endphp
                                                <span>
                                                    <strong><i
                                                            class="bi bi-currency-rupee"></i>{{ round($discountedPrice) }}
                                                    </strong>
                                                </span>
                                                <small>
                                                    <strike><i
                                                            class="bi bi-currency-rupee"></i>{{ round($product->price) }}</strike>
                                                </small>
                                                <small class="text-danger">({{ $product->discount }}% OFF)</small>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>
        function clearFilters() {
            document.querySelectorAll('#productForm input[type="checkbox"]').forEach(checkbox => checkbox.checked = false);
            document.getElementById('productForm').submit();
        }

        function clearSearch() {
            document.querySelector('input[name="search"]').value = '';
            document.getElementById('productForm').submit();
        }

        document.querySelector('.show-filter').addEventListener('click', function() {
            document.querySelector('.filters').classList.remove('d-none');
            document.querySelector('.all-product').classList.add('d-none');
        });

        document.querySelector('.close-filter-icon').addEventListener('click', function() {
            document.querySelector('.filters').classList.add('d-none');
            document.querySelector('.all-product').classList.remove('d-none');
        });
    </script>
@endsection
