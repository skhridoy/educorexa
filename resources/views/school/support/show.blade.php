@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* Premium Chat Layout */
        .chat-wrapper {
            background: #ffffff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 24px;
            max-height: 520px;
            overflow-y: auto;
            background: #f8fafc;
        }

        /* Scrollbar */
        .chat-container::-webkit-scrollbar { width: 5px; }
        .chat-container::-webkit-scrollbar-track { background: #f1f5f9; }
        .chat-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 6px; }

        /* Bubble Styles */
        .msg-bubble {
            padding: 12px 18px;
            border-radius: 18px;
            width: fit-content;
            max-width: 75%;
            position: relative;
            line-height: 1.55;
            font-size: 0.91rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        /* School Messages (Right - Indigo gradient) */
        .msg-school {
            align-self: flex-end;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.22);
        }

        /* System/Admin Messages (Left) */
        .msg-system {
            align-self: flex-start;
            background: #ffffff;
            color: #334155;
            border-bottom-left-radius: 4px;
            border: 1.5px solid #e2e8f0;
        }

        .msg-info {
            font-size: 0.64rem;
            margin-bottom: 4px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
        .msg-school .msg-info { color: rgba(255,255,255,0.82); text-align: right; }
        .msg-system .msg-info { color: #64748b; }

        .msg-content { word-break: break-word; }

        .msg-time { font-size: 0.61rem; margin-top: 5px; opacity: 0.75; }
        .msg-school .msg-time { text-align: right; color: rgba(255,255,255,0.8); }
        .msg-system .msg-time { text-align: left; color: #94a3b8; }

        /* Reply Area */
        .reply-area {
            background: #ffffff;
            padding: 14px 20px;
            border-top: 1.5px solid #f1f5f9;
        }
        .reply-box-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
            padding: 5px 8px;
            border-radius: 30px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s;
        }
        .reply-box-wrapper:focus-within {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        }
        .reply-input-field { flex-grow: 1; }
        .reply-input-field textarea {
            border: none;
            resize: none;
            padding: 8px 5px;
            font-size: 0.9rem;
            background: transparent;
            width: 100%;
            color: #1e293b;
            display: block;
            max-height: 80px;
        }
        .reply-input-field textarea:focus { box-shadow: none; outline: none; }

        /* Circle Buttons */
        .btn-circle {
            width: 38px; height: 38px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-chat-send { background: #4f46e5; color: white; }
        .btn-chat-send:hover { transform: scale(1.08); background: #4338ca; }
        .btn-chat-attach { background: #fff; color: #64748b; border: 1.5px solid #e2e8f0; }
        .btn-chat-attach:hover { color: #4f46e5; background: #eff6ff; border-color: #bfdbfe; }

        #file-preview {
            display: none;
            padding: 6px 14px;
            background: #eff6ff;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.75rem;
            color: #1d4ed8;
            border-left: 3px solid #3b82f6;
        }

        /* Priority & Status Badges */
        .badge-status {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-open     { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .status-pending  { background: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .status-resolved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-closed   { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

        .priority-high   { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
        .priority-medium { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
        .priority-low    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

        @media (max-width: 768px) {
            .msg-bubble { max-width: 90%; }
            .chat-container { padding: 14px; }
        }
    </style>
@endsection

@section('content')
<div class="page-content">

    {{-- ═════════════════════════════════════════════════════════════
         HERO HEADER CARD
    ══════════════════════════════════════════════════════════════ --}}
    <div class="page-header-card mb-4">
        <div class="page-header-content">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-header-icon">
                        <i class="fa-solid fa-comments text-white"></i>
                    </div>
                    <div>
                        <h4 class="page-title mb-0">{{ $ticket->subject }}</h4>
                        <p class="page-subtitle mb-0">
                            <span class="badge-status status-{{ $ticket->status }} py-0">{{ ucfirst($ticket->status) }}</span>
                            <span class="ms-2 text-white-50 fs-12">Ticket ID: #{{ $ticket->ticket_id }}</span>
                        </p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge-status priority-{{ $ticket->priority }}" style="border: 1px solid currentColor; opacity: 0.9;">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>
                    <a href="{{ route('school.support.index', $tenant) }}" class="btn-header-secondary">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('All Tickets') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         CHAT + TICKET INFO LAYOUT
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row g-4">
        {{-- Chat Section --}}
        <div class="col-lg-8">
            <div class="chat-wrapper">
                {{-- Chat Header --}}
                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom bg-light">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                            <i class="fa-solid fa-message"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ __('Support Conversation') }}</h6>
                            <small class="text-muted fs-11">{{ __('Opened') }} {{ $ticket->created_at->format('d M, Y') }}</small>
                        </div>
                    </div>
                    @if($ticket->status == 'closed')
                        <span class="badge bg-secondary-subtle text-secondary border fw-bold px-3 py-1 rounded-pill fs-11">
                            <i class="fa-solid fa-lock me-1"></i> {{ __('Ticket Closed') }}
                        </span>
                    @endif
                </div>

                {{-- Chat Container --}}
                <div class="chat-container" id="chatContainer">
                    {{-- Ticket Initial Message --}}
                    <div class="msg-bubble msg-school">
                        <span class="msg-info">You</span>
                        <div class="msg-content">{{ $ticket->message }}</div>
                        @if($ticket->attachment)
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" 
                               class="d-inline-flex align-items-center gap-1 mt-2 text-white fw-semibold" 
                               style="font-size: 12px; text-decoration: underline;">
                                <i class="fa-solid fa-paperclip"></i> {{ __('Attachment') }}
                            </a>
                        @endif
                        <div class="msg-time">{{ $ticket->created_at->format('d M, h:i A') }}</div>
                    </div>

                    {{-- Replies --}}
                    @foreach($ticket->replies as $reply)
                    <div class="msg-bubble {{ $reply->is_school_side ? 'msg-school' : 'msg-system' }}" data-id="{{ $reply->id }}">
                        <span class="msg-info">{{ $reply->is_school_side ? 'You' : 'System Support' }}</span>
                        <div class="msg-content">{{ $reply->message }}</div>
                        @if($reply->attachment)
                            <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank"
                               class="d-inline-flex align-items-center gap-1 mt-2 fw-semibold {{ $reply->is_school_side ? 'text-white' : 'text-primary' }}"
                               style="font-size: 12px; text-decoration: underline;">
                                <i class="fa-solid fa-paperclip"></i> {{ __('File') }}
                            </a>
                        @endif
                        <div class="msg-time">{{ $reply->created_at->format('d M, h:i A') }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Reply Area --}}
                @if($ticket->status != 'closed')
                <div class="reply-area">
                    <div id="file-preview"></div>
                    <form action="{{ route('school.support.reply', ['tenant' => $tenant, 'id' => $ticket->id]) }}" 
                          method="POST" enctype="multipart/form-data" id="replyForm">
                        @csrf
                        <div class="reply-box-wrapper">
                            <label for="chat-file" class="btn-circle btn-chat-attach" title="{{ __('Attach File') }}">
                                <i class="fa-solid fa-paperclip fs-6"></i>
                            </label>
                            <input type="file" name="attachment" id="chat-file" class="d-none" onchange="updateFileName(this)">

                            <div class="reply-input-field">
                                <textarea name="message" id="msg-text" rows="1" 
                                          placeholder="{{ __('Type your message here...') }}" 
                                          required oninput="expandInput(this)"></textarea>
                            </div>

                            <button type="submit" class="btn-circle btn-chat-send" id="sendBtn" title="{{ __('Send') }}">
                                <i class="fa-solid fa-paper-plane fs-6"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="reply-area text-center py-3">
                    <span class="text-muted fs-13">
                        <i class="fa-solid fa-lock me-1 text-secondary"></i>
                        {{ __('This ticket is closed. Open a new ticket if you need further assistance.') }}
                    </span>
                </div>
                @endif
            </div>
        </div>

        {{-- Ticket Info Sidebar --}}
        <div class="col-lg-4">
            <div class="data-table-card mb-4">
                <div class="data-table-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #eff6ff; color: #3b82f6; width: 34px; height: 34px;">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">{{ __('Ticket Details') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <span class="text-muted fs-12 fw-semibold text-uppercase">{{ __('Ticket ID') }}</span>
                            <span class="badge bg-light text-dark border fw-bold px-2 py-1 rounded-pill fs-11">
                                #{{ $ticket->ticket_id }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <span class="text-muted fs-12 fw-semibold text-uppercase">{{ __('Status') }}</span>
                            <span class="badge-status status-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <span class="text-muted fs-12 fw-semibold text-uppercase">{{ __('Priority') }}</span>
                            <span class="badge-status priority-{{ $ticket->priority }}">{{ ucfirst($ticket->priority) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                            <span class="text-muted fs-12 fw-semibold text-uppercase">{{ __('Opened On') }}</span>
                            <span class="fw-bold text-dark fs-12">{{ $ticket->created_at->format('d M, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fs-12 fw-semibold text-uppercase">{{ __('Replies') }}</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold px-2 rounded-pill fs-12">
                                {{ $ticket->replies->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Tips --}}
            <div class="data-table-card">
                <div class="data-table-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-card-icon" style="background: #f0fdf4; color: #16a34a; width: 34px; height: 34px;">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <h6 class="fw-bold mb-0 text-dark">{{ __('Helpful Tips') }}</h6>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex flex-column gap-3 text-muted fs-12">
                        <div class="d-flex gap-2">
                            <i class="fa-solid fa-paperclip text-primary mt-1"></i>
                            <span>{{ __('Attach screenshots to help us diagnose faster') }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <i class="fa-solid fa-clock text-warning mt-1"></i>
                            <span>{{ __('We check tickets every 2–4 hours on working days') }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <i class="fa-solid fa-check-double text-success mt-1"></i>
                            <span>{{ __('Once resolved, the ticket will be marked as closed') }}</span>
                        </div>
                    </div>
                </div>
            </div>
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
        if (input.files[0]) {
            preview.innerHTML = `<i class="fa-solid fa-file me-1"></i> ${input.files[0].name}`;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function appendMsg(msg) {
        const isSchool = msg.is_school_side;
        const bubbleClass = isSchool ? 'msg-school' : 'msg-system';
        const infoText = isSchool ? 'You' : 'System Support';

        const attachHtml = msg.attachment ?
            `<a href="${msg.attachment}" target="_blank" class="d-inline-flex align-items-center gap-1 mt-2 fw-semibold ${isSchool ? 'text-white' : 'text-primary'}" style="font-size:12px;text-decoration:underline;">
                <i class="fa-solid fa-paperclip"></i> File
            </a>` : '';

        const html = `
            <div class="msg-bubble ${bubbleClass}" data-id="${msg.id}" style="opacity:0; transform:translateY(6px); transition: all 0.3s;">
                <span class="msg-info">${infoText}</span>
                <div class="msg-content">${msg.message}</div>
                ${attachHtml}
                <div class="msg-time">${msg.time}</div>
            </div>
        `;

        const div = document.createElement('div');
        div.innerHTML = html;
        const el = div.firstElementChild;
        chatContainer.appendChild(el);

        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
            scrollToBottom();
        }, 10);

        lastId = msg.id;
    }

    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        const btn = $('#sendBtn');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    appendMsg(res.data);
                    $('#replyForm')[0].reset();
                    $('#msg-text').css('height', 'auto');
                    $('#file-preview').hide();
                }
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane fs-6"></i>');
            }
        });
    });

    setInterval(() => {
        $.get("{{ route('school.support.fetch', ['tenant' => $tenant, 'id' => $ticket->id]) }}", { last_id: lastId }, function(res) {
            res.data.forEach(msg => {
                if ($(`[data-id="${msg.id}"]`).length === 0) appendMsg(msg);
            });
        });
    }, 5000);

    $(function() { scrollToBottom(); });
</script>
@endsection
