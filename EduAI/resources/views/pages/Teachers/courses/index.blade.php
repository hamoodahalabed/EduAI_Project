@extends('layouts.master')
@section('css')
    <!-- Additional CSS to adjust columns for titles and descriptions -->
    <style>
        /* Adjust columns to allow text wrapping */
        th,
        td {
            overflow: hidden;
        }

        /* Allow the titles and descriptions to wrap as paragraphs */
        td:first-child,
        /* Title column */
        td:nth-child(2) {
            /* Description column */
            white-space: normal;
            word-wrap: break-word;
            max-width: 300px;
            /* Adjust as needed */
        }

        /* Resize images */
        td:nth-child(3) img {
            max-width: 100px;
            /* Adjust as needed */
            height: auto;
        }

        /* Show More/Less CSS */
        .more-content {
            display: none;
        }

        .more-link {
            color: rgb(67, 67, 67);
            cursor: pointer;
        }
    </style>
@section('title')
{{trans('teacher_courses.Courses List')}}
@stop
@endsection

@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('teacher_courses.Courses List')}}
@stop
<!-- breadcrumb -->
@endsection

@section('content')
<div class="title d-flex justify-content-between">
    <p>
        <a href="{{ route('courses.create') }}" class="button">{{trans('teacher_courses.Add New')}}
            </a>
    </p>
</div>
<br>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered table-striped table-hover datatable datatable-Location" data-page-length="50" >
                <thead>
                    <tr>
                        <th>{{trans('teacher_courses.Title')}}
                            </th>
                        <th>{{trans('teacher_courses.Description')}}
                            </th>
                        <th>{{trans('teacher_courses.Course Image')}}
                           </th>
                        <th>{{trans('teacher_courses.Published')}}
                            </th>
                        <th>{{trans('teacher_courses.Action')}}
                            </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $key => $course)
                        @if (Auth::user()->id === $course->teacher_id)
                            @php $counter++ @endphp
                            <tr data-entry-id="{{ $course->id }}">
                                <td style="word-wrap: break-word;">
                                    <span class="less-content">{{ substr($course->title, 0, 20) }}</span>
                                    <span class="more-content">{{ substr($course->title, 20) }}</span>
                                    @if (strlen($course->title) > 20)
                                        <span class="more-link">{{trans('teacher_courses.show more')}}
                                            </span>
                                    @endif
                                </td>
                                <td style="word-wrap: break-word; max-width: 300px;">
                                    <span class="less-content">{{ substr($course->description, 0, 70) }}</span>
                                    <span class="more-content">{{ substr($course->description, 70) }}</span>
                                    @if (strlen($course->description) > 70)
                                        <span class="more-link">{{trans('teacher_courses.show more')}} </span>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{ $imag_dir . '/' . $course->time_stamp . $course->title . '/' . $course->images->filename }}"
                                        alt="Course Image" width="150" />
                                </td>
                                <td>{{ $course->published }}</td>
                                <td>
                                    <a class="button"
                                        href="{{ route('courses.edit', $course->id) }}">{{trans('teacher_courses.Edit2')}}</a>
                                    <button type="button" class="button-trash" data-toggle="modal"
                                        data-target="#delete_Course{{ $course->id }}">
                                        {{trans('teacher_courses.Delete')}}
                                    </button>
                                    <div class="modal fade" id="delete_Course{{ $course->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{trans('teacher_courses.Delete Course')}}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{trans('teacher_courses.are you sure')}}</p>
                                                        <input type="hidden" name="id"
                                                            value="{{ $course->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{trans('teacher_courses.Cancel')}}</button>
                                                        <button type="submit" class="btn btn-danger">{{trans('teacher_courses.Delete')}}</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($counter == 0)
                        <tr>
                            <td class="text-center" colspan="5">{{trans('teacher_courses.No courses found')}}!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br><br>
        </div>

    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.more-link').on('click', function() {
            var $this = $(this);
            var $content = $this.prev('.more-content');
            if ($this.text() === '...Show More') {
                $content.show();
                $this.text('...Show Less');
            } else {
                $content.hide();
                $this.text('...Show More');
            }
        });
    });
    
</script>
@endsection
