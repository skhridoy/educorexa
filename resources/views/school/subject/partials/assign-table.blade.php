<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Clas Name</th>
            <th>Subject</th>
            <th>Full Mark</th>
            <th>Pass Mark</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assignments as $assignment)
            <tr>
                <td>{{ $assignment->id }}</td>
                <td>{{ $assignment->class->name }}</td>
                <td class="text-capitalize">{{ $assignment->subject->name }}</td>
                <td>{{ $assignment->full_mark ?? 'Null' }}</td>
                <td>{{ $assignment->pass_mark ?? 'Null' }}</td>
                <td>
                    <a href="{{ route('subjects.assign.edit', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                        class="btn btn-sm btn-warning badge"><i class="fa-regular fa-pen-to-square"></i></a>

                    <form
                        action="{{ route('subjects.assign.destroy', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
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