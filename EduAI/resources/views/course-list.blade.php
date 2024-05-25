@extends('layouts.master')
@section('css')
<style>
    .button {
        font-size: 0.4rem;
    }

    @media (min-width: 992px) {
        .button {
            font-size: 1rem;
        }
    }
</style>


@section('title')
{{trans('admin_courseList.Course-List')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_courseList.Course-List')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{trans('admin_courseList.Course Name')}}</th>
                            <th>{{trans('admin_courseList.Department(s)')}}</th>
                            <th>{{trans('admin_courseList.Process')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach($Courses as $Course)
                        <tr>
                            <?php $i++; ?>
                            <td>{{ $i }}</td>
                            <td>{{ $Course->title }}</td>
                            <td>
                                @foreach($Course->Department as $department)
                                    {{ $department->Name }} @if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>
                                <!-- Delete button -->
                                <button  type="button" class="button-trash " data-toggle="modal" data-target="#delete_Course{{ $Course->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <div class="modal fade" id="delete_Course{{ $Course->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('courses.delete', $Course->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{trans('admin_courseList.DeleteCourse')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{trans('admin_courseList.title')}}</p>
                                                    <input type="hidden" name="id" value="{{ $Course->id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('admin_courseList.Cancel')}}</button>
                                                    <button type="submit" class="btn btn-danger">{{trans('admin_courseList.Delete')}}</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <!-- Publish/Unpublish button -->
                                <form style="display: inline-block;" action="/course/toggle-publish/{{ $Course->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button style="display: inline-block;" type="submit" class=" {{ $Course->published == 'Active' ? 'button ' : 'button-trash' }}">
                                        {!! $Course->published == 'Active' ? trans('admin_courseList.Published')  : trans('admin_courseList.Unpublished')!!}
                                    </button>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@endsection
