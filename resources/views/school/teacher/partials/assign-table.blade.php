@if(isset($groupedAssignments) && $groupedAssignments->count() > 0)
    <div class="class-cards-container">
        @foreach($groupedAssignments as $classId => $classAssignments)
            @php
                $class = $classAssignments->first()->class ?? null;
                $className = $class ? $class->name : 'Unassigned Class';
                $categoryName = $class?->schoolCategory?->name ?? null;
                $subjectCount = $classAssignments->count();
                $teacherCount = $classAssignments->pluck('teacher_id')->unique()->count();
            @endphp
            <div class="class-assign-card mb-3">
                {{-- Class Card Header --}}
                <div class="class-card-header py-2.5 px-3">
                    <div class="class-header-info">
                        <div class="class-icon-badge" style="width: 36px; height: 36px; font-size: 1rem; border-radius: 10px;">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h5 class="class-name-title mb-0" style="font-size: 0.96rem;">{{ $className }}</h5>
                                @if($categoryName)
                                    <span class="class-category-badge" style="font-size: 0.7rem; padding: 1px 6px;">{{ $categoryName }}</span>
                                @endif
                            </div>
                            <div class="class-meta-subtext" style="font-size: 0.72rem;">
                                <i class="fa-regular fa-folder-open me-1"></i> Class Assigned Curriculum
                            </div>
                        </div>
                    </div>
                    <div class="class-header-stats">
                        <span class="badge stat-badge-primary" style="font-size: 0.75rem; padding: 4px 10px;">
                            <i class="fa-solid fa-book-open me-1"></i> {{ $subjectCount }} {{ Str::plural('Subject', $subjectCount) }}
                        </span>
                        <span class="badge stat-badge-success" style="font-size: 0.75rem; padding: 4px 10px;">
                            <i class="fa-solid fa-chalkboard-user me-1"></i> {{ $teacherCount }} {{ Str::plural('Teacher', $teacherCount) }}
                        </span>
                    </div>
                </div>

                {{-- Desktop Table View --}}
                <div class="class-desktop-view">
                    <div class="table-responsive">
                        <table class="table class-subject-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 48px; padding: 8px 12px;" class="text-center">#</th>
                                    <th style="width: 30%; padding: 8px 12px;">Subject</th>
                                    <th style="width: 20%; padding: 8px 12px;">Section</th>
                                    <th style="padding: 8px 12px;">Assigned Faculty</th>
                                    <th style="width: 70px; padding: 8px 12px;" class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classAssignments as $assignment)
                                    <tr>
                                        <td class="text-center fw-semibold text-muted" style="font-size: 0.78rem; padding: 9px 12px;">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td style="padding: 9px 12px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="subject-tile-icon" style="width: 28px; height: 28px; font-size: 0.75rem; border-radius: 6px;">
                                                    <i class="fa-solid fa-book-bookmark"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark subject-title" style="font-size: 0.85rem;">{{ $assignment->subject->name ?? 'N/A' }}</div>
                                                    @if(!empty($assignment->subject->code))
                                                        <span class="subject-code-tag" style="font-size: 0.68rem;">Code: {{ $assignment->subject->code }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 9px 12px;">
                                            @if($assignment->section)
                                                <span class="badge badge-section-custom" style="font-size: 0.72rem; padding: 3px 8px;">
                                                    <i class="fa-solid fa-layer-group me-1 text-info"></i> {{ $assignment->section->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-section-all" style="font-size: 0.7rem; padding: 3px 6px;">
                                                    All Sections
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 9px 12px;">
                                            <div class="d-flex align-items-center gap-2">
                                                @if(!empty($assignment->teacher->photo) && file_exists(public_path($assignment->teacher->photo)))
                                                    <img src="{{ asset($assignment->teacher->photo) }}" alt="{{ $assignment->teacher->name }}" class="teacher-avatar-photo" style="width: 30px; height: 30px;">
                                                @else
                                                    <div class="teacher-avatar-initials" style="width: 30px; height: 30px; font-size: 0.78rem;">
                                                        {{ strtoupper(substr($assignment->teacher->name ?? 'T', 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-dark teacher-title" style="font-size: 0.84rem;">{{ $assignment->teacher->name ?? 'N/A' }}</div>
                                                    @if(!empty($assignment->teacher->designation))
                                                        <div class="teacher-subtitle" style="font-size: 0.7rem;">{{ $assignment->teacher->designation }}</div>
                                                    @elseif(!empty($assignment->teacher->phone))
                                                        <div class="teacher-subtitle" style="font-size: 0.7rem;"><i class="fa-solid fa-phone me-1"></i>{{ $assignment->teacher->phone }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end pe-3" style="padding: 9px 12px;">
                                            <form action="{{ route('teacher.assign.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete(this)" 
                                                        class="btn btn-soft-danger btn-icon-sm" 
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Assignment">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Responsive Subject Cards View --}}
                <div class="class-mobile-view">
                    <div class="mobile-subjects-list p-2.5">
                        @foreach($classAssignments as $assignment)
                            <div class="mobile-subject-card p-2.5 mb-2">
                                <div class="mobile-subject-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="subject-tile-icon-sm" style="width: 26px; height: 26px; font-size: 0.72rem;">
                                            <i class="fa-solid fa-book-bookmark"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mobile-sub-name" style="font-size: 0.84rem;">{{ $assignment->subject->name ?? 'N/A' }}</div>
                                            @if(!empty($assignment->subject->code))
                                                <span class="text-muted" style="font-size: 0.68rem;">Code: {{ $assignment->subject->code }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <form action="{{ route('teacher.assign.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="btn btn-soft-danger btn-icon-sm" title="Remove Assignment">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="mobile-subject-footer mt-2 pt-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if(!empty($assignment->teacher->photo) && file_exists(public_path($assignment->teacher->photo)))
                                            <img src="{{ asset($assignment->teacher->photo) }}" alt="{{ $assignment->teacher->name }}" class="teacher-avatar-photo-sm" style="width: 24px; height: 24px;">
                                        @else
                                            <div class="teacher-avatar-initials-sm" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                                {{ strtoupper(substr($assignment->teacher->name ?? 'T', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark mobile-teacher-name" style="font-size: 0.8rem;">{{ $assignment->teacher->name ?? 'N/A' }}</div>
                                            @if(!empty($assignment->teacher->designation))
                                                <div class="text-muted mobile-teacher-des" style="font-size: 0.68rem;">{{ $assignment->teacher->designation }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        @if($assignment->section)
                                            <span class="badge badge-section-custom" style="font-size: 0.68rem; padding: 2px 6px;">
                                                <i class="fa-solid fa-layer-group me-1 text-info"></i> {{ $assignment->section->name }}
                                            </span>
                                        @else
                                            <span class="badge badge-section-all" style="font-size: 0.66rem; padding: 2px 5px;">
                                                All Sections
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="class-assign-empty-state py-4 px-3">
        <div class="empty-icon-wrap" style="width: 56px; height: 56px; font-size: 1.5rem;">
            <i class="fa-solid fa-chalkboard"></i>
        </div>
        <h5 class="empty-title" style="font-size: 1rem;">No Teacher Assignments Found</h5>
        <p class="empty-desc" style="font-size: 0.82rem;">No subject allocations match your current search or filter criteria. Select class, section, subject and teacher from the left form to make an assignment.</p>
    </div>
@endif