@extends('layouts.admin')

@php
    $editing = isset($subject);
@endphp

@section(
    'title',
    $editing
        ? 'Edit Subject'
        : 'Add Subject'
)

@section(
    'page-title',
    $editing
        ? 'Edit Subject'
        : 'Add Subject'
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
                            'admin.subjects.update',
                            $subject
                        )
                        : route(
                            'admin.subjects.store'
                        )
                    }}"
                >

                    @csrf

                    @if ($editing)
                        @method('PUT')
                    @endif


                    <div class="mb-3">

                        <label class="form-label">
                            Subject Code
                        </label>

                        <input
                            name="code"
                            class="form-control"
                            value="{{
                                old(
                                    'code',
                                    $subject->code
                                    ?? ''
                                )
                            }}"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Subject Name
                        </label>

                        <input
                            name="name"
                            class="form-control"
                            value="{{
                                old(
                                    'name',
                                    $subject->name
                                    ?? ''
                                )
                            }}"
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                        >{{
                            old(
                                'description',
                                $subject
                                ->description
                                ?? ''
                            )
                        }}</textarea>

                    </div>


                    <div class="form-check mb-4">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="form-check-input"
                            id="is_active"
                            @checked(
                                old(
                                    'is_active',
                                    $subject->is_active
                                    ?? true
                                )
                            )
                        >

                        <label
                            class="form-check-label"
                            for="is_active"
                        >
                            Active
                        </label>

                    </div>


                    @if ($errors->any())

                        <div class="alert alert-danger">

                            @foreach (
                                $errors->all()
                                as $error
                            )
                                <div>{{ $error }}</div>
                            @endforeach

                        </div>

                    @endif


                    <button class="btn btn-primary">
                        Save
                    </button>

                    <a
                        href="{{
                            route(
                                'admin.subjects.index'
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