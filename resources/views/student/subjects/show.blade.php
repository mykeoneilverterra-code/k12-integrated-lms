@extends('layouts.student')

@section('title', 'Subject')
@section('page-title', 'Subject')

@section('content')

@include(
    'student.subjects._tabs'
)


<div class="row g-4">

<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{ $lessonCount }}
</h2>

<span class="text-muted">
    Lessons
</span>

</div>

</div>

</div>


<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{ $assignmentCount }}
</h2>

<span class="text-muted">
    Assignments
</span>

</div>

</div>

</div>


<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h2>
    {{ $quizCount }}
</h2>

<span class="text-muted">
    Quizzes
</span>

</div>

</div>

</div>

</div>

@endsection