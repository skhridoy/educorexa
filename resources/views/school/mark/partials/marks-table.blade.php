<div class="card shadow-sm border-0">
    <div class="card-header bg-primary py-3">
        <h5 class="card-title text-white mb-0">
            <i class="link-icon" data-feather="edit-3"></i> Enter Marks (Full Marks: {{ $fullMarks }})
        </h5>
    </div>

    <div class="card-body">
        <form id="marksForm">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold border-0 d-none d-sm-table-cell" style="width: 15%;">Student ID</th>
                            <th style="width: 10%;">Roll</th>
                            <th class="fw-bold border-0 d-none d-sm-table-cell">Student Name</th>
                            <th class="fw-bold border-0" style="width: 20%;">Obtained Marks</th>
                            <th class="fw-bold border-0 text-center d-none d-sm-table-cell" style="width: 10%;">Grade</th>
                            <th class="fw-bold border-0 text-center" style="width: 15%;">Atten</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td class="text-muted fw-medium  d-none d-sm-table-cell">{{ $student->student_id }}</td>
                                <td>{{ $student->roll }}</td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold text-dark">{{ $student->name }}</div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" 
                                               class="form-control mark-input fw-bold border-primary" 
                                               data-student="{{ $student->id }}"
                                               data-fullMarks="{{ $fullMarks }}"
                                               placeholder="00"
                                               min="0"
                                               max="{{ $fullMarks }}"
                                               style="max-width: 100px;"
                                               value="{{ $marksWithGrade[$student->id]['marks'] ?? '' }}">
                                        <span class="input-group-text bg-light text-muted">/ {{ $fullMarks }}</span>
                                    </div>
                                </td>

                                <td class="text-center  d-none d-sm-table-cell">
                                    <span class="badge bg-soft-info p-2 grade-box fs-6 fw-bolder text-primary shadow-sm border border-info" 
                                          id="grade-{{ $student->id }}" 
                                          style="min-width: 45px; display: inline-block;">
                                        {{ $marksWithGrade[$student->id]['grade'] ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <select class="form-select form-select-sm status-input border-{{ ($marksWithGrade[$student->id]['status'] ?? 'present') == 'absent' ? 'danger' : 'success' }}" 
                                            data-student="{{ $student->id }}">
                                        <option value="present" {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'present' ? 'selected' : '' }}>Pre</option>
                                        <option value="absent" {{ ($marksWithGrade[$student->id]['status'] ?? '') == 'absent' ? 'selected' : '' }}>Abs</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="link-icon" data-feather="save"></i> Save All Marks
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* একটু সুন্দর লুক দেওয়ার জন্য বাড়তি সিএসএস */
    .bg-soft-info { background-color: #e0f4ff; }
    .table thead th { text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
    .mark-input:focus { box-shadow: 0 0 0 0.25 margin-bottom: 5px; }
    .status-input { cursor: pointer; }
</style>