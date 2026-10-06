@extends('layouts.admin')

@section('title', 'Grade Levels')
@section('page-title', 'Grade Levels')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <div>
        <h2 class="page-title">
            Grade Levels
        </h2>

        <p class="text-muted">
            Elementary Grade 1–6
        </p>
    </div>

    <a
        href="{{
            route(
                'admin.grade-levels.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Grade Level
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
                    Grade
                </th>
                <th>Level</th>
                <th>Sections</th>
                <th>Subjects</th>
                <th
                    class="text-end pe-4"
                >
                    Actions
                </th>
            </tr>

        </thead>

        <tbody>

        @foreach (
            $gradeLevels
            as $gradeLevel
        )

            <tr>

                <td class="ps-4 fw-semibold">
                    {{ $gradeLevel->name }}
                </td>

                <td>
                    {{ $gradeLevel->level }}
                </td>

                <td>
                    {{
                        $gradeLevel
                        ->sections_count
                    }}
                </td>

                <td>
                    {{
                        $gradeLevel
                        ->subjects_count
                    }}
                </td>

                <td
                    class="text-end pe-4"
                >

                    <a
                        href="{{
                            route(
                                'admin.grade-levels.edit',
                                $gradeLevel
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

@endsection