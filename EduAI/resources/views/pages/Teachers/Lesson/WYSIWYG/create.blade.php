<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>    {{trans('teacher_courses.Add new post')}}
    </title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <h1>{{trans('teacher_courses.Add new post')}}</h1>
                </div>

                <form action="{{ route('WYSIWYG.store', $id) }}" method="POST">
                    @csrf

                    <!-- Title Input -->
                    <div class="form-group">
                        <label for="title">{{trans('teacher_courses.Title')}}</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="Enter post title" required>
                    </div>

                    <!-- Description Textarea -->
                    <div class="form-group">
                        <label for="description">{{trans('teacher_courses.Description')}}</label>
                        <textarea id="description" name="description" class="form-control summernote" required></textarea>
                    </div>

                    <!-- Sections Dropdown -->
                    <div class="form-group">
                        <label for="section_id">{{trans('teacher_courses.Sections')}}</label>
                        <select id="section_id" name="section_id" class="form-control" required>
                            <option value="" disabled selected>{{trans('teacher_courses.Choose from the list')}}</option>
                            @foreach($sections as $section)
                                @if($section->course_id == $id)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success btn-lg" >{{trans('teacher_courses.Add')}}</button>
                </form>

                <!-- Cancel Button -->
                <form action="{{ route('lesson.editable', $id) }}" method="GET" class="mt-3">
                    <button type="submit" class="btn btn-secondary btn-lg">{{trans('teacher_courses.Cancel')}}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Enter your description...',
                height: 300
            });
        });
    </script>
</body>

</html>
