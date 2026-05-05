<div class="table-responsive">
    <table class="table data-table mb-0 align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Clas Name</th>
                <th>Subject</th>
                <th>Sub Category</th>
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
                <td>{{ $assignment->subcategory?->name ?? 'No category' }}</td>
                <td>{{ $assignment->full_mark ?? 'Null' }}</td>
                <td>{{ $assignment->pass_mark ?? 'Null' }}</td>
                <td>
                    <div style="display:inline-flex; align-items:center; gap:0.35rem; flex-wrap:wrap;">
                        <a href="{{ route('subjects.assign.edit', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                            class="btn btn-sm btn-warning badge"><i class="fa-regular fa-pen-to-square"></i></a>
                        <form
                            action="{{ route('subjects.assign.destroy', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                            method="POST" style="display:inline-flex; align-items:center; gap:0.35rem;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)"
                                class="btn btn-sm btn-danger badge"><i
                                    class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $assignments->links() }}
</div>