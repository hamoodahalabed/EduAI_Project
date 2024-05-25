@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{trans('admin_student.Student_details')}}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
{{trans('admin_student.Student_details')}}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-body">
                        <div class="tab nav-border">
                           
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                     aria-labelledby="home-02-tab">
                                    <table class="table table-striped table-hover" style="text-align:center">
                                        <tbody>
                                        <tr>
                                            <th scope="row">{{trans('admin_student.name')}}</th>
                                            <th scope="row">{{trans('admin_student.email')}}</th>
                                            <th scope="row">{{trans('admin_student.year')}}</th>
                                            <th scope="row">{{trans('admin_student.department')}}</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $Student->name }}</td>
                                            <td>{{$Student->email}}</td>
                                            <td>{{$Student->year->Name}}</td>
                                            <td>{{$Student->department->Name}}</td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                               

            <!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
