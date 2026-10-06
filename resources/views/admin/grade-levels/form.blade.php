@extends('layouts.admin')

@php
    $editing =
        isset($gradeLevel);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Grade Level'
        : 'Add Grade Level'
)

@section(
    'page-title',
    $editing
        ? 'Edit Grade Level'
        : 'Add Grade Level'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7">

        <div class="card form-card">

            <div class="card-body p-4">

                <form
                    method="POST"
                    action="{{
                        $editing
                        ? route(
                            'admin.grade-levels.update',
                            $gradeLevel
                        )
                        : route(
                            'admin.grade-levels.store'
                        )
                    }}"
                >

                    @csrf

                    @if ($editing)
                        @method('PUT')
                    @endif


                    <div class="mb-3">

                        <label class="form-label">
                            Grade Name
                        </label>

                        <input
                            name="name"
                            class="form-control"
                            value="{{
                                old(
                                    'name',
                                    $gradeLevel->name
                                    ?? ''
                                )
                            }}"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Level
                        </label>

                        <input
                            type="number"
                            min="1"
                            max="6"
                            name="level"
                            class="form-control"
                            value="{{
                                old(
                                    'level',
                                    $gradeLevel->level
                                    ?? ''
                                )
                            }}"
                        >

                    </div>


                    <input
                        type="hidden"
                        name="education_stage"
                        value="elementary"
                    >


                    @if ($errors->any())

                        <div
                            class="alert alert-danger"
                        >
                            <ul class="mb-0">

                                @foreach (
                                    $errors->all()
                                    as $error
                                )
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                    @endif


                    <button
                        class="btn btn-primary"
                    >
                        Save
                    </button>

                    <a
                        href="{{
                            route(
                                'admin.grade-levels.index'
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