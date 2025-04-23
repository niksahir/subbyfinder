{{-- @extends('layouts.before')
@section('title')
    Subby Finder
@endsection

@section('content') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thank You - Membership</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .thank-you-container {
            background: white;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .thank-you-container h1 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .thank-you-container p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .membership-card {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            text-align: left;
        }

        .membership-card strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        .cta-button {
            display: inline-block;
            background-color: #f77a36;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        .meta-info {
            text-align: left;
            font-size: 0.95rem;
            background: #fefefe;
            border: 1px dashed #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .meta-info div {
            margin-bottom: 6px;
        }
    </style>
</head>

<body>

    <div class="thank-you-container">
        <h1>🎉 Thank You for Your Purchase!</h1>
        <p>Your membership has been successfully activated.</p>

        <div class="membership-card">
            <strong>Membership Plan:</strong> {{ $UserSubscription->plan->name }}<br>
            <strong>Start Date:</strong> {{ $UserSubscription->start_date->toDateString() }}<br>
            <strong>Expiry:</strong> {{ $UserSubscription->end_date->toDateString() }}<br>

        </div>

        <div class="meta-info">
            <div><strong>Order ID:</strong> #{{ $UserSubscription->id }}</div>
            <div><strong>Transaction ID:</strong>{{$UserSubscription->stripe_session_id}}</div>
        </div>

        <p>You’re now a premium member! Enjoy all the benefits and exclusive access.</p>

        @if ($userType == 'contractor')
            <a href="{{ route('contractor.dashboard.index') }}" class="cta-button">Go to My Dashboard</a>
        @else
            <a href="{{ route('subcontractor.dashboard.index') }}" class="cta-button">Go to My Dashboard</a>
        @endif
    </div>

</body>

</html>
{{-- @endsection --}}
