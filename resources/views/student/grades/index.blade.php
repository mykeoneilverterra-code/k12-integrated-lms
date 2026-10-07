@extends('layouts.student')

@section('title', 'My Grades')
@section('page-title', 'My Grades')

@section('content')

<h2 class="page-title">
    My Grades
</h2>

<p class="text-muted mb-4">

{{
    $enrollment
        ->section
        ->gradeLevel
        ->name
}}

-

{{
    $enrollment
        ->section
        ->name
}}

</p>


<div class="card table-card">

<table class="table table-hover align-middle">

<thead>

<tr>
    <th class="ps-4">Subject</th>
    <th>Q1</th>
    <th>Q2</th>
    <th>Q3</th>
    <th>Q4</th>
</tr>

</thead>

<tbody>

@foreach($subjects as $subject)

@php

$subjectGrades =
    $grades->get(
        $subject->id,
        collect()
    );

@endphp

<tr>

<td class="ps-4 fw-semibold">
    {{ $subject->subject->name }}
</td>

@for($quarter = 1; $quarter <= 4; $quarter++)

@php

$grade =
    $subjectGrades
        ->firstWhere(
            'quarter',
            $quarter
        );

@endphp

<td>

@if($grade)

<strong>
    {{ number_format($grade->grade, 0) }}
</strong>

@else

<span class="text-muted">
    —
</span>

@endif

</td>

@endfor

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection