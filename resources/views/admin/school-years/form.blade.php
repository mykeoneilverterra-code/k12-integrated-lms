@extends('layouts.admin')

@php
    $editing = isset(
        $schoolYear
    );
@endphp

@section(
    'title',
    $editing
        ? 'Edit School Year'
        : 'Add School Year'
)

@section(
    'page-title',
    $editing
        ? 'Edit School Year'
        : 'Add School Year'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-7">

        <div class="card form-card">

            <div class="card-body p-4">

                <form
                    method="POST"
                    action="{{
                        $editing
                            ? route(
                                'admin.school-years.update',
                                $schoolYear
                            )
                            : route(
                                'admin.school-years.store'
                            )
                    }}"
                >

                    @csrf

                    @if ($editing)
                        @method('PUT')
                    @endif


                    <div class="mb-3">

                        <label
                            class="form-label required"
                        >
                            School Year
                        </label>

                        <input
                            name="name"
                            class="form-control"
                            placeholder="2026-2027"
                            value="{{
                                old(
                                    'name',
                                    $schoolYear->name
                                    ?? ''
                                )
                            }}"
                        >

                        @error('name')
                            <small
                                class="text-danger"
                            >
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="starts_on"
                                class="form-control"
                                value="{{
                                    old(
                                        'starts_on',
                                        isset($schoolYear)
                                        && $schoolYear
                                            ->starts_on
                                            ? $schoolYear
                                                ->starts_on
                                                ->format(
                                                    'Y-m-d'
                                                )
                                            : ''
                                    )
                                }}"
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                End Date
                            </label>

                            <input
                                type="date"
                                name="ends_on"
                                class="form-control"
                                value="{{
                                    old(
                                        'ends_on',
                                        isset($schoolYear)
                                        && $schoolYear
                                            ->ends_on
                                            ? $schoolYear
                                                ->ends_on
                                                ->format(
                                                    'Y-m-d'
                                                )
                                            : ''
                                    )
                                }}"
                            >

                        </div>

                    </div>


                    <div class="mb-4">

                        <label
                            class="form-label required"
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                        >

                            @foreach (
                                [
                                    'upcoming',
                                    'active',
                                    'closed'
                                ]
                                as $status
                            )

                                <option
                                    value="{{ $status }}"
                                    @selected(
                                        old(
                                            'status',
                                            $schoolYear->status
                                            ?? 'upcoming'
                                        )
                                        === $status
                                    )
                                >
                                    {{
                                        ucfirst(
                                            $status
                                        )
                                    }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <button
                        class="btn btn-primary"
                    >
                        {{
                            $editing
                                ? 'Update'
                                : 'Save'
                        }}
                    </button>

                    <a
                        href="{{
                            route(
                                'admin.school-years.index'
                            )
                        }}"
                        class="btn
                        btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection