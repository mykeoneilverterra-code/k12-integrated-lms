@extends('layouts.admin')

@section(
    'title',
    'Class Assignments'
)

@section(
    'page-title',
    'Class Assignments'
)

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <form
        class="d-flex gap-2"
    >

        <select
            name="section_id"
            class="form-select"
            onchange="
                this.form.submit()
            "
        >

            @foreach (
                $sections
                as $section
            )

                <option
                    value="{{
                        $section->id
                    }}"
                    @selected(
                        $selectedSectionId
                        ==
                        $section->id
                    )
                >
                    {{
                        $section
                        ->gradeLevel
                        ->name
                    }}
                    -
                    {{
                        $section->name
                    }}
                </option>

            @endforeach

        </select>

    </form>


    <a
        href="{{
            route(
                'admin.class-assignments.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Assignment
    </a>

</div>


@if ($selectedSectionId)

    @php
        $selectedSection =
            $sections
            ->firstWhere(
                'id',
                $selectedSectionId
            );
    @endphp

    @if ($selectedSection)

        <form
            method="POST"
            action="{{
                route(
                    'admin.class-assignments.generate',
                    $selectedSection
                )
            }}"
            class="mb-4"
        >

            @csrf

            <button
                class="btn
                btn-outline-success"
            >
                <i
                    class="bi
                    bi-magic"
                ></i>

                Generate Subjects from
                Curriculum Blueprint
            </button>

        </form>

    @endif

@endif


<div class="card table-card">

<table
    class="table
    table-hover
    align-middle"
>

<thead>
<tr>
    <th class="ps-4">
        Subject
    </th>
    <th>Teacher</th>
    <th>Section</th>
    <th
        class="text-end pe-4"
    >
        Actions
    </th>
</tr>
</thead>

<tbody>

@forelse (
    $assignments
    as $assignment
)

<tr>

    <td class="ps-4 fw-semibold">
        {{
            $assignment
            ->subject
            ->name
        }}
    </td>

    <td>
        {{
            $assignment
            ->teacher
            ?->full_name
            ?? 'Not assigned'
        }}
    </td>

    <td>
        {{
            $assignment
            ->section
            ->gradeLevel
            ->name
        }}
        -
        {{
            $assignment
            ->section
            ->name
        }}
    </td>

    <td
        class="text-end pe-4"
    >

        <a
            href="{{
                route(
                    'admin.class-assignments.edit',
                    $assignment
                )
            }}"
            class="btn
            btn-sm
            btn-outline-primary"
        >
            Assign Teacher
        </a>

    </td>

</tr>

@empty

<tr>
    <td
        colspan="4"
        class="text-center
        py-5
        text-muted"
    >
        No class subjects yet.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-3">
    {{ $assignments->links() }}
</div>

@endsection