<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">{{trans('teacher_courses.Add New Section')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('section.store') }}" method="post" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="section_name">{{trans('teacher_courses.Section Name')}}</label>
                        <input type="text" class="form-control" id="section_name" name="name" placeholder="{{trans('teacher_courses.Enter section name')}}">
                        <input type="hidden" name="course_id" value="{{$current_id}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('teacher_courses.Close')}}</button>
                    <button type="submit" class="buttonLe">{{trans('teacher_courses.Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
