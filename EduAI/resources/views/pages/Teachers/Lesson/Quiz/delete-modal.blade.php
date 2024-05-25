<!-- Delete modal -->
<div class="modal fade" id="deleteModal{{$question->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('teacher_courses.Delete Question')}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{trans('teacher_courses.are you sure question')}}

            </div>
            <div class="modal-footer">
                <!-- Form to submit delete action -->
                <form id="deleteForm{{$question->id}}" action="{{ route('delete.question', ['id' => $question->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-danger"> {{trans('teacher_courses.Delete')}}</button>
                </form>
                <!-- Button to close the modal -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('teacher_courses.Cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    function deleteQuestion(questionId) {
        $('#deleteForm'+questionId).submit();
    }
</script>