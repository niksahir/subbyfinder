<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Rate Your Completed Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 0;
            margin: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            border-bottom: 1px solid #eee;
        }

        .email-body {
            padding: 30px;
        }

        .email-body h2 {
            color: #333;
        }

        .email-body p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .rating-button {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 20px;
            background-color: #008cba;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="SubbyFinder Logo" width="180" />
        </div>
        <div class="email-body">
            <h2>Rate Your Completed Project</h2>
            <p>
                Hi {{ $record->user->contact_name }},
                <br /><br />
                We hope your project {{ $record->project->project_name ?? $record->project->contact_name }} was
                successfully completed! We'd really appreciate it if you could take a moment to rate your experience.
                Your feedback helps us improve and ensures quality across our platform.
            </p>
            <p style="text-align: center;">
                @if ($userType == 'contractor')
                    <a href="{{ route('contractor.reviews.index') }}" class="rating-button">Leave a Rating</a>
                @else
                    <a href="{{ route('subcontractor.reviews.index') }}" class="rating-button">Leave a Rating</a>
                @endif
            </p>
        </div>
        <div class="email-footer">
            &copy; 2025 SubbyFinder. All rights reserved.
        </div>
    </div>
</body>

</html>
