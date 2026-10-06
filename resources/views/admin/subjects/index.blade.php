@extends('layouts.admin')

@section('title', 'Subjects')
@section('page-title', 'Subjects')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center mb-4"
>

    <h2 class="page-title">
        Subjects
    </h2>

    <a
        href="{{
            route(
                'admin.subjects.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Subject
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
                <th class="ps-4">Code</th>
                <th>Subject</th>
                <th>Grades</th>
                <th>Status</th>
                <th
                    class="text-end pe-4"
                >
                    Actions
                </th>
            </tr>
        </thead>

        <tbody>

        @foreach ($subjects as $subject)

            <tr>

                <td class="ps-4">
                    {{ $subject->code }}
                </td>

                <td class="fw-semibold">
                    {{ $subject->name }}
                </td>

                <td>
                    {{
                        $subject
                        ->grade_levels_count
                    }}
                </td>

                <td>

                    <span
                        class="badge
                        {{
                            $subject->is_active
                            ? 'text-bg-success'
                            : 'text-bg-secondary'
                        }}"
                    >
                        {{
                            $subject->is_active
                            ? 'Active'
                            : 'Inactive'
                        }}
                    </span>

                </td>

                <td
                    class="text-end pe-4"
                >

                    <a
                        href="{{
                            route(
                                'admin.subjects.edit',
                                $subject
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
    {{ $subjects->links() }}
</div>

@endsection