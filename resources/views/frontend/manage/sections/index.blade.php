@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="#">Frontend</a></li>
        <li><span>/</span></li>
        <li class="active">Manage Sections</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-layer-group me-2" style="color:#4f46e5;"></i> Frontend Sections</h2>
            <p class="edu-page-sub">Manage and organize your website's home page sections</p>
        </div>
    </div>

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <h6 class="edu-panel-ttl">Sections List</h6>
            <span style="font-size:0.8rem;color:#94a3b8;">{{ $sections->count() }} total</span>
        </div>
        <div class="table-responsive">
            <table class="edu-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Order</th>
                        <th>Section Title</th>
                        <th>Key</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                    <tr>
                        <td><span class="badge-id">{{ $section->order }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;color:#4f46e5;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;flex-shrink:0;">
                                    @if($section->key == 'hero')
                                        <i data-feather="monitor" style="width:16px;height:16px;"></i>
                                    @elseif($section->key == 'about')
                                        <i data-feather="info" style="width:16px;height:16px;"></i>
                                    @elseif($section->key == 'features')
                                        <i data-feather="star" style="width:16px;height:16px;"></i>
                                    @else
                                        <i data-feather="layout" style="width:16px;height:16px;"></i>
                                    @endif
                                </div>
                                <span style="font-weight:700;color:#1e293b;">{{ $section->title }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="background:#f1f5f9; color:#475569; font-size:11px; padding:4px 8px; border-radius:6px; font-weight:600;">
                                {{ $section->key }}
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input status-toggle" 
                                       data-id="{{ $section->id }}"
                                       {{ $section->status ? 'checked' : '' }} style="cursor: pointer;">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('manage.frontend.edit', $section->id) }}" class="act-btn" title="Edit" style="color:#4f46e5; background: #eef2ff;">
                                    <i data-feather="edit-2" style="width:15px;height:15px;"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.status-toggle').on('change', function() {
        let isChecked = $(this).prop('checked');
        let status = isChecked ? 1 : 0;
        let sectionId = $(this).data('id');

        $.ajax({
            type: "POST",
            url: "{{ route('manage.frontend.update.status') }}",
            data: { id: sectionId, status: status },
            success: function(data) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                Toast.fire({ icon: 'success', title: data.message });
            },
            error: function(err) {
                console.log(err);
                $(this).prop('checked', !isChecked);
                alert('Something went wrong!');
            }.bind(this)
        });
    });
});
</script>
@endsection