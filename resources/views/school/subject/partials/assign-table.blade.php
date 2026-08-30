@if(isset($groupedAssignments) && $groupedAssignments->count() > 0)
    <div class="class-cards-container">
        @foreach($groupedAssignments as $classId => $classAssignments)
            @php
                $class = $classAssignments->first()->class ?? null;
                $className = $class ? $class->name : __('Unassigned Class');
                $categoryName = $class?->category?->name ?? ($classAssignments->first()->category?->name ?? null);
                $subjectCount = $classAssignments->count();
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
                                <i class="fa-regular fa-folder-open me-1"></i> {{ __('Class Curriculum Subjects') }}
                            </div>
                        </div>
                    </div>
                    <div class="class-header-stats">
                        <span class="badge stat-badge-primary" style="font-size: 0.75rem; padding: 4px 10px;">
                            <i class="fa-solid fa-book-bookmark me-1"></i> {{ $subjectCount }} {{ __('Subjects') }}
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
                                    <th style="width: 34%; padding: 8px 12px;">{{ __('Subject') }}</th>
                                    <th style="width: 22%; padding: 8px 12px;">{{ __('Sub Category') }}</th>
                                    <th class="text-center" style="width: 15%; padding: 8px 12px;">{{ __('Full Mark') }}</th>
                                    <th class="text-center" style="width: 15%; padding: 8px 12px;">{{ __('Pass Mark') }}</th>
                                    <th style="width: 80px; padding: 8px 12px;" class="text-end pe-3">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classAssignments as $assignment)
                                    <tr>
                                        <td class="text-center fw-semibold text-muted" style="font-size: 0.78rem; padding: 9px 12px;">
                                            #{{ $assignment->id }}
                                        </td>
                                        <td style="padding: 9px 12px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="subject-tile-icon" style="width: 28px; height: 28px; font-size: 0.75rem; border-radius: 6px;">
                                                    <i class="fa-solid fa-book"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark subject-title" style="font-size: 0.85rem;">{{ $assignment->subject->name ?? 'N/A' }}</span>
                                                    @if(!empty($assignment->subject->code))
                                                        <div class="subject-code-tag" style="font-size: 0.68rem;">{{ __('Code') }}: {{ $assignment->subject->code }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 9px 12px;">
                                            @if($assignment->subcategory)
                                                <span class="badge badge-subcategory" style="font-size: 0.72rem; padding: 3px 8px;">
                                                    <i class="fa-solid fa-layer-group me-1 text-primary"></i> {{ $assignment->subcategory->name }}
                                                </span>
                                            @else
                                                <span class="badge badge-subcategory-none" style="font-size: 0.7rem; padding: 3px 6px;">
                                                    {{ __('None') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="padding: 9px 12px;">
                                            <span class="mark-pill full-mark-pill" style="font-size: 0.76rem; padding: 3px 8px; border-radius: 6px;">
                                                <i class="fa-solid fa-star me-1 text-warning"></i> {{ $assignment->full_mark ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="padding: 9px 12px;">
                                            <span class="mark-pill pass-mark-pill" style="font-size: 0.76rem; padding: 3px 8px; border-radius: 6px;">
                                                <i class="fa-solid fa-circle-check me-1 text-success"></i> {{ $assignment->pass_mark ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3" style="padding: 9px 12px;">
                                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                                <a href="{{ route('subjects.assign.edit', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}"
                                                   class="btn btn-action-icon btn-soft-warning" 
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('subjects.assign.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" 
                                                            class="btn btn-action-icon btn-soft-danger" 
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete') }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Mobile Responsive Cards View --}}
                <div class="class-mobile-view">
                    <div class="mobile-subjects-list p-2.5">
                        @foreach($classAssignments as $assignment)
                            <div class="mobile-subject-card p-2.5 mb-2">
                                <div class="mobile-subject-header">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="subject-tile-icon-sm" style="width: 26px; height: 26px; font-size: 0.72rem;">
                                            <i class="fa-solid fa-book"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mobile-sub-name" style="font-size: 0.84rem;">{{ $assignment->subject->name ?? 'N/A' }}</div>
                                            <div class="d-flex align-items-center gap-1 flex-wrap mt-0.5">
                                                <span class="text-muted" style="font-size: 0.68rem;">#{{ $assignment->id }}</span>
                                                @if(!empty($assignment->subject->code))
                                                    <span class="text-muted" style="font-size: 0.68rem;">• {{ __('Code') }}: {{ $assignment->subject->code }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ route('subjects.assign.edit', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}"
                                           class="btn btn-action-icon-sm btn-soft-warning" title="{{ __('Edit') }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('subjects.assign.destroy', ['tenant' => app()->bound('currentSchool') ? app('currentSchool')->slug : (auth()->user()?->school?->slug ?? request()->route('tenant')), 'assignment' => $assignment->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-action-icon-sm btn-soft-danger" title="{{ __('Delete') }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mobile-subject-footer mt-2 pt-2">
                                    <div>
                                        @if($assignment->subcategory)
                                            <span class="badge badge-subcategory" style="font-size: 0.68rem; padding: 2px 6px;">
                                                <i class="fa-solid fa-layer-group me-1 text-primary"></i> {{ $assignment->subcategory->name }}
                                            </span>
                                        @else
                                            <span class="badge badge-subcategory-none" style="font-size: 0.66rem; padding: 2px 5px;">
                                                {{ __('No Sub Category') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="mark-pill-sm full-mark-pill" style="font-size: 0.7rem; padding: 2px 6px;">
                                            <i class="fa-solid fa-star me-1 text-warning"></i>{{ $assignment->full_mark ?? '-' }}
                                        </span>
                                        <span class="mark-pill-sm pass-mark-pill" style="font-size: 0.7rem; padding: 2px 6px;">
                                            <i class="fa-solid fa-circle-check me-1 text-success"></i>{{ $assignment->pass_mark ?? '-' }}
                                        </span>
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
            <i class="fa-solid fa-book-open-reader"></i>
        </div>
        <h5 class="empty-title" style="font-size: 1rem;">{{ __('No Subjects Assigned Yet') }}</h5>
        <p class="empty-desc" style="font-size: 0.82rem;">{{ __('No subject allocations match your selected filter. Use the form on the left to map subjects to classes with full & pass marks.') }}</p>
    </div>
@endif