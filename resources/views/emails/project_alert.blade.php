<h2>Latest Projects for You!</h2>
<ul>
    @foreach ($projects as $project)
        <li>{{ $project->project_name }} - Budget: {{ $project->budget }}</li>
    @endforeach
</ul>
