<div class="card dashboard-card mb-4">

    <div class="card-body pb-0">

        <h3 class="mb-1">

            {{
                $classSubject
                    ->section
                    ->gradeLevel
                    ->name
            }}

            -

            {{
                $classSubject
                    ->section
                    ->name
            }}

        </h3>

        <p class="text-muted">

            {{
                $classSubject
                    ->subject
                    ->name
            }}

        </p>


        <ul class="nav nav-tabs">

            <li class="nav-item">

                <a
                    class="nav-link
                    {{
                        request()
                        ->routeIs(
                            'teacher.classes.show'
                        )
                        ? 'active'
                        : ''
                    }}"
                    href="{{
                        route(
                            'teacher.classes.show',
                            $classSubject
                        )
                    }}"
                >
                    Overview
                </a>

            </li>


            <li class="nav-item">

                <a
                    class="nav-link
                    {{
                        request()
                        ->routeIs(
                            'teacher.classes.students'
                        )
                        ? 'active'
                        : ''
                    }}"
                    href="{{
                        route(
                            'teacher.classes.students',
                            $classSubject
                        )
                    }}"
                >
                    Students
                </a>

            </li>


            @foreach ([
                [
                    'name' => 'Lessons',
                    'route' => 'teacher.lessons.index',
                    'match' => 'teacher.lessons.*'
                ],
                [
                    'name' => 'Assignments',
                    'route' => 'teacher.assignments.index',
                    'match' => 'teacher.assignments.*'
                ],
                [
                    'name' => 'Quizzes',
                    'route' => 'teacher.quizzes.index',
                    'match' => 'teacher.quizzes.*'
                ],
                [
                    'name' => 'Attendance',
                    'route' => 'teacher.attendance.index',
                    'match' => 'teacher.attendance.*'
                ],
                [
                    'name' => 'Grades',
                    'route' => 'teacher.grades.index',
                    'match' => 'teacher.grades.*'
                ],
                [
                    'name' => 'Announcements',
                    'route' => 'teacher.announcements.index',
                    'match' => 'teacher.announcements.*'
                ],
            ] as $tab)

                <li class="nav-item">

                    <a
                        class="nav-link
                        {{
                            request()
                            ->routeIs(
                                $tab['match']
                            )
                            ? 'active'
                            : ''
                        }}"
                        href="{{
                            route(
                                $tab['route'],
                                $classSubject
                            )
                        }}"
                    >
                        {{ $tab['name'] }}
                    </a>

                </li>

            @endforeach

        </ul>

    </div>

</div>