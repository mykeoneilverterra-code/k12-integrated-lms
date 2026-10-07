<div class="card dashboard-card mb-4">

<div class="card-body pb-0">

<h3 class="mb-1">

{{
    $classSubject
        ->section
        ->gradeLevel
        ->name
}}

-

{{
    $classSubject
        ->section
        ->name
}}

</h3>

<p class="text-muted">

{{
    $classSubject
        ->subject
        ->name
}}

</p>


<ul class="nav nav-tabs">

<li class="nav-item">

<a
    href="{{
        route(
            'student.subjects.show',
            $classSubject
        )
    }}"
    class="nav-link {{
        request()->routeIs(
            'student.subjects.show'
        )
        ? 'active'
        : ''
    }}"
>
    Overview
</a>

</li>


@foreach([
    [
        'title' => 'Lessons',
        'route' => 'student.lessons.index',
        'match' => 'student.lessons.*',
    ],
    [
        'title' => 'Assignments',
        'route' => 'student.assignments.index',
        'match' => 'student.assignments.*',
    ],
    [
        'title' => 'Quizzes',
        'route' => 'student.quizzes.index',
        'match' => 'student.quizzes.*',
    ],
] as $tab)

<li class="nav-item">

<a
    href="{{
        route(
            $tab['route'],
            $classSubject
        )
    }}"
    class="nav-link {{
        request()->routeIs(
            $tab['match']
        )
        ? 'active'
        : ''
    }}"
>
    {{ $tab['title'] }}
</a>

</li>

@endforeach

</ul>

</div>

</div>