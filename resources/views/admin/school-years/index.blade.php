@extends('layouts.admin')

@section(
    'title',
    'School Years'
)

@section(
    'page-title',
    'School Years'
)

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <div>

        <h2 class="page-title">
            School Years
        </h2>

        <p class="text-muted mb-0">
            Manage academic years.
        </p>

    </div>

    <a
        href="{{
            route(
                'admin.school-years.create'
            )
        }}"
        class="btn btn-primary"
    >
        <i class="bi bi-plus-lg"></i>
        Add School Year
    </a>

</div>


<div class="card table-card">

    <div class="table-responsive">

        <table
            class="table
            table-hover
            align-middle"
        >

            <thead>

                <tr>
                    <th class="ps-4">
                        School Year
                    </th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th
                        class="text-end pe-4"
                    >
                        Actions
                    </th>
                </tr>

            </thead>

            <tbody>

            @forelse (
                $schoolYears
                as $schoolYear
            )

                <tr>

                    <td class="ps-4 fw-semibold">
                        {{
                            $schoolYear->name
                        }}
                    </td>

                    <td>
                        {{
                            $schoolYear
                            ->starts_on
                            ?->format('M d, Y')
                            ?? '—'
                        }}
                    </td>

                    <td>
                        {{
                            $schoolYear
                            ->ends_on
                            ?->format('M d, Y')
                            ?? '—'
                        }}
                    </td>

                    <td>

                        <span
                            class="badge
                            status-{{
                                $schoolYear->status
                            }}"
                        >
                            {{
                                ucfirst(
                                    $schoolYear
                                    ->status
                                )
                            }}
                        </span>

                    </td>

                    <td
                        class="text-end pe-4"
                    >

                        <a
                            href="{{
                                route(
                                    'admin.school-years.edit',
                                    $schoolYear
                                )
                            }}"
                            class="btn
                            btn-sm
                            btn-outline-primary"
                        >
                            Edit
                        </a>


                        <form
                            method="POST"
                            action="{{
                                route(
                                    'admin.school-years.destroy',
                                    $schoolYear
                                )
                            }}"
                            class="d-inline"
                            onsubmit="
                                return confirm(
                                    'Delete this school year?'
                                )
                            "
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn
                                btn-sm
                                btn-outline-danger"
                            >
                                Delete
                            </button>

                        </form>

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
                        No school years.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>


<div class="mt-3">
    {{ $schoolYears->links() }}
</div>

@endsection