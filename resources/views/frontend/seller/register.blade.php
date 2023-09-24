@extends('layouts.app')
@section('content')
<div class="container">
    <form method="post" action="{{ route('seller.store') }}" class="seller-register" id="registerSeller" enctype="multipart/form-data">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-md-8">
                <h3 class="fs-2">Register As Seller</h3>
                @csrf
                <div class="row">
                    <div class="col-md-6 p-3">
                        <label>GST no.</label>
                        <input class="form-control" type="text" name="gst" value="{{ old('gst') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Brand Name</label>
                        <input class="form-control @error('brand') is-invalid @enderror" type="text" name="brand" value="{{ old('brand') ?? ''}}">
                        @error('brand')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Mail ID</label>
                        <input class="form-control  @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') ?? ''}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 p-3">
                        <label>WhatsApp No.</label>
                        <input class="form-control" type="text" name="whatsapp" value="{{ old('whatsapp') ?? '' }}">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Category</label>
                        <input class="form-control" type="text" name="category" placeholder="Clothing, footwear, jewellery etc.*" value="{{ old('category') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Products</label>
                        <input class="form-control" type="text" name="product" placeholder="Casual Men t-shirts, formal shirts" value="{{ old('product') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" id="password">
                        @error('password') 
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Product price range</label>
                        <input class="form-control" type="text" name="price_range" placeholder="Rs.500 - 1500, Rs.700 - 3000, etc." value="{{ old('price_range') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <label>Upload product photos</label>
                        <input class="form-control" accept="image/*" type="file" name="product_photos[]" placeholder="Minimum 5 photos" multiple>
                        <small>(Note: Please upload file size less than 500KB )</small>
                    </div>
                    <div class="col-md-12 p-3">
                        <label>Pick Up Address</label>
                        <input class="form-control" type="text" name="address_line" placeholder="Plot no, Building, street, Area*" value="{{ old('address_line') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="locality" placeholder="Locality" value="{{ old('locality') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="city" placeholder="City" value="{{ old('city') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="state" placeholder="State" value="{{ old('state') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <input class="form-control" type="text" name="pincode" placeholder="Pincode" value="{{ old('pincode') ?? ''}}">
                    </div>
                    <div class="col-md-12 pt-3 ps-3">
                        <label>Bank A/c Details</label>
                    </div>
                    <div class="col-md-6 p-3">
                        <span>Account No</span>
                        <input class="form-control" type="text" name="account" value="{{ old('account') ?? ''}}">
                    </div>
                    <div class="col-md-6 p-3">
                        <span>IFSC Code</span>
                        <input class="form-control" type="text" name="ifsc" value="{{ old('ifsc') ?? ''}}">
                    </div>
                    <div class="col-md-12 p-3 text-center">
                        <button type="submit" class="btn border fs-2">Submit For Approval</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="guideline1" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>

<div class="modal fade" id="guideline3" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                    <ul>
                        <li class="mt-3">Thank you for considering joining our platform as a seller. Before you proceed with your registration, kindly
                            review and understand the following important guidelines to ensure a smooth and successful partnership:</li>
                        <li class="mt-3"><b class="d-block">1. Exclusive Brand Ownership and Seller Details -</b> Sellers are required to exclusively offer their own branded products on our platform. Reselling of other brands products is strictly prohibited. Your brand details, including brand name, Legal name, address and email ID, will be visible to customers on the platform. This ensures transparency and trust in the products being offered.
                        </li>
                        <li class="mt-3"><b class="d-block">2. Intellectual Property and Trademarks -</b> Sellers must make sure that the products they list
don't violate any intellectual property rights or trademarks owned by others. This includes
confirming the authenticity of the items.
                        </li>
                        <li class="mt-3"><b class="d-block">3. GST Registration - </b> Sellers must have a valid GST registration for their business.
                        </li>
                        <li class="mt-3"><b class="d-block">4. Shipping and Delivery - </b> We handle shipping and delivery of products to customers. Sellers do
not need to worry about shipping and handling. Delhivery courier service is used.
                        </li>
                        <li class="mt-3"><b class="d-block">5. Packaging and Labelling - </b>- All products must be packaged in bags suitable for shipping.
Additionally, each product should have a label sticker with dimensions 6x4 inches, displaying
relevant information.
                        </li>
                        <li class="mt-3"><b class="d-block">6. Pricing Policy - </b>Product selling prices listed on our platform should not exceed the Maximum
Retail Price (M.R.P.) mentioned on the physical product label/tag.
                        </li>
                        <li class="mt-3"><b class="d-block">7. Product Presentation - </b>For clothing items, provide at least 5 high-quality photos of the
product, including images with a model wearing the clothing, size chart, and detailed product
information such as fabric, fit, and occasion. While model images are recommended for other
products to reduce returns, they are not mandatory.
                        </li>
                        <li class="mt-3"><b class="d-block">8. Product Quality and Authenticity - </b>All products listed on our platform must be of high quality
and authentic. This is crucial to maintain customer satisfaction and the platform's reputation.
                        </li>
                    </ul>
                </div>
                <div class="text-center mt-5">
                    <button class="btn btn-default fs-1" data-bs-target="#guideline4" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="guideline4" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                    <ul>
                        <li class="mt-3"><b class="d-block">9. Delivery Charges - </b>Delivery charges will be borne by the seller if the order value is above
Rs.500/-. For orders below this amount, the delivery charge will be paid by the customer.
Delhivery courier service will be used for product deliveries.
                        </li>
                        <li class="mt-3"><b class="d-block">10. Overstitch Commission - </b>Overstitch charges a 5% commission on the sold product amount
(excluding GST of 18%). This fee covers our efforts in creating custom ad posters to boost your
brand's sales on our platform. Rest assured, in the event of no sales, no charges will be incurred.
This makes registering on our platform a risk-free opportunity to give it a try. Furthermore, we take
the responsibility of ensuring the secure delivery of your packages.
                        </li>
                        <li class="mt-3"><b class="d-block">11. Order Misplacement Responsibility - </b>- If the courier company misplaces an order, Overstitch
will refund the amount. But if the customer claims that the product is missing after the package is
delivered to the customer, Overstitch is not responsible for that. This is because when the order
was shipped, the package was sealed and there is no way for the delivery company to tamper
with it. Seller need to refund the total amount.
                        </li>
                        <li class="mt-3"><b class="d-block">12. Return and Exchange Charges - </b>Sellers are responsible for bearing the cost of shipment in any case a customer
                            requests a return or exchange. This policy applies even if the order value is below Rs. 500. To minimise return or

                            exchange requests, it's recommended to provide detailed information such as size chart, material composition, and high-
                            quality photos to ensure customer satisfaction.

                        </li>
                        <li class="mt-3"><b class="d-block">13. Payment Process - </b>We will create an invoice for the seller after the return/exchange period for the specific order has
                            ended. Invoices will be mostly issued between Monday to Friday, excluding holidays. Once the invoice is generated, we
                            will start the payment process to the seller's designated bank account. This payment will be processed within 48 hours
                            after deducting any applicable fees such as 5% commission, GST charges, Delivery charge, Return/exchange charge,
                            Weight discrepancy charge, Payment processing charges.

                        </li>
                        <li class="mt-3"><b class="d-block">14. Payment processing and COD charges -</b> A payment processing charge is a fee charged by
                            the payment processor every time a transaction is done to process credit/debit card, net-banking
                            payments. The amount of the fee varies depending on the payment processor, the type of card
                            used, and the size of the transaction. The average payment processing fee ranges between 1.5%
                            to 3.5%. This charge is applicable on receiving payments as well as refunds.
                            A COD (Cash on Delivery) charge is a fixed fee charged for orders that are paid for in cash upon
                            delivery. The amount of the fee is Rs.40. This charge helps cover the higher delivery cost
                            associated with COD orders.</li>
                        <li class="mt-3"><b class="d-block">15. Weight Discrepancy Responsibility - </b>Sellers are responsible for accurately providing the weight and dimension
                            information of their products to us. In cases where a weight discrepancy issue arises, and additional charges are incurred
                            due to incorrect weight information provided by the seller, the associated penalties and charges must be paid by the
                            seller. It is essential to ensure accurate weight and dimension details to avoid any financial implications arising from
                            discrepancies.
                        </li>
                        <li class="mt-3"><b class="d-block">16. Termination of Partnership - </b>The partnership between the platform and the seller may be terminated in case of
                            violations of guidelines, repeated customer complaints, or other valid reasons. Legal action could also result from such
                            violations.
                        </li>
                        <li class="mt-3"><b class="d-block">17. Product Availability - </b>Sellers should promptly update the platform if a product is out of stock to prevent customers
                            from placing orders for unavailable items.
                        </li>
                    </ul>
                </div>
                <div class="text-center mt-5">
                    <button class="btn btn-default fs-1" data-bs-target="#guideline5" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="bi bi-arrow-down"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="guideline5" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h3 class="text-decoration-underline m-5 text-center"><b>Seller Guidelines</b></h3>

                    <ul>
                        <li class="mt-3"><b class="d-block">18. Order Fulfilment and Responsiveness -</b> Sellers must actively manage their orders and promptly fulfil customer
                            requests within a timeframe of 48 hours, except on Sundays and holidays. In cases where orders are not fulfilled or there
                            is unresponsiveness without any valid reason, it may result in the removal of the seller from our platform and could
                            potentially lead to legal action. If a seller no longer wishes to accept orders from our platform, they have the option to
                            deactivate their seller account.
                        </li>
                        <li class="mt-3"><b class="d-block">19. Boost Sales with Coupon Codes -</b> Sellers, feel free to use your own coupon codes to attract customers and increase
                            sales. If you let us know about any upcoming discounts or sales you're planning, we can also help promote them to
                            maximise your sales potential.
                        </li>
                        <li class="mt-3"><b class="d-block">20. Photos for Ad Poster -</b> To feature your brand in our ad posters, we will ask you to provide us
                            with high-quality photos of your product so that we can edit them to our specifications and use
                            them. You also need to grant us permission to use the photos without any copyright issues. It is
                            not mandatory to provide us with photos of your product for the ad posters. This is a free service,
                            and we understand that you may not have the necessary photos or the time to provide them.</li>
                        <li class="mt-3"><b class="d-block">21. Modification of Guidelines -</b> These guidelines are subject to updates or modifications as needed to adapt to changing
                            circumstances. Sellers will be informed of any changes.</li>
                        <li class="mt-3">Thank you for reviewing and understanding these crucial guidelines before proceeding with your registration. We look
                            forward to a successful partnership with you on our platform.</li>
                        <span class="d-block mt-3">If you have any further Questions or Doubts, please feel free to contact us at</span>
                        <span class="d-block">Mail : overstitch.in@gmail.com</span>
                        <span class="d-block">WhatsApp : +917066856414</span>

                    </ul>
                </div>
                <div class="text-center mt-5">
                    <span class="d-block mt-5"><input type="checkbox" class="checkbox align-middle guideline5 me-1"> I HAVE READ SELLER GUIDELINES</span>
                    <span class="modal2_noti error d-none d-block">Please select checkbox to proceed</span>
                    <button class="btn btn-default fs-1 modal2"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="guideline6" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <span class="d-block mt-2 mb-2">Please note that our website launch is expected in November 2023. Due to this, we may not be
able to respond to your emails as quickly as usual. It may take us up to one month or more to
respond. We apologise for any inconvenience this may cause.
</span>
                        <span class="d-block mt-2 mb-2">Thank you for choosing Overstitch as your platform for selling. We look forward to the opportunity to work
                            with you!</span>
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
</div>
@endsection