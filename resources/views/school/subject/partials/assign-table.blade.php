<div class="table-responsive">
    <table class="table data-table mb-0 align-middle">
        <thead class="bg-light">
            <tr>
                <th class="py-3 px-3"># ID</th>
                <th class="py-3 px-3">Class Name</th>
                <th class="py-3 px-3">Subject</th>
                <th class="py-3 px-3 text-center">Sub Category</th>
                <th class="py-3 px-3 text-center">Full Mark</th>
                <th class="py-3 px-3 text-center">Pass Mark</th>
                <th class="py-3 px-3 text-end" width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td class="px-3 fw-bold text-muted" style="font-size:0.8rem;">#{{ $assignment->id }}</td>
                    <td class="px-3">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-weight:700;font-size:0.7rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                {{ substr($assignment->class->name ?? 'C', 0, 1) }}
                            </div>
                            <span class="fw-bold text-dark" style="font-size:0.85rem;">{{ $assignment->class->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-3">
                        <span class="fw-bold text-primary text-capitalize" style="font-size:0.85rem;">{{ $assignment->subject->name ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center px-3">
                        <span class="badge bg-light text-secondary border px-2 py-1" style="font-size:0.75rem;">
                            {{ $assignment->subcategory?->name ?? 'None' }}
                        </span>
                    </td>
                    <td class="text-center px-3">
                        <span class="badge-completed">
                            {{ $assignment->full_mark ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center px-3">
                        <span class="badge-pending">
                            {{ $assignment->pass_mark ?? '-' }}
                        </span>
                    </td>
                    <td class="px-3 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('subjects.assign.edit', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                                class="btn btn-action btn-sm btn-outline-warning" title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('subjects.assign.destroy', ['tenant' => auth()->user()->school->slug, 'assignment' => $assignment->id]) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="btn btn-action btn-sm btn-outline-danger" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                        No subject assignments found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="p-3 border-top">
    {{ $assignments->links() }}
</div>