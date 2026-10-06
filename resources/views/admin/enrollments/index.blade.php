@extends('layouts.admin')

@section('title', 'Enrollments')
@section('page-title', 'Enrollments')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center mb-4"
>

    <form>

        <select
            name="school_year_id"
            class="form-select"
            onchange="
                this.form.submit()
            "
        >

            @foreach (
                $schoolYears
                as $schoolYear
            )

                <option
                    value="{{
                        $schoolYear->id
                    }}"
                    @selected(
                        $selectedSchoolYearId
                        ==
                        $schoolYear->id
                    )
                >
                    {{
                        $schoolYear->name
                    }}
                </option>

            @endforeach

        </select>

    </form>


    <a
        href="{{
            route(
                'admin.enrollments.create'
            )
        }}"
        class="btn btn-primary"
    >
        Enroll Student
    </a>

</div>


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
    <th>Student</th>
    <th>Grade</th>
    <th>Section</th>
    <th>Status</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>
</thead>

<tbody>

@foreach (
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
            $enrollment
            ->section
            ->gradeLevel
            ->name
        }}
    </td>

    <td>
        {{
            $enrollment
            ->section
            ->name
        }}
    </td>

    <td>
        {{
            ucfirst(
                $enrollment
                ->status
            )
        }}
    </td>

    <td
        class="text-end pe-4"
    >

        <a
            href="{{
                route(
                    'admin.enrollments.edit',
                    $enrollment
                )
            }}"
            class="btn
            btn-sm
            btn-outline-primary"
        >
            Edit
        </a>

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mt-3">
    {{ $enrollments->links() }}
</div>

@endsection