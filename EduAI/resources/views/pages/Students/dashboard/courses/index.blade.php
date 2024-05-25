@extends('layouts.master')

@section('css')
    <style>
        .buttonIn {
            background: #84ba3f;
            padding: 2px 5px;
            font-size: 1rem;
            letter-spacing: 1px;
            border: 0;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: 500;
            display: inline-block;
            border-radius: 3px;
            text-align: center;
            border: 2px solid #84ba3f;
            cursor: pointer;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -ms-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }


    .uniform-dimension {
        width: 300px;  /* or any size you want */
        height: 200px; /* or any size you want */
        object-fit: cover; /* this will ensure that the aspect ratio of the image is maintained */
    }



    </style>
@endsection

@section('title')
{{trans('student_courses.Courses List')}}
@stop

@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('student_courses.Courses List')}}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<!-- row -->
<div class="row">
    <!-- Filter input fields -->
    <div class="row mb-3">
        <div class="col-auto">
            <label for="filterTitle" class="col-form-label">{{trans('student_courses.Filter by Course Title')}}
                :</label>
        </div>
        <div class="col">
            <input type="text" class="form-control" id="filterTitle">
        </div>
    </div>


    <div class="col-md-4 mb-3">
        <label for="filterDepartment" class="form-label">{{trans('student_courses.Filter by Department')}}
            :</label>
        <select class="form-select" id="filterDepartment">
            <option value="">{{trans('student_courses.All Departments')}}
            </option>
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->Name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label for="filterYear" class="form-label">{{trans('student_courses.Filter by Year')}}
            :</label>
        <select class="form-select" id="filterYear">
            <option value="">{{trans('student_courses.All Years')}}
            </option>
            @foreach ($years as $year)
                <option value="{{ $year->id }}">{{ $year->Name }}</option>
            @endforeach
        </select>
    </div>
    @php
    $counter=0;
@endphp
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div id="cardContainer" class="card-body" style="display: flex; flex-wrap: wrap;">
                @foreach ($courses as $key => $course)
                @php
                $counter++;
            @endphp
                    @if ($course->published == 'Active')
                        <div class="card" style="width: 18rem; margin-right: 10px; margin-bottom: 10px;"
                            data-department="{{ implode(',', $course->Department->pluck('id')->toArray()) }}"
                            data-year="{{ $course->year_id }}">
                            <img class="card-img-top uniform-dimension"
                                src="{{ $imag_dir }}/{{ $course->time_stamp }}{{ $course->title }}/{{ $course->images->filename }}"
                                alt="Card image cap">

                            <div class="card-body">
                                @php
                                    $title_length = mb_strlen($course->title);
                                    $description_length = mb_strlen($course->description);
                                @endphp
                                @if ($title_length > 18)
                                    <h5 class="card-title"><span
                                            id="titleShort{{ $key }}">{{ Illuminate\Support\Str::limit($course->title, 18) }}</span><span
                                            id="titleFull{{ $key }}"
                                            style="display: none;">{{ $course->title }}</span> <a href="#"
                                            onclick="toggleTitle({{ $key }});">{{trans('student_courses.Show More')}}
                                        </a></h5>
                                @else
                                    <h5 class="card-title">{{ $course->title }}</h5><div style="padding-top: 1.858rem;height: 1.858rem;display:block">
                                    </div>
                                @endif
                                <p class="card-text">{{trans('student_courses.Description')}}
                                    :<br> <span
                                        id="descriptionShort{{ $key }}">{{ Illuminate\Support\Str::limit($course->description, 30) }}</span><span
                                        id="descriptionFull{{ $key }}"
                                        style="display: none;">{{ $course->description }}</span> <a href="#"
                                        onclick="toggleDescription({{ $key }});">@if ($description_length>30)
                                        <br>Show More
                                           @else
                                           <br> <div style="padding-top: 0.95rem;height: 0.95rem;display:block">
                                        </div>
                                        @endif </a></p>
                                <p class="card-text">{{trans('student_courses.Year')}}: {{ $course->year_id }}</p>
                                <p class="card-text">{{trans('student_courses.Departments')}}:</p>
                                <ul id="departmentsShort{{ $key }}">
                                    <li>{{ $course->Department->first()->Name }}</li>
                                </ul>
                                <ul id="departmentsFull{{ $key }}" style="display: none;">
                                    @foreach ($course->Department as $department)
                                        <li>{{ $department->Name }}</li>
                                    @endforeach
                                </ul>
                                @if (count($course->Department) > 1)
                                    <br>
                                    <a href="#" onclick="toggleDepartments({{ $key }});">{{trans('student_courses.Show More')}}</a>
                                @else


                                        <div style="padding-top: 0.95rem;height: 0.95rem;display:block">
                                        </div>

                                @endif
                                <br>
<div>
                                <a class="button" styel="display:inline" href="{{ route('Courses.show', $course->id) }}">{{trans('student_courses.Show course')}}</a>

                                <a class="button" styel="display:inline"  href="{{ route('Courses.add', $course->id) }}">{{trans('student_courses.Enroll')}}</a>
</div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if ($counter == 0)
                        <table>
                            <tr>
                                <td class="text-center" colspan="5">No courses found!</td>
                            </tr>
                        </table>
                    @endif
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')
<script>
    // JavaScript for filtering by course title, department, and year
    document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('filterTitle').addEventListener('input', filterCourses);
    document.getElementById('filterDepartment').addEventListener('change', filterCourses);
    document.getElementById('filterYear').addEventListener('change', filterCourses);
});
    function filterCourses() {
        var filterTitle = document.getElementById('filterTitle').value.toLowerCase();
        var selectedDepartments = Array.from(document.querySelectorAll('#filterDepartment option:checked')).map(
            option => option.value);
        var selectedYear = document.getElementById('filterYear').value;

        var cards = document.querySelectorAll('#cardContainer .card');
        cards.forEach(function(card) {
            var title = card.querySelector('.card-title').textContent.toLowerCase();
            var departmentIds = card.getAttribute('data-department').split(',');
            var yearId = card.getAttribute('data-year');

            var titleMatch = title.includes(filterTitle);
            var departmentMatch = (selectedDepartments.length === 0 || selectedDepartments.includes('') ||
                selectedDepartments.some(selectedDepartment => departmentIds.includes(selectedDepartment)));
            var yearMatch = (selectedYear === '' || selectedYear === yearId);

            if (titleMatch && departmentMatch && yearMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

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
