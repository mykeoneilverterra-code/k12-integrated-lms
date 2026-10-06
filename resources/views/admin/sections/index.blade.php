@extends('layouts.admin')

@section('title', 'Sections')
@section('page-title', 'Sections')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <div>
        <h2 class="page-title">
            Sections
        </h2>
    </div>

    <a
        href="{{
            route(
                'admin.sections.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Section
    </a>

</div>


<form class="mb-4">

    <select
        name="school_year_id"
        class="form-select"
        style="max-width:260px"
        onchange="this.form.submit()"
    >

        @foreach (
            $schoolYears
            as $schoolYear
        )

            <option
                value="{{ $schoolYear->id }}"
                @selected(
                    $selectedSchoolYearId
                    == $schoolYear->id
                )
            >
                {{ $schoolYear->name }}
            </option>

        @endforeach

    </select>

</form>


<div class="card table-card">

    <table
        class="table
        table-hover
        align-middle"
    >

        <thead>
            <tr>
                <th class="ps-4">
                    Section
                </th>
                <th>Grade</th>
                <th>Adviser</th>
                <th>Students</th>
                <th
                    class="text-end pe-4"
                >
                    Actions
                </th>
            </tr>
        </thead>

        <tbody>

        @forelse (
            $sections
            as $section
        )

            <tr>

                <td class="ps-4 fw-semibold">
                    {{ $section->name }}
                </td>

                <td>
                    {{
                        $section
                        ->gradeLevel
                        ->name
                    }}
                </td>

                <td>
                    {{
                        $section->adviser
                        ?->full_name
                        ?? 'Not assigned'
                    }}
                </td>

                <td>
                    {{
                        $section
                        ->enrollments_count
                    }}
                </td>

                <td
                    class="text-end pe-4"
                >

                    <a
                        href="{{
                            route(
                                'admin.sections.edit',
                                $section
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

        @empty

            <tr>
                <td
                    colspan="5"
                    class="text-center
                    py-5
                    text-muted"
                >
                    No sections.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="mt-3">
    {{ $sections->links() }}
</div>

@endsection