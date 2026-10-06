@extends('layouts.admin')

@section(
    'title',
    'Edit Curriculum'
)

@section(
    'page-title',
    'Curriculum Blueprint'
)

@section('content')

<div class="row justify-content-center">

    <div class="col-xl-8">

        <div class="card form-card">

            <div class="card-body p-4">

                <h3>
                    {{
                        $gradeLevel->name
                    }}
                </h3>

                <p class="text-muted">
                    Select subjects for
                    this grade level.
                </p>


                <form
                    method="POST"
                    action="{{
                        route(
                            'admin.curriculum.update',
                            $gradeLevel
                        )
                    }}"
                >

                    @csrf
                    @method('PUT')


                    <div class="row">

                    @foreach (
                        $subjects
                        as $subject
                    )

                        <div
                            class="col-md-6 mb-3"
                        >

                            <div
                                class="form-check
                                border
                                rounded
                                p-3
                                ps-5"
                            >

                                <input
                                    type="checkbox"
                                    name="subjects[]"
                                    value="{{
                                        $subject->id
                                    }}"
                                    class="form-check-input"
                                    id="subject_{{
                                        $subject->id
                                    }}"
                                    @checked(
                                        in_array(
                                            $subject->id,
                                            old(
                                                'subjects',
                                                $gradeLevel
                                                ->subjects
                                                ->pluck('id')
                                                ->all()
                                            )
                                        )
                                    )
                                >

                                <label
                                    class="form-check-label"
                                    for="subject_{{
                                        $subject->id
                                    }}"
                                >
                                    <strong>
                                        {{
                                            $subject->name
                                        }}
                                    </strong>

                                    <br>

                                    <small
                                        class="text-muted"
                                    >
                                        {{
                                            $subject->code
                                        }}
                                    </small>
                                </label>

                            </div>

                        </div>

                    @endforeach

                    </div>


                    <button class="btn btn-primary">
                        Save Curriculum
                    </button>

                    <a
                        href="{{
                            route(
                                'admin.curriculum.index'
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