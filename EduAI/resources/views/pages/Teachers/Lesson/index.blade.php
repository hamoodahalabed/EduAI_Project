@extends('layouts.master')

@section('css')
@section('title')
    {{ trans('teacher_courses.Courses List') }}

@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('teacher_courses.Courses List') }}

@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body" >
                <div class="row">
                    @php
                        $counter = 0;

                    @endphp
                    @foreach ($courses as $key => $course)
                        @php
                            $counter++;
                        @endphp
                        @if (Auth::user()->id === $course->teacher_id && $course->published == 'Active')
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <img class="card-img-top"
                                        src="{{ $imag_dir . '/' . $course->time_stamp . $course->title . '/' . $course->images->filename }}"
                                        alt="{{ $course->title }} image"
                                        style="width: 100%; height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            @php
                                                $title_length = mb_strlen($course->title);
                                                $description_length = mb_strlen($course->description);
                                            @endphp
                                            @if ($title_length > 18)
                                                <h5 class="card-title">
                                                    <span
                                                        id="titleShort{{ $key }}">{{ Illuminate\Support\Str::limit($course->title, 18) }}</span>
                                                    <span id="titleFull{{ $key }}"
                                                        style="display: none;">{{ $course->title }}</span>
                                                    <a href="#" onclick="toggleTitle({{ $key }});">...
                                                    </a>
                                                </h5>
                                            @else
                                                <h5 class="card-title">{{ $course->title }}</h5>
                                                <div style="padding-top: 1.858rem; height: 1.858rem; display:block;">
                                                </div>
                                            @endif
                                            <p class="card-text">{{trans('teacher_courses.Description')}}:<br>
                                                <span
                                                    id="descriptionShort{{ $key }}">{{ Illuminate\Support\Str::limit($course->description, 30) }}</span>
                                                <span id="descriptionFull{{ $key }}"
                                                    style="display: none;">{{ $course->description }}</span>
                                                <a href="#" onclick="toggleDescription({{ $key }});">
                                                    @if ($description_length > 30)
                                                        <br>...
                                                    @else
                                                        <br>
                                                        <div
                                                            style="padding-top: 0.95rem; height: 0.95rem; display:block;">
                                                        </div>
                                                    @endif
                                                </a>
                                            </p>
                                            <p class="card-text">{{trans('teacher_courses.Year')}}: {{ $course->year_id }}</p>
                                            <p class="card-text">{{trans('teacher_courses.Departments')}}:</p>
                                            <ul id="departmentsShort{{ $key }}">
                                                <li>{{ $course->Department->first()->Name }}</li>
                                            </ul>
                                            <ul id="departmentsFull{{ $key }}" style="display: none;">
                                                @foreach ($course->Department as $department)
                                                    <li>{{ $department->Name }}</li>
                                                @endforeach
                                            </ul>
                                            @if (count($course->Department) > 1)

                                                <a href="#"
                                                    onclick="toggleDepartments({{ $key }});">...</a>
                                            @else
                                                <div style="padding-top: 0.95rem; height: 0.95rem; display:block;">
                                                </div>
                                            @endif
                                            <br><br>
                                        </div>
                                        <a class="button"
                                            href="{{ route('lesson.editable', $course->id) }}">{{ trans('teacher_courses.View Course') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @if ($counter == 0)
                        <table>
                            <tr>
                                <td class="text-center" colspan="5">{{trans('teacher_courses.No courses found')}}!</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')
<script>
    function toggleTitle(key) {
        var shortTitle = document.getElementById('titleShort' + key);
        var fullTitle = document.getElementById('titleFull' + key);

        if (shortTitle.style.display === 'none') {
            shortTitle.style.display = 'inline';
            fullTitle.style.display = 'none';
        } else {
            shortTitle.style.display = 'none';
            fullTitle.style.display = 'inline';
        }
    }

    function toggleDescription(key) {
        var shortDescription = document.getElementById('descriptionShort' + key);
        var fullDescription = document.getElementById('descriptionFull' + key);

        if (shortDescription.style.display === 'none') {
            shortDescription.style.display = 'inline';
            fullDescription.style.display = 'none';
        } else {
            shortDescription.style.display = 'none';
            fullDescription.style.display = 'inline';
        }
    }

    function toggleDepartments(key) {
        var shortDepartments = document.getElementById('departmentsShort' + key);
        var fullDepartments = document.getElementById('departmentsFull' + key);

        if (shortDepartments.style.display === 'none') {
            shortDepartments.style.display = 'block';
            fullDepartments.style.display = 'none';
        } else {
            shortDepartments.style.display = 'none';
            fullDepartments.style.display = 'block';
        }
    }
</script>
@endsection
