<div class="modal fade" id="delete_item_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('Item.destroy', $item->id) }}" method="post">
            @method('delete')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans('teacher_courses.Delete Book')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{trans('teacher_courses.are you sure delete')}} <span class="text-danger">{{ $item->title }}</span></p>
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <input type="hidden" name="file_name" value="{{ $item->file_name }}">
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('teacher_courses.Close')}}</button>
                        <button type="submit" class="btn btn-danger">{{trans('teacher_courses.ok')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
