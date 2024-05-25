
<div class="modal fade" id="EditSectionsPositionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">{{trans('teacher_courses.Edit Sections Position')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Section Name Form -->
                <form id="sectionOrderForm" action="{{ route('Section.updateOrder') }}" method="POST">
                    @csrf
                    <ul class="list-group sortable">
                        @foreach($sections->sortBy('position') as $index => $section)
                        @if($section->course_id==$current_id)
                            <li class="list-group-item" data-section-id="{{ $section->id }}">
                                {{ $section->name }}
                                <input type="hidden" name="section_order[{{ $index }}][id]" value="{{ $section->id }}">
                                <input type="hidden" name="section_order[{{ $index }}][position]" value="{{ $index }}">
                            </li>
                            @endif
                        @endforeach
                    </ul> <br>
                    <button type="submit" class="button">{{trans('teacher_courses.Save Section Order')}}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('teacher_courses.Close')}}</button>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- Include jQuery and jQuery UI Sortable -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Define the saveSectionOrder function -->
    <script>
        $(document).ready(function() {
        // Make sections draggable
        $(".sortable").sortable();

        // Update hidden input fields when the order changes
        $(".sortable").on("sortupdate", function(event, ui) {
            $(".sortable li").each(function(index) {
                $(this).find("input[name='section_order[" + index + "][position]']").val(index);
            });
        });
    });
        // Define the saveSectionOrder function
        function saveSectionOrder() {
            var sectionOrder = [];
            $(".sortable li").each(function(index) {
                sectionOrder.push($(this).attr('data-section-id'));
            });

            // Send the updated section order to the server to save
            $.ajax({
                url: "{{ route('Section.updateOrder') }}",
                method: "POST",
                data: {
                    section_order: sectionOrder,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log("Section order updated successfully");
                    // Close the modal after saving the order
                    $('#EditSectionsPositionModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error("Error updating section order:", error);
                }
            });
        }
    </script>
@endpush

