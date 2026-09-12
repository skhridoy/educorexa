@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
    <style>
        /* ═════════════════════════════════════════════════════════════
           MESSAGING APP LAYOUT (WhatsApp / Telegram Style for School)
           ═════════════════════════════════════════════════════════════ */
        
        /* 1. Hide Website Footer & Alerts */
        footer.main-footer,
        .footer,
        .edu-sub-alert-wrapper,
        .sub-alert-wrapper {
            display: none !important;
        }

        /* 2. Lock page scroll and fill viewport */
        html, body {
            overflow: hidden !important;
            height: 100% !important;
        }
        .main-wrapper {
            height: 100vh !important;
            overflow: hidden !important;
        }
        .main-wrapper .page-wrapper {
            height: 100vh !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .main-wrapper .page-wrapper .page-content {
            padding: 0 !important;
            margin-top: 60px !important;
            height: calc(100vh - 60px) !important;
            max-height: calc(100vh - 60px) !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            background: #f0f2f5 !important;
        }

        /* 3. Fullscreen Chat Application Window */
        .chat-app-window {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            position: relative;
            overflow: hidden;
            background-color: #f0f2f5;
            background-image: radial-gradient(#cbd5e1 0.75px, transparent 0.75px);
            background-size: 16px 16px;
        }

        /* 4. Top Header Bar (Sticky / Fixed) */
        .chat-app-header {
            height: 64px;
            min-height: 64px;
            background: #ffffff;
            border-bottom: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
            z-index: 30;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            flex-shrink: 0;
        }
        .chat-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }
        .chat-back-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-shrink: 0;
        }
        .chat-back-btn:hover {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
        }
        .chat-header-avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        }
        .chat-status-dot {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #22c55e;
            border: 2px solid #ffffff;
        }
        .chat-header-info {
            min-width: 0;
        }
        .chat-header-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.98rem;
            color: #0f172a;
            margin: 0;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chat-header-sub {
            font-size: 0.76rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }
        .chat-role-pill {
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            font-size: 0.65rem;
            padding: 1px 7px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .chat-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* Status & Priority Pills */
        .btn-status-pill {
            font-weight: 700;
            font-size: 0.76rem;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
        }
        .status-open     { background: #eff6ff; color: #2563eb; }
        .status-pending  { background: #fef9c3; color: #a16207; }
        .status-resolved { background: #dcfce7; color: #15803d; }
        .status-closed   { background: #f1f5f9; color: #64748b; }

        .priority-badge {
            font-size: 0.74rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
        }
        .priority-high   { background: #fee2e2; color: #ef4444; }
        .priority-medium { background: #fef3c7; color: #d97706; }
        .priority-low    { background: #f0fdf4; color: #16a34a; }

        /* 5. Chat Feed Body (Scrollable Middle Area) */
        .chat-app-feed {
            flex: 1;
            overflow-y: auto;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        .chat-app-feed::-webkit-scrollbar { width: 5px; }
        .chat-app-feed::-webkit-scrollbar-track { background: transparent; }
        .chat-app-feed::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Date Separator Pill */
        .chat-date-separator {
            text-align: center;
            margin: 10px 0;
            position: relative;
        }
        .chat-date-separator span {
            background: #ffffff;
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* Pinned Ticket Origin Card */
        .ticket-origin-bubble {
            background: #ffffff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            padding: 16px 18px;
            margin-bottom: 8px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            position: relative;
        }
        .ticket-origin-bubble::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            background: linear-gradient(90deg, #4f46e5, #818cf8);
        }
        .origin-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }
        .origin-tag {
            font-size: 0.68rem;
            font-weight: 700;
            color: #4f46e5;
            background: #eef2ff;
            padding: 3px 9px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-transform: uppercase;
        }

        /* Message Bubbles (WhatsApp / Messenger Style) */
        .chat-bubble-row {
            display: flex;
            flex-direction: column;
            max-width: 78%;
            position: relative;
            animation: bubbleFade 0.2s ease;
        }
        @keyframes bubbleFade {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Incoming (Support Desk / Super Admin - Left) */
        .chat-bubble-row.incoming {
            align-self: flex-start;
        }
        .chat-bubble-row.incoming .chat-bubble {
            background: #ffffff;
            color: #1e293b;
            border-radius: 16px 16px 16px 4px;
            box-shadow: 0 1.5px 3px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            padding: 10px 14px;
        }
        .chat-bubble-row.incoming .bubble-sender {
            font-size: 0.72rem;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Outgoing (School Admin - You - Right) */
        .chat-bubble-row.outgoing {
            align-self: flex-end;
        }
        .chat-bubble-row.outgoing .chat-bubble {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            border-radius: 16px 16px 4px 16px;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.22);
            padding: 10px 14px;
        }
        .chat-bubble-row.outgoing .bubble-sender {
            font-size: 0.7rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 3px;
            text-align: right;
        }

        .bubble-text {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 0.91rem;
            line-height: 1.5;
            word-break: break-word;
            white-space: pre-wrap;
        }

        .bubble-meta {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            margin-top: 4px;
            font-size: 0.65rem;
        }
        .chat-bubble-row.incoming .bubble-meta {
            color: #94a3b8;
        }
        .chat-bubble-row.outgoing .bubble-meta {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Attachment Preview inside Bubble */
        .chat-bubble-attach {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .chat-bubble-row.incoming .chat-bubble-attach {
            background: #f1f5f9;
            color: #4f46e5;
            border: 1px solid #e2e8f0;
        }
        .chat-bubble-row.incoming .chat-bubble-attach:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
        }
        .chat-bubble-row.outgoing .chat-bubble-attach {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(4px);
        }
        .chat-bubble-row.outgoing .chat-bubble-attach:hover {
            background: rgba(255, 255, 255, 0.32);
        }

        /* 6. Messaging App Footer / Input Area (FIXED AT BOTTOM) */
        .chat-app-footer {
            flex-shrink: 0;
            background: #ffffff;
            border-top: 1.5px solid #e2e8f0;
            position: relative;
            z-index: 30;
            box-shadow: 0 -2px 10px rgba(15, 23, 42, 0.04);
        }

        /* Quick Reply Suggestion Chips */
        .chat-quick-bar {
            background: #f8fafc;
            padding: 8px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .chat-quick-bar::-webkit-scrollbar { display: none; }
        .chat-chip {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 0.74rem;
            font-weight: 600;
            color: #475569;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        .chat-chip:hover {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
        }

        /* File Selected Preview Strip */
        #file-preview {
            display: none;
            padding: 8px 16px;
            background: #eff6ff;
            border-bottom: 1px solid #bfdbfe;
            font-size: 0.8rem;
            color: #1d4ed8;
            align-items: center;
            justify-content: space-between;
        }

        /* Main Input Box Row */
        .chat-input-row {
            padding: 10px 16px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }
        .chat-attach-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            margin-bottom: 1px;
        }
        .chat-attach-btn:hover {
            background: #eef2ff;
            color: #4f46e5;
            border-color: #c7d2fe;
        }
        .chat-textarea-box {
            flex-grow: 1;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 22px;
            padding: 8px 16px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .chat-textarea-box:focus-within {
            background: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        .chat-textarea-box textarea {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.92rem;
            color: #1e293b;
            resize: none;
            padding: 2px 0;
            max-height: 100px;
            min-height: 24px;
            line-height: 1.4;
        }
        .chat-send-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.3);
            flex-shrink: 0;
            margin-bottom: 1px;
        }
        .chat-send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }
        .chat-send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Closed Banner */
        .chat-closed-banner {
            padding: 16px 20px;
            background: #f8fafc;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* 7. Mobile App Responsiveness */
        @media (max-width: 768px) {
            .chat-app-header {
                height: 58px;
                min-height: 58px;
                padding: 0 12px;
            }
            .chat-header-avatar {
                width: 36px;
                height: 36px;
                font-size: 0.95rem;
                border-radius: 12px;
            }
            .chat-header-title {
                font-size: 0.88rem;
                max-width: 140px;
            }
            .chat-header-sub {
                font-size: 0.7rem;
                max-width: 140px;
            }
            .chat-bubble-row {
                max-width: 88%;
            }
            .chat-app-feed {
                padding: 12px 10px;
                gap: 10px;
            }
            .chat-input-row {
                padding: 8px 10px;
                gap: 8px;
            }
            .chat-attach-btn {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
            .chat-send-btn {
                width: 40px;
                height: 40px;
                font-size: 0.95rem;
            }
            .btn-status-pill {
                padding: 4px 10px;
                font-size: 0.72rem;
            }
        }
    </style>
@endsection

@section('content')
{{-- Fullscreen Messaging App Container --}}
<div class="chat-app-window">

    {{-- ═════════════════════════════════════════════════════════════
         1. TOP APP HEADER (Fixed like WhatsApp/Telegram)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="chat-app-header">
        <div class="chat-header-left">
            {{-- Back to School Support Tickets --}}
            <a href="{{ route('school.support.index', $tenant) }}" class="chat-back-btn" title="{{ __('Back to All Tickets') }}">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            {{-- Support Desk Avatar --}}
            <div class="chat-header-avatar">
                <i class="fa-solid fa-headset"></i>
                <span class="chat-status-dot"></span>
            </div>

            {{-- Title & Status --}}
            <div class="chat-header-info">
                <h6 class="chat-header-title">
                    {{ __('EduCorexa Support Desk') }}
                </h6>
                <div class="chat-header-sub">
                    <span class="text-success fw-semibold"><i class="fa-solid fa-circle me-1" style="font-size:7px;"></i>{{ __('Support Agent Online') }}</span>
                    <span>•</span>
                    <span class="fw-bold text-dark">#{{ $ticket->ticket_id }}</span>
                </div>
            </div>
        </div>

        <div class="chat-header-right">
            {{-- Priority Badge --}}
            <span class="priority-badge priority-{{ $ticket->priority }} d-none d-sm-inline-flex">
                {{ ucfirst($ticket->priority) }}
            </span>

            {{-- Status Pill --}}
            <span class="btn-status-pill status-{{ $ticket->status }}">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                <span>{{ ucfirst($ticket->status) }}</span>
            </span>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════
         2. CHAT FEED (The scrollable conversation stream)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="chat-app-feed" id="chatContainer">

        {{-- Pinned Ticket Origin Card --}}
        <div class="ticket-origin-bubble">
            <div class="origin-title-row">
                <span class="origin-tag">
                    <i class="fa-solid fa-flag"></i> {{ __('Your Original Request') }}
                </span>
                <span class="text-muted small">
                    <i class="fa-regular fa-clock me-1"></i> {{ $ticket->created_at->format('d M Y, h:i A') }}
                </span>
            </div>
            <h6 class="fw-bold text-dark mb-2" style="font-size:1.02rem;">{{ $ticket->subject }}</h6>
            <div class="text-secondary" style="font-size:0.92rem; line-height:1.55; white-space: pre-wrap;">{{ $ticket->message }}</div>

            @if($ticket->attachment)
            <div class="mt-3 pt-2 border-top">
                <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="chat-bubble-attach" style="background:#f8fafc; color:#4f46e5; border:1px solid #e2e8f0;">
                    <i class="fa-solid fa-paperclip"></i>
                    <span>{{ __('Attached File') }}</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size:10px;"></i>
                </a>
            </div>
            @endif
        </div>

        {{-- Date Separator --}}
        <div class="chat-date-separator">
            <span>{{ __('Conversation Stream') }}</span>
        </div>

        {{-- Message History Stream --}}
        @foreach($ticket->replies as $reply)
            @php $isSchool = $reply->is_school_side; @endphp
            <div class="chat-bubble-row {{ $isSchool ? 'outgoing' : 'incoming' }}" data-id="{{ $reply->id }}">
                <div class="chat-bubble">
                    <div class="bubble-sender">
                        @if($isSchool)
                            {{ __('You (School Admin)') }}
                        @else
                            <i class="fa-solid fa-headset me-1 text-primary"></i> {{ __('EduCorexa Support Desk') }}
                        @endif
                    </div>

                    <div class="bubble-text">{{ $reply->message }}</div>

                    @if($reply->attachment)
                        <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" class="chat-bubble-attach">
                            <i class="fa-solid fa-paperclip"></i>
                            <span>{{ __('Download Attachment') }}</span>
                            <i class="fa-solid fa-arrow-down ms-1" style="font-size:10px;"></i>
                        </a>
                    @endif

                    <div class="bubble-meta">
                        <span>{{ $reply->created_at->format('h:i A') }}</span>
                        @if($isSchool)
                            <i class="fa-solid fa-check-double text-white" style="font-size:10px;"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- ═════════════════════════════════════════════════════════════
         3. CHAT FOOTER (FIXED AT BOTTOM LIKE MESSAGING APP)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="chat-app-footer">
        @if($ticket->status != 'closed')
            {{-- Quick Response Chips --}}
            <div class="chat-quick-bar">
                <span class="text-muted fw-bold d-flex align-items-center me-1" style="font-size:0.72rem;">
                    <i class="fa-solid fa-bolt text-warning me-1"></i> {{ __('Quick') }}:
                </span>
                <span class="chat-chip" onclick="setQuickReply('হ্যাঁ, সমস্যাটি সমাধান হয়েছে। অনেক ধন্যবাদ!')">
                    ✅ সমস্যা সমাধান হয়েছে
                </span>
                <span class="chat-chip" onclick="setQuickReply('সমস্যাটি এখনও রয়ে গেছে, দয়া করে আবার একটু চেক করুন।')">
                    ⚠️ এখনও সমস্যা হচ্ছে
                </span>
                <span class="chat-chip" onclick="setQuickReply('আমি বিস্তারিত স্ক্রিনশট সংযুক্ত করে দিয়েছি।')">
                    📎 স্ক্রিনশট পাঠাচ্ছি
                </span>
                <span class="chat-chip" onclick="setQuickReply('দ্রুত রেসপন্স করার জন্য ধন্যবাদ!')">
                    🙏 ধন্যবাদ
                </span>
            </div>

            {{-- File Preview Strip (if file selected) --}}
            <div id="file-preview">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-file-arrow-up text-primary"></i>
                    <span id="file-preview-name" class="fw-semibold">File selected</span>
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none" onclick="removeFile()" title="Cancel attachment">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
            </div>

            {{-- Message Input Form --}}
            <form action="{{ route('school.support.reply', ['tenant' => $tenant, 'id' => $ticket->id]) }}" method="POST" enctype="multipart/form-data" id="replyForm" class="m-0">
                @csrf
                <div class="chat-input-row">
                    {{-- Attach File Button --}}
                    <label for="chat-file" class="chat-attach-btn" title="{{ __('Attach file or screenshot') }}">
                        <i class="fa-solid fa-paperclip"></i>
                    </label>
                    <input type="file" name="attachment" id="chat-file" class="d-none" onchange="updateFileName(this)">

                    {{-- Textarea Input --}}
                    <div class="chat-textarea-box">
                        <textarea name="message" id="msg-text" rows="1" placeholder="{{ __('Type your reply to Support Desk... (Press Enter to send)') }}" required oninput="expandInput(this)"></textarea>
                    </div>

                    {{-- Send Button --}}
                    <button type="submit" class="chat-send-btn" id="sendBtn" title="{{ __('Send') }}">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        @else
            {{-- Ticket Closed Banner --}}
            <div class="chat-closed-banner">
                <div class="d-flex align-items-center gap-2 text-muted">
                    <i class="fa-solid fa-lock text-secondary"></i>
                    <span class="small fw-bold">{{ __('This support ticket is closed.') }}</span>
                </div>
                <a href="{{ route('school.support.create', $tenant) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                    <i class="fa-solid fa-plus me-1"></i> {{ __('Open New Ticket') }}
                </a>
            </div>
        @endif
    </div>

</div>
@endsection

@section('customJs')
<script>
    let lastId = {{ $ticket->replies->last() ? $ticket->replies->last()->id : 0 }};
    const chatContainer = document.getElementById('chatContainer');

    function expandInput(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 100) + 'px';
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
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }

    // Submit on Enter without Shift
    $('#msg-text').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#replyForm').submit();
        }
    });

    function appendMsg(msg) {
        const isSchool = msg.is_school_side;
        const rowClass = isSchool ? 'outgoing' : 'incoming';
        const senderName = isSchool ? 'You (School Admin)' : 'EduCorexa Support Desk';
        
        const attachHtml = msg.attachment ? 
            `<a href="${msg.attachment}" target="_blank" class="chat-bubble-attach">
                <i class="fa-solid fa-paperclip"></i>
                <span>Download Attachment</span>
                <i class="fa-solid fa-arrow-down ms-1" style="font-size:10px;"></i>
            </a>` : '';

        const checkHtml = isSchool ? `<i class="fa-solid fa-check-double text-white" style="font-size:10px;"></i>` : '';

        const html = `
            <div class="chat-bubble-row ${rowClass}" data-id="${msg.id}">
                <div class="chat-bubble">
                    <div class="bubble-sender">${senderName}</div>
                    <div class="bubble-text">${msg.message}</div>
                    ${attachHtml}
                    <div class="bubble-meta">
                        <span>${msg.time}</span>
                        ${checkHtml}
                    </div>
                </div>
            </div>
        `;
        
        const div = document.createElement('div');
        div.innerHTML = html;
        const el = div.firstElementChild;
        chatContainer.appendChild(el);
        
        scrollToBottom();
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
                if (res.success) {
                    appendMsg(res.data);
                    $('#replyForm')[0].reset();
                    $('#msg-text').css('height', 'auto');
                    removeFile();
                }
            },
            complete: function() { btn.prop('disabled', false); }
        });
    });

    // Auto-polling for new replies every 4 seconds
    setInterval(() => {
        $.get("{{ route('school.support.fetch', ['tenant' => $tenant, 'id' => $ticket->id]) }}", { last_id: lastId }, function(res) {
            if (res && res.data) {
                res.data.forEach(msg => {
                    if ($(`[data-id="${msg.id}"]`).length === 0) appendMsg(msg);
                });
            }
        });
    }, 4000);

    $(function() { scrollToBottom(); });
</script>
@endsection
