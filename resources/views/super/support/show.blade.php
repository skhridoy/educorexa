@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* Premium Chat Layout */
    .chat-wrapper {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1.5px solid #f1f5f9;
        overflow: hidden;
    }
    
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 25px;
        max-height: 550px;
        overflow-y: auto;
        background: #f8fafc;
    }

    /* Priority & Status Badges */
    .priority-pill {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-transform: capitalize;
    }
    .priority-high { background: #fee2e2; color: #ef4444; border: 1px solid #fca5a5; }
    .priority-medium { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .priority-low { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }

    /* Bubble Styles - Refined for Academic Elite */
    .msg-bubble {
        padding: 14px 18px;
        border-radius: 18px;
        width: fit-content;
        max-width: 75%;
        position: relative;
        font-family: 'Outfit', 'Inter', sans-serif;
        line-height: 1.5;
        font-size: 0.92rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    /* School Messages (Left - White) */
    .msg-school {
        align-self: flex-start;
        background: #ffffff;
        color: #1e293b;
        border-bottom-left-radius: 4px;
        border: 1.5px solid #e2e8f0;
    }

    /* Super Admin Messages (Right - Indigo) */
    .msg-system {
        align-self: flex-end;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
    }

    .msg-info {
        font-size: 0.68rem;
        margin-bottom: 4px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .msg-school .msg-info { color: #64748b; }
    .msg-system .msg-info { color: rgba(255,255,255,0.85); text-align: right; }

    .msg-content { word-break: break-word; }

    .msg-time { font-size: 0.65rem; margin-top: 6px; opacity: 0.75; }
    .msg-school .msg-time { text-align: left; color: #94a3b8; }
    .msg-system .msg-time { text-align: right; color: rgba(255,255,255,0.85); }

    /* Footer - Restored Footer Design */
    .reply-area {
        background: #ffffff;
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
    }
    .reply-box-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        padding: 6px 10px;
        border-radius: 30px;
        border: 1.5px solid #e2e8f0;
    }
    .reply-box-wrapper:focus-within {
        border-color: #4f46e5;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .reply-input-field {
        flex-grow: 1;
    }
    .reply-input-field textarea {
        border: none;
        resize: none;
        padding: 8px 6px;
        font-size: 0.92rem;
        background: transparent;
        width: 100%;
        color: #1e293b;
        display: block;
        max-height: 90px;
    }
    .reply-input-field textarea:focus { box-shadow: none; outline: none; }

    /* Circle Buttons */
    .btn-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-chat-send { background: #4f46e5; color: white; }
    .btn-chat-send:hover { transform: scale(1.05); background: #4338ca; box-shadow: 0 4px 12px rgba(79,70,229,0.3); }
    .btn-chat-attach { background: #fff; color: #64748b; border: 1.5px solid #e2e8f0; }
    .btn-chat-attach:hover { color: #4f46e5; background: #f8fafc; border-color: #c7d2fe; }

    #file-preview {
        display: none;
        padding: 8px 16px;
        background: #eff6ff;
        border-radius: 10px;
        margin-bottom: 12px;
        font-size: 0.8rem;
        color: #1d4ed8;
        border-left: 3px solid #3b82f6;
    }

    @media (max-width: 768px) {
        .msg-bubble { max-width: 90%; }
        .chat-container { padding: 16px; }
        .show-header-wrap {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">

        {{-- ===== BREADCRUMB ===== --}}
        <ul class="edu-bc">
            <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('manage.support.index') }}">Support Desk</a></li>
            <li><span>/</span></li>
            <li class="active">#{{ $ticket->ticket_id }}</li>
        </ul>

        {{-- ===== HEADER ===== --}}
        <div class="d-flex justify-content-between align-items-center mb-4 show-header-wrap">
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h3 class="fw-bold mb-0 text-dark" style="font-family: 'Outfit';">
                        {{ $ticket->subject }}
                    </h3>
                    <span class="badge-id">#{{ $ticket->ticket_id }}</span>
                    <span class="priority-pill priority-{{ $ticket->priority }}">
                        {{ $ticket->priority }} Priority
                    </span>
                </div>
                <p class="text-muted small mb-0 d-flex align-items-center gap-2 flex-wrap">
                    <span><i class="fa-solid fa-school text-primary me-1"></i><strong>{{ $ticket->school->name ?? 'General' }}</strong></span>
                    <span>•</span>
                    <span><i class="fa-regular fa-user me-1"></i>{{ $ticket->user->name ?? 'School Admin' }} ({{ $ticket->user->email ?? '' }})</span>
                    <span>•</span>
                    <span><i class="fa-regular fa-clock me-1"></i>{{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('manage.support.index') }}" class="btn-edu btn-edu-light">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>

                {{-- Status Changer Dropdown --}}
                <div class="dropdown">
                    <button class="btn-edu btn-edu-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-dot me-1"></i> {{ ucfirst($ticket->status) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 supp-actions-menu">
                        <li>
                            <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="status" value="open">
                                <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-primary {{ $ticket->status === 'open' ? 'fw-bold' : '' }}">
                                    <i class="fa-solid fa-envelope-open-text" style="width:16px;"></i>
                                    <span>Mark as Open</span>
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-warning {{ $ticket->status === 'pending' ? 'fw-bold' : '' }}">
                                    <i class="fa-solid fa-clock-rotate-left" style="width:16px;"></i>
                                    <span>Mark as Pending</span>
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-success {{ $ticket->status === 'resolved' ? 'fw-bold' : '' }}">
                                    <i class="fa-solid fa-check-double" style="width:16px;"></i>
                                    <span>Mark as Resolved</span>
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-secondary {{ $ticket->status === 'closed' ? 'fw-bold' : '' }}">
                                    <i class="fa-solid fa-folder-closed" style="width:16px;"></i>
                                    <span>Mark as Closed</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <div class="chat-wrapper">
        <div class="chat-container" id="chatContainer">
            {{-- Ticket Initial Message --}}
            <div class="msg-bubble msg-school">
                <span class="msg-info">{{ $ticket->user->name }} • School</span>
                <div class="msg-content">{{ $ticket->message }}</div>
                @if($ticket->attachment)
                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn btn-xs btn-light mt-2 border">
                        <i data-feather="file" class="icon-xs"></i> Attachment
                    </a>
                @endif
                <div class="msg-time">{{ $ticket->created_at->format('d M, h:i A') }}</div>
            </div>

            {{-- ALL REPLIES GO DIRECTLY HERE --}}
            @foreach($ticket->replies as $reply)
                <div class="msg-bubble {{ $reply->is_school_side ? 'msg-school' : 'msg-system' }} mb-3" data-id="{{ $reply->id }}">
                    <span class="msg-info">{{ $reply->is_school_side ? $reply->user->name : 'You • Support' }}</span>
                    <div class="msg-content">{{ $reply->message }}</div>
                    @if($reply->attachment)
                        <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" class="btn btn-xs mt-2 d-inline-flex align-items-center {{ $reply->is_school_side ? 'btn-light border' : 'btn-white bg-opacity-25 text-white' }}">
                            <i data-feather="paperclip" class="icon-xs me-1"></i> File
                        </a>
                    @endif
                    <div class="msg-time">{{ $reply->created_at->format('d M, h:i A') }}</div>
                </div>
            @endforeach
        </div>

        @if($ticket->status != 'closed')
            <div class="reply-area">
                <div id="file-preview"></div>
                <form action="{{ route('manage.support.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" id="replyForm">
                    @csrf
                    <div class="reply-box-wrapper">
                        <label for="chat-file" class="btn-circle btn-chat-attach">
                            <i data-feather="paperclip" class="icon-sm"></i>
                        </label>
                        <input type="file" name="attachment" id="chat-file" class="d-none" onchange="updateFileName(this)">
                        
                        <div class="reply-input-field">
                            <textarea name="message" id="msg-text" rows="1" placeholder="Reply to school..." required oninput="expandInput(this)"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-circle btn-chat-send" id="sendBtn">
                            <i data-feather="send" class="icon-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    let lastId = {{ $ticket->replies->last() ? $ticket->replies->last()->id : 0 }};
    const chatContainer = document.getElementById('chatContainer');

    function expandInput(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    }

    function updateFileName(input) {
        const preview = document.getElementById('file-preview');
        if(input.files[0]) {
            preview.innerHTML = `<i data-feather="file" class="icon-xs me-1"></i> ${input.files[0].name}`;
            preview.style.display = 'block';
            if(window.feather) feather.replace();
        } else {
            preview.style.display = 'none';
        }
    }

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function appendMsg(msg) {
        const isSystem = !msg.is_school_side;
        const bubbleClass = isSystem ? 'msg-system' : 'msg-school';
        const infoText = isSystem ? 'You • Support' : msg.user_name;
        
        const attachHtml = msg.attachment ? 
            `<a href="${msg.attachment}" target="_blank" class="btn btn-xs mt-2 d-inline-flex align-items-center ${isSystem ? 'btn-white bg-opacity-25 text-white' : 'btn-light border'}">
                <i data-feather="paperclip" class="icon-xs me-1"></i> File
            </a>` : '';

        const html = `
            <div class="msg-bubble ${bubbleClass} mb-3" data-id="${msg.id}" style="opacity:0; transform:translateY(5px);">
                <span class="msg-info">${infoText}</span>
                <div class="msg-content">${msg.message}</div>
                ${attachHtml}
                <div class="msg-time">${msg.time}</div>
            </div>
        `;
        
        const div = document.createElement('div');
        div.innerHTML = html;
        const el = div.firstElementChild;
        chatContainer.appendChild(el); // DIRECTLY TO CONTAINER
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
            if(window.feather) feather.replace();
            scrollToBottom();
        }, 10);
        
        lastId = msg.id;
    }

    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        const btn = $('#sendBtn');
        btn.prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.success) {
                    appendMsg(res.data);
                    $('#replyForm')[0].reset();
                    $('#msg-text').css('height', 'auto');
                    $('#file-preview').hide();
                }
            },
            complete: function() { btn.prop('disabled', false); }
        });
    });

    setInterval(() => {
        $.get("{{ route('manage.support.fetch', $ticket->id) }}", { last_id: lastId }, function(res) {
            res.data.forEach(msg => {
                if($(`[data-id="${msg.id}"]`).length === 0) appendMsg(msg);
            });
        });
    }, 5000);

    $(function() { scrollToBottom(); if(window.feather) feather.replace(); });
</script>
@endsection
