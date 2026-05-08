<div class="data-table-card">
    <div class="table-header">
        <h5 class="table-title">
            <i class="fa-solid fa-file-pen me-2"></i> Enter Marks (Full Marks: {{ $fullMarks }})
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 15%;">Student ID</th>
                    <th style="width: 10%;">Roll</th>
                    <th>Student Name</th>
                    <th style="width: 25%;">Obtained Marks</th>
                    <th class="text-center" style="width: 10%;">Grade</th>
                    <th class="text-center" style="width: 15%;">Attendance</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $student)
                    <tr class="align-middle">
                        <td data-label="Student ID" class="fw-medium text-muted">{{ $student->student_id }}</td>
                        <td data-label="Roll" class="fw-bold text-dark">{{ $student->roll }}</td>
                        <td data-label="Name">
                            <div class="d-flex align-items-center">
                                <div class="fw-bold">{{ $student->name }}</div>
                            </div>
                        </td>

                        <td data-label="Marks">
                            <div class="input-group input-group-sm ms-auto ms-md-0" style="max-width: 110px; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: #f8fafc;">
                                <input type="number" 
                                       class="form-control mark-input fw-bold border-0 bg-white text-center" 
                                       data-student="{{ $student->id }}"
                                       data-fullmarks="{{ $fullMarks }}"
                                       placeholder="00"
                                       min="0"
                                       max="{{ $fullMarks }}"
                                       style="padding: 8px 5px; font-size: 0.95rem; color: #002147;"
                                       value="{{ $marksWithGrade[$student->id]['marks'] ?? '' }}"
                                       {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'absent' ? 'disabled' : '' }}>
                                <span class="input-group-text border-0 bg-transparent text-muted fw-bold small" style="padding-right: 12px;">
                                    / {{ $fullMarks }}
                                </span>
                            </div>
                        </td>

                        <td data-label="Grade" class="text-center">
                            <span class="badge {{ ($marksWithGrade[$student->id]['grade'] ?? '-') == 'F' ? 'badge-danger' : 'badge-primary' }} px-3 py-2" 
                                  id="grade-{{ $student->id }}" 
                                  style="min-width: 45px; font-size: 0.85rem;">
                                {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'absent' ? 'ABS' : ($marksWithGrade[$student->id]['grade'] ?? '-') }}
                            </span>
                        </td>

                        <td data-label="Attendance" class="text-center">
                            <select class="form-select form-select-sm status-input border-0 bg-light" 
                                    data-student="{{ $student->id }}"
                                    style="border-radius: 8px; padding: 6px 12px; font-weight: 600;">
                                <option value="present" {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'present' ? 'selected' : '' }} class="text-success">Present</option>
                                <option value="absent" {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'absent' ? 'selected' : '' }} class="text-danger">Absent</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .mark-input:focus {
        background-color: #fff !important;
        border: 1px solid #4f46e5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
    }
</style>