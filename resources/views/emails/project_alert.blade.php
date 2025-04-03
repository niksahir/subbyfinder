<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore our Latest Projects Available!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }

        .header img {
            max-width: 200px;
        }

        .content {
            padding: 20px 0;
        }

        .content h2 {
            color: #333;
            font-size: 20px;
        }

        .project-list {
            list-style: none;
            padding: 0;
        }

        .project-list li {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 5px solid #0073e6;
        }

        .project-list li a {
            text-decoration: none;
            font-size: 18px;
            color: #0073e6;
            font-weight: bold;
        }

        .project-list li p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .view-all {
            text-align: center;
            margin-top: 20px;
        }

        .view-all a {
            background: #0073e6;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
        }

        .view-all a:hover {
            background: #005bb5;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://staging.subbyfinder.com/assets/images/logo.png" alt="Logo">
        </div>

        <div class="content">
            <h2>Hello,</h2>
            <p>Explore our Latest Projects Available, carefully curated to meet your needs. Check them out now!</p>

            <ul class="project-list">
                @foreach ($projects as $project)
                    <li>
                        <a href="{{ route('front.projectdetilslock', $project->id) }}">{{ $project->project_name }}</a>
                        <p><strong>Budget:</strong> ${{ $project->budget }}</p>
                        <p><strong>Category:</strong>
                            @if (!empty($project->expertise_names))
                                @foreach ($project->expertise_names as $expertise)
                                    <span>{{ $expertise }}</span>
                                @endforeach
                            @else
                                <span>{{ implode(', ', (array) $project->trade_category) }}</span>
                            @endif
                        </p>
                        <p><strong>Description:</strong> {{ \Illuminate\Support\Str::limit($project->description, 100) }}</p>
                    </li>
                @endforeach
            </ul>

            <div class="view-all">
                <a href="{{ url('/projects') }}">View All Projects</a>
            </div>
        </div>
    </div>
</body>

</html>
