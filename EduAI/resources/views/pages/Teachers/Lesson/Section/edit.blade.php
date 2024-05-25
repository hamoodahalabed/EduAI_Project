<div class="modal fade" id="EditSectionModal_{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">{{trans('teacher_courses.Edit Section')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Section.update',$section->id) }}" method="post" >
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="section_name">{{trans('teacher_courses.Section Name')}}</label>
                        <input type="text" class="form-control" id="section_name" name="name" value="{{ old('name', isset($section) ? $section->name : '') }}">
                        <input type="hidden" name="id" value="{{$section->id}}" class="form-control">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('teacher_courses.Close')}}</button>
                    <button type="submit" class="button">{{trans('teacher_courses.Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


