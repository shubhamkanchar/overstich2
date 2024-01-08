@extends('layouts.app')
@push('styles')
    <style>
        .range-input {
            --range-color: #dee2e7; /* Default color */
            --range-background: linear-gradient(90deg, #dee2e7 0% 0%, #dee2e7 100% 100%); /* Default background color */
            width: 100%;
            margin-top: 10px;
        }

        .range-input::-webkit-slider-thumb {
            background-color: var(--range-color);
        }

        .range-input::-webkit-slider-runnable-track {
            background: var(--range-background);
        }

        /* Rating Star Widgets Style */
        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .rating-stars ul>li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul>li.star>i.fa {
            font-size: 2.5em;
            color: #ccc;
            /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul>li.star.hover>i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul>li.star.selected>i.fa {
            color: #FF912C;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex justify-content-between  bg-white p-3 border shadow mt-2">
            <div class="align-self-center ms-3">
                <span class="fw-semibold fs-5">Ratings & Reviews</span>
            </div>
            <div class="d-flex ms-3 gap-2 me-3">
                <div class="align-self-center">
                    <span class="fs-5 d-block"> {{ ucfirst($product->title) }}</span>
                    <span class="badge bg-success p-2 text-white"> <i class="bi bi-star-fill"></i>{{ '4.2' }}</span>
                    <span class="text-secondary ms-1"> ({{ '112' }}) </span>
                </div>
                <div style="height: 50px;">
                    <img src="{{ asset($product->images->first()->image_path) }}" style="height: 100%"
                        class="img-thumbnail rounded" alt="{{ $product->name }}">
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-5 justify-content-between row-gap-5">
            <div class="col-12 col-md-3 d-none d-md-block">
                <div class="card bg-white">
                    <div class="card-header bg-white">
                        <h3 class="card-title fw-bold">What makes a good review</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mt-0 fw-bold">Have you used this product?</h4>
                                    <p class="fs-5">Your review should be about your experience with the product.</p>
                                </div>
                                <hr>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mt-0 fw-bold">Why review a product?</h4>
                                    <p class="fs-5">Your valuable feedback will help fellow shoppers decide!</p>
                                </div>
                                <hr>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="mt-0 fw-bold">How to review a product?</h4>
                                    <p class="fs-5">Your review should include facts. An honest opinion is always
                                        appreciated. If you
                                        have an issue with the product or service, please contact us from the <a
                                            href="#" class="text-info">help centre.</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div class="card bg-white">
                    <div class="card-header bg-white">
                        <h3 class="card-title fw-bold">Rate This Product</h3>
                        <section class='rating-widget'>
                            <!-- Rating Stars Box -->
                            <div class='rating-stars'>
                                <ul id='stars' class="fs-3">
                                    <li class='star' title='Poor' data-value='1'>
                                        <i class='start-icon bi bi-star'></i>
                                    </li>
                                    <li class='star' title='Fair' data-value='2'>
                                        <i class='start-icon bi bi-star'></i>
                                    </li>
                                    <li class='star' title='Good' data-value='3'>
                                        <i class='start-icon bi bi-star'></i>
                                    </li>
                                    <li class='star' title='Excellent' data-value='4'>
                                        <i class='start-icon bi bi-star'></i>
                                    </li>
                                    <li class='star' title='WOW!!!' data-value='5'>
                                        <i class='start-icon bi bi-star bi-fw'></i>
                                    </li>
                                </ul>
                            </div>
                            <p id="ratingText" class="mt-3 fw-bold"></p>
                        </section>
                    </div>
                    <div class="card-body">
                        <form id="ratingForm" action="{{ route('rating.store', $product->slug) }}" method="post">
                            @csrf
                            <input type="hidden" name="star">
                            <div class="row">
                                <div class="form-group mt-3 col-md-4 col-12">
                                    <label for="fit" class="form-label">FIT</label>
                                    <input type="range" class="form-range range-input" id="fit" name="fit" min="0" max="100" value="0">
                                </div>
                        
                                <div class="form-group mt-3 col-md-4 col-12">
                                    <label for="transparency" class="form-label">TRANSPARENCY</label>
                                    <input type="range" class="form-range range-input" id="transparency" name="transparency" min="0" max="100" value="0">
                                </div>
                        
                                <div class="form-group mt-3 col-md-4 col-12">
                                    <label for="length" class="form-label">LENGTH</label>
                                    <input type="range" class="form-range range-input" id="length" name="length" min="0" max="100" value="0">
                                </div>
                                <div class="form-group col-12 mt-2">
                                    <label for="description" class="form-label fs-5">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Description" style="height: 30vh;"></textarea>
                                </div>
                                <div class="col-12 mt-5">
                                    <button class="btn btn-dark fs-4 px-5 float-end">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        var ratingValue = 0;
        $(function() {
            $('#stars li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10);
                $(this).parent().children('li.star').each(function(e){
                    if (e < onStar) {
                        $(this).find('.start-icon').removeClass('bi-star').addClass('bi-star-fill text-warning');
                    }
                    else {
                        if(ratingValue <= e) {
                            $(this).find('.start-icon').addClass('bi-star').removeClass('bi-star-fill text-warning');
                        }
                    }
                });
                
            }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                    if(ratingValue == 0) {
                        $(this).find('.bi-star-fill').addClass('bi-star').removeClass('bi-star-fill text-warning');
                    }
                });
            });
        
            $('#stars li').on('click', function(){
                var onStar = parseInt($(this).data('value'), 10);
                $(this).parent().children('li.star').each(function(e){
                    if (e < onStar) {
                        $(this).find('.start-icon').removeClass('bi-star').addClass('bi-star-fill text-warning');
                    }
                    else {
                        $(this).find('.start-icon').addClass('bi-star').removeClass('bi-star-fill text-warning');
                    }
                });
    
                ratingValue = onStar;
                $('input[name="star"]').val(ratingValue);
                ratingValue = onStar;
                $('input[name="star"]').val(ratingValue);

                const msg = (ratingValue <= 2) ?
                    "We will improve ourselves. You rated this " + ratingValue + " stars." :
                    "Thanks! You rated this " + ratingValue + " stars.";

                const classToAdd = (ratingValue <= 2) ? "text-danger" : "text-success";
                const classToRemove = (ratingValue <= 2) ? "text-success" : "text-danger";

                $('#ratingText').html("<span>" + msg + "</span>").addClass(classToAdd).removeClass(classToRemove);
                
            });
        
            $('.range-input').on('input', function () {
                var value = $(this).val();
                var color;

                if (value <= 49) {
                    color = 'red';
                } else if (value <= 69) {
                    color = 'blue';
                } else {
                    color = 'green';
                }

                // Apply color to both thumb and track
                $(this).css({
                    '--range-color': color,
                });

                $(this).css({
                    '--range-background': `linear-gradient(90deg, ${color} 0% ${value}%, #dee2e7 ${value}% 100%)`,
                });

                
            });

            $('#ratingForm').validate({
                ignore: [],
                rules: {
                    star: {
                        required: true,
                        min: 1,
                        max: 5,
                    },
                    fit: {
                        required: true,
                        min: 1,
                        max: 100
                    },
                    transparency: {
                        required: true,
                        min: 1,
                        max: 100

                    },
                    length: {
                        required: true,
                        min: 1,
                        max: 100
                    },
                    description: {
                        required: true
                    }
                },
                messages: {
                    star: {
                        required: "Please give a rating.",
                        min: "Please give a rating."
                    },
                    fit: {
                        required: "Please select the fit.",
                        min: "Please select the fit."
                    },
                    transparency: {
                        required: "Please select the transparency.",
                        min: "Please select the transparency."
                    },
                    length: {
                        required: "Please select the length.",
                        min: "Please select the length."
                    },
                    description: {
                        required: "Please enter a description."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "star") {
                        $('#ratingText').html("<span>" + error.text() + "</span>").addClass('text-danger');
                    } else {
                        // Default placement for other fields
                        error.insertAfter(element);
                    }
                    console.log(element, error)
                },
                submitHandler: function(form) {
                    // Form submission logic here
                    form.submit();
                }
            });

        
        });

    </script>
@endsection
