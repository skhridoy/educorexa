@extends('layouts.main')

@section('customCSS')
@include('layouts._shared_styles')
<style>
    /* Premium Chat Layout */
    .chat-wrapper {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(15, 23, 42, 0.06);
        border: 1.5px solid #f1f5f9;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Top Chat Header */
    .chat-box-header {
        background: #ffffff;
        padding: 16px 24px;
        border-bottom: 1.5px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .chat-user-profile {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .chat-user-avatar {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eef2ff, #c7d2fe);
        color: #4f46e5;
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
        border: 2px solid #e0e7ff;
    }
    .chat-online-dot {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #22c55e;
        border: 2px solid #ffffff;
    }
    .chat-user-meta h5 {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0f172a;
        margin: 0 0 2px 0;
        line-height: 1.2;
    }
    .chat-user-sub {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* Chat Messages Container */
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding: 24px;
        max-height: 580px;
        min-height: 400px;
        overflow-y: auto;
        background: #f8fafc;
        scroll-behavior: smooth;
    }
    .chat-container::-webkit-scrollbar { width: 6px; }
    .chat-container::-webkit-scrollbar-track { background: #f1f5f9; }
    .chat-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .chat-container::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Initial Ticket Request Card (Origin) */
    .ticket-origin-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 8px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        position: relative;
    }
    .ticket-origin-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        background: linear-gradient(90deg, #4f46e5, #818cf8);
    }
    .origin-badge {
        font-size: 0.72rem;
        font-weight: 700;
        color: #4f46e5;
        background: #eef2ff;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Message Rows & Avatars */
    .chat-msg-row {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        max-width: 80%;
    }
    .chat-msg-row.school {
        align-self: flex-start;
    }
    .chat-msg-row.system {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .msg-avatar {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
    .msg-avatar.school {
        background: #e2e8f0;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .msg-avatar.system {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #ffffff;
        border: 1.5px solid #4338ca;
    }

    /* Message Content Area */
    .msg-content-wrap {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }
    .chat-msg-row.school .msg-content-wrap {
        align-items: flex-start;
    }
    .chat-msg-row.system .msg-content-wrap {
        align-items: flex-end;
    }

    .msg-sender-name {
        font-size: 0.72rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .chat-role-tag {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .chat-role-tag.school {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .chat-role-tag.admin {
        background: #eef2ff;
        color: #4f46e5;
        border: 1px solid #c7d2fe;
    }

    /* Bubble Styles */
    .msg-bubble {
        padding: 12px 18px;
        border-radius: 18px;
        font-family: 'Outfit', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.55;
        font-size: 0.92rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        position: relative;
        word-break: break-word;
    }
    .chat-msg-row.school .msg-bubble {
        background: #ffffff;
        color: #1e293b;
        border-bottom-left-radius: 4px;
        border: 1.5px solid #e2e8f0;
    }
    .chat-msg-row.system .msg-bubble {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.22);
    }

    /* Time & Status inside row */
    .msg-timestamp {
        font-size: 0.68rem;
        color: #94a3b8;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .chat-msg-row.system .msg-timestamp {
        color: #94a3b8;
        justify-content: flex-end;
    }

    /* Attachment Card */
    .msg-attach-card {
        margin-top: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .chat-msg-row.school .msg-attach-card {
        background: #f8fafc;
        color: #4f46e5;
        border: 1.5px solid #e2e8f0;
    }
    .chat-msg-row.school .msg-attach-card:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
    }
    .chat-msg-row.system .msg-attach-card {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(4px);
    }
    .chat-msg-row.system .msg-attach-card:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Quick Reply Chips */
    .quick-replies-bar {
        background: #f8fafc;
        padding: 10px 24px;
        border-top: 1.5px solid #f1f5f9;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .quick-reply-chip {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .quick-reply-chip:hover {
        background: #eef2ff;
        color: #4f46e5;
        border-color: #c7d2fe;
        transform: translateY(-1px);
    }

    /* Footer Reply Area */
    .reply-area {
        background: #ffffff;
        padding: 16px 24px;
        border-top: 1.5px solid #f1f5f9;
    }
    .reply-box-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .reply-box-wrapper:focus-within {
        border-color: #4f46e5;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }

    .reply-input-field {
        flex-grow: 1;
    }
    .reply-input-field textarea {
        border: none;
        resize: none;
        padding: 6px 4px;
        font-size: 0.92rem;
        background: transparent;
        width: 100%;
        color: #1e293b;
        display: block;
        max-height: 120px;
        min-height: 38px;
        outline: none !important;
        box-shadow: none !important;
    }

    /* Circle Buttons */
    .btn-circle {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        flex-shrink: 0;
    }
    .btn-chat-send {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-chat-send:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }
    .btn-chat-attach {
        background: #ffffff;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        margin: 0;
    }
    .btn-chat-attach:hover {
        color: #4f46e5;
        background: #eef2ff;
        border-color: #c7d2fe;
    }

    /* File Preview Bar */
    #file-preview {
        display: none;
        padding: 8px 14px;
        background: #eff6ff;
        border-radius: 12px;
        margin-bottom: 12px;
        font-size: 0.8rem;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        align-items: center;
        justify-content: space-between;
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

    /* Closed Ticket Alert */
    .closed-ticket-banner {
        background: #f8fafc;
        border-top: 1.5px solid #f1f5f9;
        padding: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .chat-msg-row { max-width: 92%; }
        .chat-container { padding: 16px 12px; }
        .chat-box-header { padding: 14px 16px; }
        .reply-area { padding: 12px 14px; }
        .show-header-wrap {
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
        .show-header-wrap .btn-edu {
            justify-content: center;
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

        {{-- ===== PAGE TITLE & ACTIONS ===== --}}
        <div class="d-flex justify-content-between align-items-center mb-4 show-header-wrap">
            <div>
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h3 class="fw-bold mb-0 text-dark" style="font-family: 'Outfit';">
                        {{ $ticket->subject }}
                    </h3>
                    <span class="badge-id">#{{ $ticket->ticket_id }}</span>
                    <span class="priority-pill priority-{{ $ticket->priority }}">
                        <i class="fa-solid fa-flag" style="font-size:10px;"></i> {{ ucfirst($ticket->priority) }} Priority
                    </span>
                </div>
                <p class="text-muted small mb-0 d-flex align-items-center gap-2 flex-wrap">
                    <span><i class="fa-solid fa-school text-primary me-1"></i><strong>{{ $ticket->school->name ?? 'General' }}</strong></span>
                    <span>•</span>
                    <span><i class="fa-regular fa-user me-1"></i>{{ $ticket->user->name ?? 'School Admin' }}</span>
                    <span>•</span>
                    <span><i class="fa-regular fa-clock me-1"></i>{{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('manage.support.index') }}" class="btn-edu btn-edu-light">
                    <i class="fa-solid fa-arrow-left"></i> Back to Desk
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

        {{-- ===== CHAT WRAPPER ===== --}}
        <div class="chat-wrapper">
            {{-- Chatbox Header Info Bar --}}
            <div class="chat-box-header">
                <div class="chat-user-profile">
                    <div class="chat-user-avatar">
                        {{ strtoupper(substr($ticket->school->name ?? 'S', 0, 1)) }}
                        <span class="chat-online-dot"></span>
                    </div>
                    <div class="chat-user-meta">
                        <h5>{{ $ticket->school->name ?? 'School Tenant' }}</h5>
                        <div class="chat-user-sub">
                            <span><i class="fa-regular fa-user text-indigo me-1"></i>{{ $ticket->user->name ?? 'School Admin' }}</span>
                            <span>•</span>
                            <span class="chat-role-tag school">School Admin</span>
                            <span>•</span>
                            <span>{{ $ticket->user->email ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge" style="background:#eef2ff; color:#4f46e5; font-size:0.75rem; font-weight:700; padding:6px 12px; border-radius:20px;">
                        <i class="fa-regular fa-comments me-1"></i> {{ $ticket->replies->count() }} Replies
                    </span>
                </div>
            </div>

            {{-- Chat Conversation Container --}}
            <div class="chat-container" id="chatContainer">
                {{-- 1. Initial Ticket Origin Card --}}
                <div class="ticket-origin-card">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <span class="origin-badge">
                            <i class="fa-solid fa-circle-question"></i> Original Ticket Request
                        </span>
                        <span class="text-muted small">
                            <i class="fa-regular fa-clock me-1"></i> {{ $ticket->created_at->format('d M Y, h:i A') }}
                        </span>
                    </div>
                    <h6 class="fw-bold text-dark mb-2" style="font-size:1rem;">{{ $ticket->subject }}</h6>
                    <div class="text-secondary" style="font-size:0.92rem; line-height:1.6; white-space: pre-wrap;">{{ $ticket->message }}</div>

                    @if($ticket->attachment)
                    <div class="mt-3 pt-2 border-top">
                        <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="msg-attach-card" style="background:#f1f5f9; color:#4f46e5; border:1px solid #e2e8f0;">
                            <i class="fa-solid fa-paperclip"></i>
                            <span>Attached File (Click to View)</span>
                            <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size:11px;"></i>
                        </a>
                    </div>
                    @endif
                </div>

                {{-- 2. Message History --}}
                @foreach($ticket->replies as $reply)
                    @php $isSystem = !$reply->is_school_side; @endphp
                    <div class="chat-msg-row {{ $isSystem ? 'system' : 'school' }}" data-id="{{ $reply->id }}">
                        {{-- Sender Avatar --}}
                        <div class="msg-avatar {{ $isSystem ? 'system' : 'school' }}">
                            @if($isSystem)
                                <i class="fa-solid fa-headset"></i>
                            @else
                                {{ strtoupper(substr($reply->user->name ?? 'S', 0, 1)) }}
                            @endif
                        </div>

                        {{-- Bubble & Content --}}
                        <div class="msg-content-wrap">
                            <div class="msg-sender-name">
                                <span>{{ $isSystem ? 'You (Support Desk)' : $reply->user->name }}</span>
                                <span class="chat-role-tag {{ $isSystem ? 'admin' : 'school' }}">
                                    {{ $isSystem ? 'Support Admin' : 'School' }}
                                </span>
                            </div>

                            <div class="msg-bubble">
                                <div class="msg-text">{{ $reply->message }}</div>

                                @if($reply->attachment)
                                    <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" class="msg-attach-card">
                                        <i class="fa-solid fa-paperclip"></i>
                                        <span>Download File</span>
                                        <i class="fa-solid fa-arrow-down ms-1" style="font-size:10px;"></i>
                                    </a>
                                @endif
                            </div>

                            <div class="msg-timestamp">
                                <span>{{ $reply->created_at->format('h:i A') }}</span>
                                <i class="fa-solid fa-check-double text-primary" style="font-size:10px;"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 3. Quick Reply Suggestion Chips --}}
            @if($ticket->status != 'closed')
            <div class="quick-replies-bar">
                <span class="text-muted small fw-bold d-flex align-items-center me-1" style="font-size:0.72rem;">
                    <i class="fa-solid fa-bolt text-warning me-1"></i> Quick:
                </span>
                <span class="quick-reply-chip" onclick="setQuickReply('Thank you for reaching out! We are currently investigating this issue and will update you shortly.')">
                    Investigating
                </span>
                <span class="quick-reply-chip" onclick="setQuickReply('The issue has been resolved. Please verify from your dashboard.')">
                    Resolved & verified
                </span>
                <span class="quick-reply-chip" onclick="setQuickReply('Could you please provide a screenshot or additional details to help us investigate?')">
                    Need more info
                </span>
                <span class="quick-reply-chip" onclick="setQuickReply('Our technical team has deployed the fix. Thank you for your patience!')">
                    Fix deployed
                </span>
            </div>

            {{-- 4. Reply Input Form --}}
            <div class="reply-area">
                <div id="file-preview">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-circle-check text-primary"></i>
                        <span id="file-preview-name">File attached</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" onclick="removeFile()" title="Remove">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('manage.support.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" id="replyForm">
                    @csrf
                    <div class="reply-box-wrapper">
                        <label for="chat-file" class="btn-circle btn-chat-attach" title="Attach image or file">
                            <i class="fa-solid fa-paperclip"></i>
                        </label>
                        <input type="file" name="attachment" id="chat-file" class="d-none" onchange="updateFileName(this)">
                        
                        <div class="reply-input-field">
                            <textarea name="message" id="msg-text" rows="1" placeholder="Type your response to school administrator... (Press Enter to send)" required oninput="expandInput(this)"></textarea>
                        </div>
                        
                        <button type="submit" class="btn-circle btn-chat-send" id="sendBtn" title="Send Response">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
            @else
            {{-- Closed Ticket Notice --}}
            <div class="closed-ticket-banner">
                <i class="fa-solid fa-circle-check text-success fa-2x mb-2"></i>
                <h6 class="fw-bold text-dark mb-1">This ticket is marked as Closed</h6>
                <p class="text-muted small mb-3">No further replies can be posted unless the ticket is reopened.</p>
                <form action="{{ route('manage.support.status', $ticket->id) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="status" value="open">
                    <button type="submit" class="btn-edu btn-edu-outline btn-sm">
                        <i class="fa-solid fa-envelope-open-text me-1"></i> Reopen Ticket
                    </button>
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
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    }

    function setQuickReply(text) {
        const textarea = document.getElementById('msg-text');
        if (textarea) {
            textarea.value = text;
            textarea.focus();
            expandInput(textarea);
        }
    }

    function updateFileName(input) {
        const preview = document.getElementById('file-preview');
        const nameEl = document.getElementById('file-preview-name');
        if (input.files && input.files[0]) {
            nameEl.textContent = input.files[0].name + ' (' + (input.files[0].size / 1024).toFixed(1) + ' KB)';
            preview.style.display = 'flex';
        } else {
            preview.style.display = 'none';
        }
    }

    function removeFile() {
        const input = document.getElementById('chat-file');
        if (input) input.value = '';
        const preview = document.getElementById('file-preview');
        if (preview) preview.style.display = 'none';
    }

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Submit on Enter without Shift
    $('#msg-text').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#replyForm').submit();
        }
    });

    function appendMsg(msg) {
        const isSystem = !msg.is_school_side;
        const rowClass = isSystem ? 'system' : 'school';
        const senderName = isSystem ? 'You (Support Desk)' : msg.user_name;
        const roleTag = isSystem ? '<span class="chat-role-tag admin">Support Admin</span>' : '<span class="chat-role-tag school">School</span>';
        const avatarHtml = isSystem ? 
            `<div class="msg-avatar system"><i class="fa-solid fa-headset"></i></div>` : 
            `<div class="msg-avatar school">${(msg.user_name || 'S').charAt(0).toUpperCase()}</div>`;
        
        const attachHtml = msg.attachment ? 
            `<a href="${msg.attachment}" target="_blank" class="msg-attach-card">
                <i class="fa-solid fa-paperclip"></i>
                <span>Download File</span>
                <i class="fa-solid fa-arrow-down ms-1" style="font-size:10px;"></i>
            </a>` : '';

        const html = `
            <div class="chat-msg-row ${rowClass}" data-id="${msg.id}" style="opacity:0; transform:translateY(8px); transition: all 0.25s ease;">
                ${avatarHtml}
                <div class="msg-content-wrap">
                    <div class="msg-sender-name">
                        <span>${senderName}</span>
                        ${roleTag}
                    </div>
                    <div class="msg-bubble">
                        <div class="msg-text">${msg.message}</div>
                        ${attachHtml}
                    </div>
                    <div class="msg-timestamp">
                        <span>${msg.time}</span>
                        <i class="fa-solid fa-check-double text-primary" style="font-size:10px;"></i>
                    </div>
                </div>
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
        const msgVal = $('#msg-text').val().trim();
        const fileVal = $('#chat-file').val();
        if (!msgVal && !fileVal) return;

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
                    removeFile();
                }
            },
            complete: function() { btn.prop('disabled', false); }
        });
    });

    // Auto-polling for new replies every 5 seconds
    setInterval(() => {
        $.get("{{ route('manage.support.fetch', $ticket->id) }}", { last_id: lastId }, function(res) {
            if (res && res.data) {
                res.data.forEach(msg => {
                    if($(`[data-id="${msg.id}"]`).length === 0) appendMsg(msg);
                });
            }
        });
    }, 5000);

    $(function() { scrollToBottom(); });
</script>
@endsection
