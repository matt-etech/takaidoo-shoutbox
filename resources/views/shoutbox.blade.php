<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Takaidoo Shoutbox </title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #111b21;
            color: #e9edef;
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: #202c33;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 1px solid #2a3942;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,.35);
            z-index: 10;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .chat-header-info h1 {
            font-size: 16px;
            font-weight: 600;
            color: #e9edef;
        }

        .chat-header-info p {
            font-size: 12px;
            color: #8696a0;
        }

        .flash {
            background: #25d366;
            color: #111b21;
            text-align: center;
            padding: 8px;
            font-size: 13px;
            font-weight: 600;
            flex-shrink: 0;
            animation: fadeOut 3s forwards;
        }

        @keyframes fadeOut {
            0%   { opacity: 1; }
            70%  { opacity: 1; }
            100% { opacity: 0; }
        }

        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            background-color: #0b141a;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23182229' fill-opacity='0.6'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .messages-area::-webkit-scrollbar { width: 6px; }
        .messages-area::-webkit-scrollbar-track { background: transparent; }
        .messages-area::-webkit-scrollbar-thumb { background: #374045; border-radius: 4px; }

        .date-divider {
            text-align: center;
            font-size: 11px;
            color: #8696a0;
            background: #182229cc;
            border-radius: 8px;
            padding: 4px 10px;
            align-self: center;
            margin: 10px 0;
        }

        /* ─── Bubble wrapper ────────────────────────────────────────── */
        .bubble-wrap {
            display: flex;
            flex-direction: column;
            max-width: 68%;
            position: relative;
        }

        .bubble-wrap.mine  { align-self: flex-end;  align-items: flex-end; }
        .bubble-wrap.other { align-self: flex-start; align-items: flex-start; }

        /* username label */
        .bubble-username {
            font-size: 11px;
            font-weight: 600;
            color: #53bdeb;
            margin-bottom: 2px;
            padding: 0 4px;
        }

        .bubble-wrap.mine .bubble-username { color: #25d366; }

        /* bubble itself */
        .bubble {
            position: relative;
            padding: 8px 12px 22px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
            box-shadow: 0 1px 2px rgba(0,0,0,.4);
        }

        .bubble-wrap.mine  .bubble {
            background: #005c4b;
            border-top-right-radius: 2px;
            color: #e9edef;
        }

        .bubble-wrap.other .bubble {
            background: #202c33;
            border-top-left-radius: 2px;
            color: #e9edef;
        }

        /* timestamp + delete row inside bubble */
        .bubble-meta {
            position: absolute;
            bottom: 5px;
            right: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bubble-time {
            font-size: 10px;
            color: #8696a0;
            white-space: nowrap;
        }

        /* delete button */
        .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #8696a0;
            font-size: 12px;
            padding: 0;
            line-height: 1;
            transition: color .2s;
        }

        .delete-btn:hover { color: #ef4444; }

        /* ─── Input area ────────────────────────────────────────────── */
        .input-area {
            background: #202c33;
            padding: 12px 16px;
            border-top: 1px solid #2a3942;
            flex-shrink: 0;
        }

        /* validation errors */
        .errors {
            background: #2a1a1a;
            border: 1px solid #ef444455;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 10px;
            font-size: 13px;
            color: #fca5a5;
        }

        .errors ul { padding-left: 16px; }

        /* form layout */
        .shout-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .form-fields {
            flex: 1;
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .field-group label {
            font-size: 11px;
            color: #8696a0;
            font-weight: 500;
        }

        .field-group input,
        .field-group textarea {
            background: #2a3942;
            border: 1px solid #374045;
            border-radius: 8px;
            color: #e9edef;
            font-family: inherit;
            font-size: 14px;
            padding: 10px 14px;
            outline: none;
            transition: border-color .2s;
        }

        .field-group input:focus,
        .field-group textarea:focus {
            border-color: #25d366;
        }

        .field-group input::placeholder,
        .field-group textarea::placeholder { color: #8696a0; }

        .field-group.username-field input { width: 150px; }

        .field-group.message-field { flex: 1; }
        .field-group.message-field textarea {
            width: 100%;
            resize: none;
            height: 44px;
            line-height: 1.4;
        }

        /* send button */
        .send-btn {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: none;
            background: #25d366;
            color: #111b21;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .2s, transform .15s;
        }

        .send-btn:hover { background: #20ba5a; transform: scale(1.05); }
        .send-btn:active { transform: scale(.95); }

        /* char counter */
        .char-hint {
            font-size: 10px;
            color: #8696a0;
            text-align: right;
            margin-top: 2px;
        }

        /* ─── Empty state ────────────────────────────────────────────── */
        .empty-state {
            text-align: center;
            color: #8696a0;
            margin: auto;
            font-size: 14px;
        }

        .empty-state .icon { font-size: 48px; margin-bottom: 10px; }

        /* ─── Responsive ────────────────────────────────────────────── */
        @media (max-width: 600px) {
            .form-fields { flex-direction: column; }
            .field-group.username-field input { width: 100%; }
            .bubble-wrap { max-width: 85%; }
        }
    </style>
</head>
<body>

{{-- ── Header ──────────────────────────────────────────────────────── --}}
<div class="chat-header">
    <div class="avatar">💬</div>
    <div class="chat-header-info">
        <h1>Takaidoo Shoutbox</h1>
        <p>{{ $shouts->count() }} {{ Str::plural('message', $shouts->count()) }}</p>
    </div>
</div>

{{-- ── Flash ───────────────────────────────────────────────────────── --}}
@if (session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif

{{-- ── Messages ─────────────────────────────────────────────────────── --}}
<div class="messages-area" id="messagesArea">

    @forelse ($shouts as $shout)

        {{-- Alternate: treat every other username as "mine" for demo; real app
             would compare against auth()->user()->name --}}
        @php $isMine = ($loop->index % 2 === 0); @endphp

        <div class="bubble-wrap {{ $isMine ? 'mine' : 'other' }}">
            <div class="bubble-username">{{ e($shout->username) }}</div>

            <div class="bubble">
                {{ e($shout->message) }}

                <div class="bubble-meta">
                    <span class="bubble-time">
                        {{ $shout->created_at->format('H:i') }}
                    </span>

                    {{-- Delete form --}}
                    <form method="POST"
                          action="{{ route('shouts.destroy', $shout) }}"
                          onsubmit="return confirm('Delete this shout?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="Delete">🗑</button>
                    </form>
                </div>
            </div>
        </div>

    @empty
        <div class="empty-state">
            <div class="icon">🔇</div>
            <p>No shouts yet.<br>Be the first to say something!</p>
        </div>
    @endforelse

</div>

{{-- ── Input area ───────────────────────────────────────────────────── --}}
<div class="input-area">

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="shout-form"
          method="POST"
          action="{{ route('shouts.store') }}">
        @csrf

        <div class="form-fields">
            {{-- Username --}}
            <div class="field-group username-field">
                <label for="username">Your name</label>
                <input id="username"
                       type="text"
                       name="username"
                       placeholder="Username"
                       value="{{ old('username') }}"
                       maxlength="50"
                       required />
            </div>

            {{-- Message --}}
            <div class="field-group message-field">
                <label for="message">Message</label>
                <textarea id="message"
                          name="message"
                          placeholder="Type a message…"
                          maxlength="255"
                          required>{{ old('message') }}</textarea>
                <div class="char-hint">
                    <span id="charCount">0</span>/255
                </div>
            </div>
        </div>

        <button type="submit" class="send-btn" title="Send">➤</button>
    </form>
</div>

<script>
    // ── Character counter ───────────────────────────────────────────
    const textarea  = document.getElementById('message');
    const charCount = document.getElementById('charCount');

    textarea.addEventListener('input', () => {
        charCount.textContent = textarea.value.length;
    });

    // ── Auto-expand textarea ───────────────────────────────────────
    textarea.addEventListener('input', function () {
        this.style.height = '44px';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // ── Send on Ctrl/Cmd + Enter ───────────────────────────────────
    textarea.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            this.closest('form').submit();
        }
    });

    // ── Auto-dismiss flash ─────────────────────────────────────────
    const flash = document.querySelector('.flash');
    if (flash) setTimeout(() => flash.remove(), 3200);
</script>

</body>
</html>
