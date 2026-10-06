@extends('layouts.admin')

@section('title', 'Teachers')
@section('page-title', 'Teachers')

@section('content')

<div
    class="d-flex
    justify-content-between
    align-items-center
    mb-4"
>

    <form
        class="d-flex gap-2"
        style="max-width:450px"
    >

        <input
            name="search"
            class="form-control"
            placeholder="Search teacher..."
            value="{{
                request('search')
            }}"
        >

        <button
            class="btn
            btn-outline-primary"
        >
            Search
        </button>

    </form>


    <a
        href="{{
            route(
                'admin.teachers.create'
            )
        }}"
        class="btn btn-primary"
    >
        Add Teacher
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
                    Employee No.
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th
                    class="text-end pe-4"
                >
                    Actions
                </th>
            </tr>
        </thead>

        <tbody>

        @foreach ($teachers as $teacher)

            <tr>

                <td class="ps-4">
                    {{
                        $teacher
                        ->employee_number
                    }}
                </td>

                <td class="fw-semibold">
                    {{
                        $teacher
                        ->full_name
                    }}
                </td>

                <td>
                    {{ $teacher->email }}
                </td>

                <td>
                    <span
                        class="badge
                        {{
                            $teacher->status
                            === 'active'
                            ? 'text-bg-success'
                            : 'text-bg-secondary'
                        }}"
                    >
                        {{
                            ucfirst(
                                $teacher
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
                                'admin.teachers.edit',
                                $teacher
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
    {{ $teachers->links() }}
</div>

@endsection