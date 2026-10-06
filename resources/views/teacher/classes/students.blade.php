@extends('layouts.teacher')

@section('title', 'Students')
@section('page-title', 'Students')

@section('content')

@include(
    'teacher.classes._tabs'
)


<div class="card table-card">

<table
    class="table
    table-hover
    align-middle"
>

<thead>

<tr>
    <th class="ps-4">
        Student No.
    </th>
    <th>Name</th>
    <th>Status</th>
</tr>

</thead>

<tbody>

@forelse (
    $enrollments
    as $enrollment
)

<tr>

    <td class="ps-4">
        {{
            $enrollment
            ->student
            ->student_number
        }}
    </td>

    <td class="fw-semibold">
        {{
            $enrollment
            ->student
            ->full_name
        }}
    </td>

    <td>
        {{
            ucfirst(
                $enrollment->status
            )
        }}
    </td>

</tr>

@empty

<tr>

<td
    colspan="3"
    class="text-center
    py-5
    text-muted"
>
    No students enrolled.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>


<div class="mt-3">
    {{ $enrollments->links() }}
</div>

@endsection