@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-9">
            <h3 class="mb-4 text-decoration-underline"><strong>Terms and Conditions</strong></h3>
            <p><strong>Effective Date: 8<sup>th</sup> January 2024</strong></p>
            <p class="mb-4">Welcome to Overstitch. By accessing and using our website, you agree to comply with and be
                bound by the following terms and conditions. Please read these terms carefully before using our
                services
            </p>
            <p>
            <strong>1. Returns and Exchanges:</strong><br/>
            We offer a 7-day return and exchange policy on all eligible products. To be eligible for a return or
            exchange, the product must be in its original, unused condition with all tags and labels attached.
            </p>
            <p>
            <strong>2. Seller Products & Warranty:</strong><br/>
            Our website serves as a platform for fashion sellers to list and sell their products. While we strive
            to ensure the accuracy of product listings, we do not guarantee the quality, authenticity, or
            availability of products sold by third-party sellers. We recommend reviewing seller ratings and
            reviews before making a purchase. If a brand offers a warranty on their products, the consumer
            must contact the brand directly for warranty service. We are not responsible for any warranty
            claims.
            </p>
            <p>
            <strong>3. Order Cancellation and Refunds:</strong><br/>
            In the event that an order is canceled by the seller or if delivery is not possible to your specific
            pincode, a refund will be issued to your original mode of payment. We strive to process refunds
            promptly, however, it may take a 3-4 business days for the refunded amount to reflect in your
            account, depending on the payment method and your financial institution's policies.
            </p>
            <p>
            <strong>4. Product Descriptions:</strong><br/>
            We make every effort to provide accurate product descriptions, images, and sizing information.
            However, variations in colour and appearance may occur due to different display settings. Please
            refer to the product details and consult with the seller for any specific queries.
            </p>
            <p>
            <strong>5. Platform Fee:</strong><br/>
            In addition to the product price and any applicable taxes, a platform fee of Rs.{{ env('PLATFORM_FEE') }} will be added to
            each order. This fee covers the costs associated with maintaining and operating our platform,
            ensuring secure transactions, and providing customer support. The platform fee will be clearly
            displayed at checkout before you complete your purchase.
            </p>
            <p>
            <strong>6. Pricing and Payment:</strong><br/>
            Product prices are set by sellers and may vary. All payments are securely processed through our
            payment gateway. Prices are inclusive of applicable taxes unless stated otherwise.
            </p>
            <p>
            <strong>7. Shipping and Delivery:</strong><br/>
            We strive to ensure timely and accurate delivery of products. Shipping times may vary based on
            location and seller. Any shipping delays or issues will be communicated to you promptly.
            </p>
            <p>
            <strong>8. Intellectual Property:</strong><br/>
            All content on our website, including images, logos, and text, is protected by intellectual property
            rights. Users are prohibited from copying, reproducing, or distributing any content without prior
            consent.
            </p>
            <p>
            <strong>9. Privacy and Data Security:</strong><br/>
            Your privacy is important to us. We collect and process personal data in accordance with our
            Privacy Policy, which you can review here <a href="{{ route('pp') }}">privacy-policy.</a>
            </p>
            <p>
            <strong>10. User Conduct:</strong><br/>
            While using our website, you agree not to engage in any unlawful, abusive, or harmful behaviour.
            Users are responsible for the accuracy and legality of any content they post on our platform.
            </p>
            <p>
            <strong>11. Termination:</strong><br/>
            We reserve the right to terminate user accounts or access to our website for any violation of these
            terms and conditions or for any reason at our discretion.
            </p>
            <p>
            <strong>12. Changes to Terms & conditions:</strong><br/>
            We may update these terms and conditions at any time. By continuing to use our website, you
            agree to be bound by the revised terms
            </p>
        </div>
    </div>
</div>
@endsection