<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Membership Details</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 22px;
            color: #333333;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
        }

        .membership-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .membership-details div {
            margin-bottom: 8px;
        }

        .membership-details strong {
            color: #2c3e50;
        }

        .cta-button {
            display: inline-block;
            background-color: #f77a36;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <h1>Hello {{ $userName }},</h1>

        <p>Thank you for purchasing the <strong>{{ $planName }}</strong> membership. Below are your plan details:
        </p>

        <div class="membership-details">
            <div><strong>Plan Type:</strong> {{ $planType }}</div>
            <div><strong>Price:</strong> AUD{{ $planPrice }}</div>
            <div><strong>Start Date:</strong> {{ $startDate->format('d-m-Y') }}</div>
            <div><strong>End Date:</strong> {{ $endDate->format('d-m-Y') }}</div>

        </div>

        <p>You're now a premium member! Enjoy full access to our exclusive features and content.</p>

        @if ($userType == 'contractor')
            <a href="{{ route('contractor.dashboard.index') }}" class="cta-button">Go to My Dashboard</a>
        @else
            <a href="{{ route('subcontractor.dashboard.index') }}" class="cta-button">Go to My Dashboard</a>
        @endif
    </div>

</body>

</html>
