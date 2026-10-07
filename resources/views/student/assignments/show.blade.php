@extends('layouts.student')

@section('title', $assignment->title)
@section('page-title', 'Assignment')

@section('content')

@include(
    'student.subjects._tabs'
)


<div class="card dashboard-card">

<div class="card-body p-4">

<h2>
    {{ $assignment->title }}
</h2>

<p>
    <strong>Points:</strong>
    {{ $assignment->total_points }}
</p>

<p>
    <strong>Due:</strong>

    {{
        $assignment
            ->due_at
            ?->format(
                'M d, Y h:i A'
            )
        ?? 'No deadline'
    }}
</p>

<hr>

<p style="white-space: pre-line;">
    {{ $assignment->instructions }}
</p>


@if($assignment->attachment_path)

<a
    href="{{
        asset(
            'storage/' .
            $assignment
                ->attachment_path
        )
    }}"
    target="_blank"
    class="btn btn-outline-primary mb-4"
>
    Open Attachment
</a>

@endif


<hr>

<h4>
    Your Submission
</h4>


@if($submission?->status === 'graded')

<div class="alert alert-success">

<strong>
    Score:
</strong>

{{ $submission->score }}
/
{{ $assignment->total_points }}

<br>

<strong>
    Feedback:
</strong>

{{
    $submission->feedback
    ?: 'No feedback.'
}}

</div>

@else

<form
    method="POST"
    enctype="multipart/form-data"
    action="{{
        route(
            'student.assignments.submit',
            [
                $classSubject,
                $assignment
            ]
        )
    }}"
>

@csrf


<div class="mb-3">

<label class="form-label">
    Upload Work
</label>

<input
    type="file"
    name="file"
    class="form-control"
>

</div>


<div class="mb-3">

<label class="form-label">
    Notes / Answer
</label>

<textarea
    name="notes"
    rows="5"
    class="form-control"
>{{
    old(
        'notes',
        $submission->notes
        ?? ''
    )
}}</textarea>

</div>


<button class="btn btn-primary">

{{
    $submission
    ? 'Resubmit'
    : 'Submit Assignment'
}}

</button>

</form>

@endif

</div>

</div>

@endsection