@extends('layouts.app')
@section('content')
    <div class="container">
        <form method="post" action="{{ route('seller.store') }}" class="seller-register" id="registerSeller"
            enctype="multipart/form-data">
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-md-8">
                    <h3 class="fs-2">Register As Seller</h3>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <label>Owner Name</label>
                            <input class="form-control" type="text" name="owner_name" value="{{ old('owner_name') ?? '' }}"
                                placeholder="Owner Name" required>
                            @error('owner_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Owner contact number</label>
                            <input class="form-control" type="text" name="owner_contact" value="{{ old('owner_contact') ?? '' }}"
                                placeholder="Owner Contact Number" required>
                                @error('owner_contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>GST no.</label>
                            <input class="form-control" type="text" name="gst" value="{{ old('gst') ?? '' }}"
                                placeholder="GST Number" required>
                                @error('gst')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 p-3">
                            <label>Brand Name</label>
                            <input class="form-control @error('brand') is-invalid @enderror" type="text" name="brand"
                                value="{{ old('brand') ?? '' }}" placeholder="Brand Name" required>
                            @error('brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Organization Name</label>
                            <input class="form-control" type="text" name="organization_name" value="{{ old('organization_name') ?? '' }}"
                                placeholder="Orgnization Name" required>
                                @error('organization_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Organization mail ID</label>
                            <input class="form-control  @error('email') is-invalid @enderror" type="email" name="email"
                                value="{{ old('email') ?? '' }}" placeholder="MAIL ID" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Organization WhatsApp no.</label>
                            <input class="form-control" type="text" name="whatsapp" value="{{ old('whatsapp') ?? '' }}"
                                placeholder="WhatsApp Number" required>
                                @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 p-3">
                            <label>Password</label>
                            <input class="form-control password @error('password') is-invalid @enderror" type="password"
                                name="password" placeholder="Password" id="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Confirm Password</label>
                            <input class="form-control password" type="password" name="password_confirmation"
                                placeholder="Confirm Password" required>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input password-show" type="checkbox" id="check1" name="option1">
                                <label class="form-check-label">Show Password</label>
                            </div>
                        </div>
                        {{-- <div class="col-md-12 pt-3 ps-3">
                            <h5 class="text-decoration-underline">Product Details</h5>
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Products</label>
                            <input class="form-control" type="text" name="product"
                                placeholder="Casual Men t-shirts, formal shirts" value="{{ old('product') ?? '' }}" required>
                                @error('product')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Category</label>
                            <input class="form-control" type="text" name="category" placeholder="Clothing, footwear, jewellery etc.*" value="{{ old('category') ?? '' }}" required>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 p-3">
                            <label>Product price range</label>
                            <input class="form-control" type="text" name="price_range"
                                placeholder="Rs.500 - 1500, Rs.700 - 3000, etc." value="{{ old('price_range') ?? '' }}"
                                required>
                                @error('price_range')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Upload product photos</label>
                            <input class="form-control" accept="image/*" type="file" name="product_photos[]"
                                placeholder="Minimum 5 photos" multiple>
                            @error('product_photos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}
                        <div class="col-md-12 pt-3 ps-3">
                            <h5 class="text-decoration-underline">Document</h5>
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Upload GST Document</label>
                            <input class="form-control" type="file" name="gst_doc" placeholder="GST Document" required>
                            @error('gst_doc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Upload Brand Trademark/NOC document (Optional)</label>
                            <input class="form-control" type="file" name="noc_doc" placeholder="Trademark/NOC document">
                            @error('noc_doc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-12 pt-3 ps-3">
                            <h5 class="text-decoration-underline">Pick Up Address</h5>
                        </div>
                        <div class="col-md-12 p-3">
                            <input class="form-control" type="text" name="address_line"
                                placeholder="Plot no, Building, street, Area*" value="{{ old('address_line') ?? '' }}"  required>
                            @error('address_line')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <input class="form-control" type="text" name="locality" placeholder="Locality"
                                value="{{ old('locality') ?? '' }}" required>
                                @error('locality')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <input class="form-control" type="text" name="city" placeholder="City"
                                value="{{ old('city') ?? '' }}" required>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <input class="form-control" type="text" name="state" placeholder="State"
                                value="{{ old('state') ?? '' }}" required>
                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <input class="form-control" type="text" name="pincode" placeholder="Pincode"
                                value="{{ old('pincode') ?? '' }}" required>
                                @error('pincode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12 pt-3 ps-3">
                            <h5 class="text-decoration-underline">Bank A/c Details</h5>
                        </div>
                        <div class="col-md-6 p-3">
                            <span>Account Holder Name</span>
                            <input class="form-control" type="text" name="account_holder_name"
                                value="{{ old('account') ?? '' }}" placeholder="Account Holder Name" required>
                                @error('account_holder_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <span>Account No</span>
                            <input class="form-control" type="text" name="account"
                                value="{{ old('account') ?? '' }}" placeholder="Account Number" required>
                                @error('account')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <span>Bank Name</span>
                            <input class="form-control" type="text" name="bank_name"
                                value="{{ old('bank_name') ?? '' }}" placeholder="Bank Name" required>
                                @error('bank_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <span>IFSC Code</span>
                            <input class="form-control" type="text" name="ifsc" value="{{ old('ifsc') ?? '' }}"
                                placeholder="IFSC Code"required>
                                @error('ifsc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 p-3">
                            <span>Account Type</span>
                            <select class="form-select" name="account_type" id="accountType" required>
                                <option value="Saving">Saving</option>
                                <option value="Current">Current</option>
                            </select>
                        </div>
                        <div class="col-md-6 p-3">
                            <label>Upload Cancelled cheque</label>
                            <input class="form-control" type="file" name="cancel_cheque" placeholder="Cancel Cheque" required>
                            @error('cancel_cheque')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 p-3 text-center">
                            <button type="submit" class="btn border fs-2">Submit For Approval</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($errors->isEmpty() && empty($formSubmit))
            <input type="hidden" id="guidelinesBackend" value="0">
        @else
            <input type="hidden" id="guidelinesBackend" value="1">
        @endif
    </div>

    {{-- <div class="modal fade" id="guideline1" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>How It Benefits You As Seller?</b></h3>

                    <ul>
                        <li class="mt-3"><b>1. Enhanced Visibility :</b> Our Fashion E-commerce Platform ensures all brands receive equal exposure, letting smaller businesses shine alongside larger ones, and attracting customers looking for something special.
                        </li>
                        <li class="mt-3"><b>2. Social Media Boost :</b> Utilising our Instagram presence, we create attractive ad posters and graphics, Might promoting your brand and products to a broader audience. This not only benefits you as a seller but also helps customers explore the wide range of products from different brands.
                        </li>
                        <li class="mt-3"><b>3. Targeted Reach :</b> With strategic marketing tactics, we ensure that your products are presented to the right customers, increasing the likelihood of meaningful sales.
                        </li>
                        <li class="mt-3"><b>4. Shipping and Delivery :</b> We handle shipping and delivery of products to customers. Sellers do not need to worry about shipping and handling.
                        </li>
                        <li class="mt-3"><b>5. FREE Early Access Advantage:</b> For a limited time, early registration might rewards you with premium homepage placement at no extra cost, capturing valuable attention and potentially boosting Sales & Brand Value.
                        </li>
                        <li class="mt-3"><b>6. Zero-Risk Entry :</b> Sellers enjoy FREE registration, eliminating upfront expenses and simplifying the process of starting your selling journey.
                        </li>
                        <li class="mt-3"><b>7. Promotional Support :</b> Enjoy FREE Advertisement creation during your discounts or sales. These ads will might appear on our Social Media and Platform Homepage, benefiting both sellers and customers. This ensures your special offers reach a wider audience, helping buyers discover great deals.
                        </li>
                    </ul>
                </div>
                <div class="text-center fs-1">
                    <button class="btn btn-default fs-1" data-bs-target="#guideline2" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="guideline2" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>Order-to-Delivery Process</b></h3>

                    <ul>
                        <li class="mt-3"><b class="d-block">1. Order Placement</b>
                            <span class="d-block">The customer places an order on the website.</span>
                            <span class="d-block">The order is received and processed by our system.</span>
                            <span class="d-block">The order details are displayed on seller's dashboards.</span>
                        </li>
                        <li class="mt-3"><b class="d-block">2. Information Processing</b>
                            <span class="d-block">The seller verifies the order details and confirms the availability of the products.</span>
                            <span class="d-block">The seller prepares the package for shipping.</span>
                            <span class="d-block">The seller weighs and measures the package and provides us with the details via WhatsApp.</span>
                            <span class="d-block">We generate a shipping label and send it to the seller via WhatsApp.</span>
                        </li>
                        <li class="mt-3"><b class="d-block">3. Order Preparation</b>
                            <span class="d-block">The seller affixes the shipping label to the package.</span>
                            <span class="d-block">We arrange for a pickup of the package from the seller's address.</span>
                        </li>
                        <li class="mt-3 mb-5"><b class="d-block">4. Order Delivery</b>
                            <span class="d-block">The package is picked up by the shipping carrier.</span>
                            <span class="d-block">The package is delivered to the customer.</span>
                        </li>
                    </ul>
                </div>
                <div class="text-center mt-5">
                    <span class="d-block mt-5">
                        <input type="checkbox" class="checkbox align-middle guideline2 me-1">I HAVE READ ORDER-TO-DELIVERY PROCESS
                    </span>
                    <span class="modal1_noti error d-none d-block">Please select checkbox to proceed</span>
                    <button class="btn btn-default fs-1 modal1"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class="modal fade" id="guideline3" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div>
                        <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                        <ul>
                            <li class="mt-3">Thank you for considering joining our platform as a seller. Before you
                                proceed with your registration, kindly
                                review and understand the following important guidelines to ensure a smooth and successful
                                partnership:</li>
                            <li class="mt-3"><b class="d-block">1. Exclusive Brand Ownership and Seller Details -</b>
                                Sellers are required to exclusively offer their own branded products on our platform.
                                Reselling of other brands products is strictly prohibited. Your brand details including
                                brand name, Legal name and address, will be visible to customers on the platform. This
                                ensures transparency and trust in the products being offered.
                            </li>
                            {{-- <li class="mt-3"><b class="d-block">2. Trademarks -</b> Sellers must ensure that the
                                products they list do not violate any intellectual property rights or trademarks owned by
                                others. This includes using unauthorised logos, images, or branding on products or in
                                listings.
                                <br />
                                <b class="d-block">2. NOC -</b>Sellers must have a No Objection Certificate (NOC) from the
                                brand owner in order to sell other brand products on overstitch. This NOC is a legal
                                document that gives the seller permission to sell the brand's products.
                            </li> --}}
                            <li class="mt-3"><b class="d-block">2. GST Registration - </b> Sellers must have a valid GST
                                registration for their business.
                            </li>
                            <li class="mt-3"><b class="d-block">3. Shipping and Delivery - </b> We handle shipping and
                                delivery of products to customers. Sellers do not need to worry about shipping and handling.
                                Delhivery courier service is used.
                            </li>
                            <li class="mt-3"><b class="d-block">4. Packaging and Labelling - </b>- All products must be
                                packaged in bags suitable for shipping. Additionally, each product should have a label
                                sticker with dimensions 6x4 inches, displaying relevant information.
                            </li>
                            <li class="mt-3"><b class="d-block">5. Pricing Policy - </b>- Product selling prices listed
                                on our platform should not exceed the Maximum Retail Price (M.R.P.) mentioned on the
                                physical product label/tag.
                            </li>
                            <li class="mt-3"><b class="d-block">6. Product Presentation - </b>For clothing items,
                                provide at least 5 high-quality photos of the product, including images with a model wearing
                                the clothing, size chart, and detailed product information such as fabric, fit, and
                                occasion. While model images are recommended for other products to reduce returns, they are
                                not mandatory.
                            </li>
                            <li class="mt-3"><b class="d-block">7. Delivery Charges - </b>Delivery charges will be borne
                                by the seller. Delhivery courier service will be used for all product deliveries.
                            </li>
                        </ul>
                    </div>
                    <div class="text-center mt-5">
                        <button class="btn btn-default fs-1" data-bs-target="#guideline4" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><i class="bi bi-arrow-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="guideline4" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div>
                        <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                        <ul>
                            <li class="mt-3"><b class="d-block">9. Order Misplacement Responsibility - </b>If the
                                courier company misplaces an order, Overstitch will refund the amount. But if the customer
                                or courier company claims that the product is missing after the package is delivered to the
                                customer, Overstitch is not responsible for that. This is because when the order was
                                shipped, the package was sealed and there is no way for the delivery company to tamper with
                                it.
                            </li>
                            <li class="mt-3"><b class="d-block">10. Shipping & Return/Exchange Charges - </b>Sellers are
                                responsible for bearing the cost of shipment in any case a customer requests a
                                return/exchange or cancels the order. To minimise return or exchange requests, it's
                                recommended to provide detailed information such as size chart, material composition, and
                                high-quality photos to ensure customer satisfaction.
                            </li>
                            <li class="mt-3"><b class="d-block">11. Payment Process - </b> After the conclusion of the
                                return/exchange period for a specific order, an invoice will be generated and issued to the
                                seller. Following the generation of the invoice, the payment process will commence to the
                                seller's designated bank account. The payment will be processed within 4-5 business days,
                                and any applicable fees such as GST charges, shipping charges, return/exchange charges,
                                weight discrepancy charges, and payment processing charges, will be deducted. However, in
                                the event of a customer cancellation for a Cash on Delivery (COD) order, we will issue an
                                invoice to the seller, and the seller is responsible for covering the cost of delivery
                            </li>
                            <li class="mt-3"><b class="d-block">12. Payment processing and COD charges - </b>A payment
                                processing charge is a fee charged by the payment processor every time a transaction is done
                                to process payments. The amount of the fee varies depending on size of the transaction. The
                                average payment processing fee is 1.85% to 2% excluding GST of 18%. This charge is
                                applicable on receiving payments as well as refunds. We use Phonepay as payment
                                gateway.<br />
                                A COD (Cash on Delivery) charge is a fixed fee charged for orders that are paid for in cash
                                upon delivery. The amount of the fee is Rs.40. This charge helps cover the higher delivery
                                cost associated with COD orders.
                            </li>
                            <li class="mt-3"><b class="d-block">13. Weight Discrepancy Responsibility - </b>- Sellers
                                are responsible for accurately providing the weight and dimension information of their
                                products to us. In cases where a weight discrepancy issue arises, and additional charges are
                                incurred due to incorrect weight information provided by the seller, the associated
                                penalties and charges must be paid by the seller. It is essential to ensure accurate weight
                                and dimension details to avoid any financial implications arising from discrepancies.
                            </li>
                            <li class="mt-3"><b class="d-block">14. Termination of Partnership -</b> The partnership
                                between the platform and the seller may be terminated in case of violations of guidelines,
                                repeated customer complaints, or other valid reasons.
                            </li>
                            <li class="mt-3"><b class="d-block">15. Product Availability - </b>Sellers should promptly
                                update the platform if a product is out of stock to prevent customers from placing orders
                                for unavailable items.
                            </li>
                            <li class="mt-3"><b class="d-block">16. Order Fulfilment and Responsiveness - </b>Sellers
                                must actively manage their orders and promptly fulfil customer orders within a timeframe of
                                48 hours, In cases where orders are not fulfilled or there is repeated unresponsiveness
                                without any valid reason, it may result in the removal of the seller from our platform. If a
                                seller no longer wishes to accept orders from our platform, they have the option to
                                deactivate their seller account.
                            </li>

                        </ul>
                    </div>
                    <div class="text-center mt-5">
                        <button class="btn btn-default fs-1" data-bs-target="#guideline5" data-bs-toggle="modal"
                            data-bs-dismiss="modal"><i class="bi bi-arrow-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="guideline5" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div>
                        <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                        <ul>
                            <li class="mt-3"><b class="d-block">17. Boost Sales with Coupon Codes - </b>Create your own
                                coupon codes to attract customers and increase sales.
                            </li>
                            <li class="mt-3"><b class="d-block">18. Modification of Guidelines - </b>These guidelines
                                are subject to updates or modifications as needed to adapt to changing circumstances.
                                Sellers will be informed of any changes.
                            </li>
                            <li class="mt-3">Thank you for reviewing and understanding these crucial guidelines before
                                proceeding with your registration. We look forward to a successful partnership with you on
                                our platform.
                            </li>
                            <span class="d-block mt-3">If you have any further Questions or Doubts, please feel free to
                                contact us at</span>
                            <span class="d-block">Mail : overstitch.in@gmail.com</span>
                            <span class="d-block">WhatsApp : +917066856414</span>

                        </ul>
                    </div>
                    <div class="text-center mt-5">
                        <span class="d-block mt-5"><input type="checkbox" class="checkbox align-middle guideline5 me-1">
                            I HAVE READ SELLER GUIDELINES</span>
                        <span class="modal2_noti error d-none d-block">Please select checkbox to proceed</span>
                        <button class="btn btn-default fs-1 modal2"><i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="guideline6" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>Seller Registration Process</b></h3>

                    <ul>
                        <li class="mt-3 mb-2">To become a seller on Overstitch for FREE, please follow these steps:</li>
                        <ol>
                            <li>Fill out the provided seller registration form.</li>
                            <li>Await verification of your submission.</li>
                            <li>Upon approval of your brand, a confirmation email will be sent to your provided email address.</li>
                        </ol>
                        <span class="d-block mt-2 mb-2">Please note that our website launch is expected in November 2023. Due to this, we may not be able to respond to your emails as quickly as usual. It may take us up to one month or more to respond. We apologise for any inconvenience this may cause.
                        </span>
                        <span class="d-block mt-2 mb-2">Thank you for choosing Overstitch as your platform for selling. We look forward to the opportunity to work with you!</span>
                        </li>
                    </ul>
                </div>
                <div class="text-center mt-5">
                    <span class="d-block mt-5"><input type="checkbox" class="checkbox align-middle guideline6 me-1">I HAVE READ SELLER REGISTRATION PROCESS</span>
                    <span class="modal3_noti error d-none d-block">Please select checkbox to proceed</span>
                    <button class="btn btn-default fs-1 modal3"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
