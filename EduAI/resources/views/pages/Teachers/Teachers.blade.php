@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{trans('admin_teacher.List_Teachers')}}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_teacher.List_Teachers')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <a href="{{route('Teachers.create')}}" class="button" role="button"
                                   aria-pressed="true">{{ trans('admin_teacher.Add_Teacher') }}</a><br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{trans('admin_teacher.Name_Teacher')}}</th>
                                            <th>{{trans('admin_teacher.Joining_Date')}}</th>
                                            <th>{{trans('admin_teacher.Processes')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        @foreach($Teachers as $Teacher)
                                            <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{$Teacher->Name}}</td>
                                            <td>{{$Teacher->Joining_Date}}</td>
                                            <td>
                                                <div class="dropdown show">
                                                    <a class="button" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{trans('admin_student.Processes')}}                                                        </a>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="{{route('Teachers.edit',$Teacher->id)}}"><i style="color:green" class="fa fa-edit"></i>&nbsp;    {{trans('admin_teacher.edit')}} </a>
                                                        <a class="dropdown-item" data-target="#delete_Teacher{{ $Teacher->id }}" data-toggle="modal" href="#delete_Teacher{{ $Teacher->id  }}"><i style="color: red" class="fa fa-trash"></i>&nbsp;  {{trans('admin_teacher.Deleted_Teacher')}}  </a>
                                                    </div>
                                                </div>
                                            </td>
                                              
                                            </tr>

                                            <div class="modal fade" id="delete_Teacher{{$Teacher->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{route('Teachers.destroy','test')}}" method="post">
                                                        {{method_field('delete')}}
                                                        {{csrf_field()}}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">{{ trans('admin_teacher.Deleted_Teacher') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p> {{ trans('admin_teacher.Deleted_Teacher_tilte') }}</p>
                                                            <input type="hidden" name="id"  value="{{$Teacher->id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{ trans('admin_teacher.Close') }}</button>
                                                                <button type="submit"
                                                                        class="btn btn-danger">{{ trans('admin_teacher.Delete') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
