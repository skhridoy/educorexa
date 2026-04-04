<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Teacher Name</th>
            <th>Class</th>
            <th>Subject</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->id }}</td>
                <td>{{ $assignment->teacher->name }}</td>
                <td>{{ $assignment->class->name }}</td>
                <td class="text-capitalize">{{ $assignment->subject->name }}</td>
                <td>
                    <form
                        action="{{ route('teacher.assign.destroy', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                        method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete(this)"
                            class="btn btn-sm btn-danger badge"><i
                                class="fa-solid fa-trash"></i></button>
                    </form>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-3">
    {{ $assignments->links() }}
</div>