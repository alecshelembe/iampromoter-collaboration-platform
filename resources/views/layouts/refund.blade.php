@extends('welcome')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-gray-50 rounded-lg shadow-lg mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Refund Policy</h1>
    <p class="text-gray-600 mb-6">
        At Streetking, we value your satisfaction and aim to provide a seamless experience. However, we understand that issues may arise. This policy outlines our approach to refunds, including applicable fees and investigation timelines.
    </p>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Eligibility for Refunds</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-2">
            <li>Errors in payment (e.g., duplicate charges).</li>
            <li>Services or campaigns not delivered as promised, subject to investigation.</li>
            <li>Technical issues on our platform that prevent access to purchased services.</li>
        </ul>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Refund Process</h2>
        <ol class="list-decimal list-inside text-gray-600 space-y-4">
            <li>
                <span class="font-bold">Refund Request Submission:</span> Customers must submit a refund request within 14 days of the transaction date. Requests can be made via our refunds team at 
                <a href="mailto:refunds@streetking.co.za" class="text-blue-600 underline">refunds@streetking.co.za</a>.
            </li>
            <li>
                <span class="font-bold">Investigation Period:</span> Once your request is received, we will review and investigate the issue. Please allow <span class="font-semibold">3-5 business days</span> for the investigation to be completed.
            </li>
            <li>
                <span class="font-bold">Refund Decision:</span> After the investigation, we will notify you of the outcome and process the refund if approved.
            </li>
            <li>
                <span class="font-bold">Processing Time:</span> Refunds typically take <span class="font-semibold">5-10 business days</span> to appear in your account, depending on your bank or payment provider.
            </li>
        </ol>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Applicable Fees</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-2">
            <li>
                A <span class="font-semibold">transaction fee</span> of <span class="font-semibold">[e.g., 5 or 15% of the total amount]</span> may apply to cover administrative costs, unless the issue was caused by an error on our part.
            </li>
            <li>
                Refunds related to canceled campaigns or changes initiated by the customer may also incur cancellation fees.
            </li>
        </ul>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Exclusions</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-2">
            <li>Services or campaigns already completed as per agreement.</li>
            <li>Dissatisfaction due to subjective reasons unrelated to the quality of service.</li>
        </ul>
    </div>

    <div>
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Contact Us</h2>
        <p class="text-gray-600">
            If you have questions about our refund policy or wish to submit a request, please contact us at 
            <a href="mailto:refunds@streetking.co.za" class="text-blue-600 underline">refunds@streetking.co.za</a>.  
        </p>
        <p class="text-gray-600 mt-3">
            We’re here to help and ensure a fair resolution to any issues you may experience.
        </p>
    </div>
</div>
@endsection
