@extends('layouts.school')

@section('customCSS')
<style>
    /* Premium Chat Layout */
    .chat-wrapper {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
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

    /* Bubble Styles - Refined for Academic Elite */
    .msg-bubble {
        padding: 12px 18px;
        border-radius: 18px;
        width: fit-content;
        max-width: 75%;
        position: relative;
        font-family: 'Inter', sans-serif;
        line-height: 1.5;
        font-size: 0.92rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    /* School Messages (Right - Indigo) */
    .msg-school {
        align-self: flex-end;
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
    }

    /* System Messages (Left - Greyish) */
    .msg-system {
        align-self: flex-start;
        background: #ffffff;
        color: #334155;
        border-bottom-left-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    .msg-info {
        font-size: 0.65rem;
        margin-bottom: 4px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    .msg-school .msg-info { color: rgba(255,255,255,0.85); text-align: right; }
    .msg-system .msg-info { color: #64748b; }

    .msg-content { word-break: break-word; }

    .msg-time { font-size: 0.62rem; margin-top: 6px; opacity: 0.7; }
    .msg-school .msg-time { text-align: right; color: rgba(255,255,255,0.8); }
    .msg-system .msg-time { text-align: left; color: #94a3b8; }

    /* Footer - Restored Footer Design */
    .reply-area {
        background: #ffffff;
        padding: 15px 25px;
        border-top: 1px solid #f1f5f9;
    }
    .reply-box-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f1f5f9;
        padding: 5px 8px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
    }
    .reply-box-wrapper:focus-within {
        border-color: #4f46e5;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.05);
    }

    .reply-input-field {
        flex-grow: 1;
    }
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
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-chat-send { background: #4f46e5; color: white; }
    .btn-chat-send:hover { transform: scale(1.05); background: #4338ca; }
    .btn-chat-attach { background: #fff; color: #64748b; border: 1px solid #e2e8f0; }
    .btn-chat-attach:hover { color: #4f46e5; background: #f8fafc; }

    #file-preview {
        display: none;
        padding: 6px 15px;
        background: #eff6ff;
        border-radius: 8px;
        margin-bottom: 10px;
        font-size: 0.75rem;
        color: #1d4ed8;
        border-left: 3px solid #3b82f6;
    }

    @media (max-width: 768px) {
        .msg-bubble { max-width: 88%; }
        .chat-container { padding: 15px; }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="font-family: 'Outfit';">Academic Elite Support</h4>
            <p class="text-muted small mb-0"><i data-feather="hash" class="icon-sm"></i> {{ $ticket->ticket_id }} • {{ ucfirst($ticket->status) }}</p>
        </div>
        <a href="{{ route('school.support.index', $tenant) }}" class="btn btn-white btn-sm shadow-sm rounded-pill px-3">
            <i data-feather="arrow-left" class="icon-sm me-1"></i> Back
        </a>
    </div>

    <div class="chat-wrapper">
        <div class="chat-container" id="chatContainer">
            {{-- Ticket Initial Message --}}
            <div class="msg-bubble msg-school">
                <span class="msg-info">You</span>
                <div class="msg-content">{{ $ticket->message }}</div>
                @if($ticket->attachment)
                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn btn-xs btn-white bg-opacity-25 text-white mt-2 border-0">
                        <i data-feather="file" class="icon-xs"></i> Attachment
                    </a>
                @endif
                <div class="msg-time">{{ $ticket->created_at->format('d M, h:i A') }}</div>
            </div>

            {{-- ALL REPLIES GO DIRECTLY HERE --}}
            @foreach($ticket->replies as $reply)
                <div class="msg-bubble {{ $reply->is_school_side ? 'msg-school' : 'msg-system' }} mb-3" data-id="{{ $reply->id }}">
                    <span class="msg-info">{{ $reply->is_school_side ? 'You' : 'System Support' }}</span>
                    <div class="msg-content">{{ $reply->message }}</div>
                    @if($reply->attachment)
                        <a href="{{ asset('storage/' . $reply->attachment) }}" target="_blank" class="btn btn-xs mt-2 d-inline-flex align-items-center {{ $reply->is_school_side ? 'btn-white bg-opacity-25 text-white' : 'btn-light border' }}">
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
                <form action="{{ route('school.support.reply', ['tenant' => $tenant, 'id' => $ticket->id]) }}" method="POST" enctype="multipart/form-data" id="replyForm">
                    @csrf
                    <div class="reply-box-wrapper">
                        <label for="chat-file" class="btn-circle btn-chat-attach">
                            <i data-feather="paperclip" class="icon-sm"></i>
                        </label>
                        <input type="file" name="attachment" id="chat-file" class="d-none" onchange="updateFileName(this)">
                        
                        <div class="reply-input-field">
                            <textarea name="message" id="msg-text" rows="1" placeholder="Type your message..." required oninput="expandInput(this)"></textarea>
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
        const isSchool = msg.is_school_side;
        const bubbleClass = isSchool ? 'msg-school' : 'msg-system';
        const infoText = isSchool ? 'You' : 'System Support';
        
        const attachHtml = msg.attachment ? 
            `<a href="${msg.attachment}" target="_blank" class="btn btn-xs mt-2 d-inline-flex align-items-center ${isSchool ? 'btn-white bg-opacity-25 text-white' : 'btn-light border'}">
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
        $.get("{{ route('school.support.fetch', ['tenant' => $tenant, 'id' => $ticket->id]) }}", { last_id: lastId }, function(res) {
            res.data.forEach(msg => {
                if($(`[data-id="${msg.id}"]`).length === 0) appendMsg(msg);
            });
        });
    }, 5000);

    $(function() { scrollToBottom(); if(window.feather) feather.replace(); });
</script>
@endsection
