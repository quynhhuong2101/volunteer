@extends('layouts.student')

@section('header', 'Thảo luận nhóm')

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col mx-auto max-w-5xl" x-data="chatRoom()">
    
    <!-- Chat Container -->
    <div class="flex-1 bg-white rounded-t-3xl shadow-sm border border-slate-100 flex flex-col overflow-hidden relative">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-white border-b border-slate-100 flex items-center justify-between z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="javascript:history.back()" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h2 class="font-bold text-slate-800 text-lg line-clamp-1">{{ $event['name'] }}</h2>
                    <div class="flex items-center text-xs text-slate-500 font-medium">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                        {{ $event['members_count'] }} thành viên
                    </div>
                </div>
            </div>
            
            <!-- Group Info / Settings (future) -->
            <button class="w-10 h-10 rounded-full hover:bg-slate-50 flex items-center justify-center text-slate-400 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 bg-[#F4F7FE]" id="message-container">
            
            <div class="text-center py-6">
                <div class="inline-block px-4 py-1 bg-slate-100 rounded-full text-xs text-slate-500 font-medium">
                    Bắt đầu thảo luận
                </div>
            </div>

            @foreach($messages as $msg)
                @if($msg['is_me'])
                    <!-- My Message -->
                    <div class="flex flex-row-reverse gap-3 group">
                        <div class="flex-shrink-0 self-end">
                             <img src="{{ $msg['avatar'] }}" title="{{ $msg['user_name'] }}" class="w-8 h-8 rounded-full border border-white shadow-sm">
                        </div>
                        <div class="flex flex-col items-end max-w-[75%] md:max-w-[60%]">
                            @if(isset($msg['attachments']['type']) && $msg['attachments']['type'] == 'image')
                                <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                    <img src="{{ $msg['attachments']['url'] }}" class="max-w-full max-h-60 object-cover cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                                </div>
                            @endif
                            @if($msg['content'])
                                <div class="bg-[#0F4C81] text-white px-4 py-2.5 rounded-2xl rounded-br-none shadow-sm text-[15px] leading-relaxed break-words">
                                    {{ $msg['content'] }}
                                </div>
                            @endif
                            <span class="text-[10px] text-slate-400 mt-1 mr-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $msg['time'] }}</span>
                        </div>
                    </div>
                @else
                    <!-- Others Message -->
                    <div class="flex gap-3 group">
                        <div class="flex-shrink-0 self-end">
                            <img src="{{ $msg['avatar'] }}" title="{{ $msg['user_name'] }}" class="w-8 h-8 rounded-full border border-white shadow-sm">
                        </div>
                        <div class="flex flex-col items-start max-w-[75%] md:max-w-[60%]">
                            <div class="flex items-center gap-2 mb-1 ml-1">
                                <span class="text-xs font-bold text-slate-600 truncate max-w-[150px]">{{ $msg['user_name'] }}</span>
                                @if($msg['role'] !== 'student')
                                    <span class="text-[9px] font-bold bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded border border-indigo-100">BTC</span>
                                @endif
                            </div>
                            
                            @if(isset($msg['attachments']['type']) && $msg['attachments']['type'] == 'image')
                                <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                    <img src="{{ $msg['attachments']['url'] }}" class="max-w-full max-h-60 object-cover cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                                </div>
                            @endif

                            @if($msg['content'])
                                <div class="bg-white text-slate-700 px-4 py-2.5 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 text-[15px] leading-relaxed break-words {{ $msg['role'] !== 'student' ? 'ring-1 ring-indigo-500/20 bg-indigo-50/10' : '' }}">
                                    {{ $msg['content'] }}
                                </div>
                            @endif
                             <span class="text-[10px] text-slate-400 mt-1 ml-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $msg['time'] }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
            
            <!-- Live Message Placeholder -->
            <template x-for="msg in newMessages" :key="msg.id">
                <div class="flex flex-row-reverse gap-3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="flex-shrink-0 self-end">
                        <img :src="userAvatar" class="w-8 h-8 rounded-full border border-white shadow-sm">
                    </div>
                    <div class="flex flex-col items-end max-w-[75%]">
                        
                        <template x-if="msg.attachments && msg.attachments.type == 'image'">
                             <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                <img :src="msg.attachments.url" class="max-w-full max-h-60 object-cover">
                            </div>
                        </template>

                        <template x-if="msg.content">
                            <div class="bg-[#0F4C81] text-white px-4 py-2.5 rounded-2xl rounded-br-none shadow-sm text-[15px] leading-relaxed break-words" x-text="msg.content"></div>
                        </template>
                        
                        <span class="text-[10px] text-slate-400 mt-1 mr-1">Vừa xong</span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Input Area (Fixed Bottom) -->
        <div class="p-4 bg-white border-t border-slate-100">
            <!-- Image Preview -->
            <div x-show="imagePreview" class="mb-3 flex items-start" style="display: none;">
                <div class="relative group">
                    <img :src="imagePreview" class="h-20 w-auto rounded-lg border border-slate-200 shadow-sm object-cover">
                    <button @click="removeImage()" type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>

            <form @submit.prevent="sendMessage" class="flex gap-3 items-end">
                <input type="file" x-ref="imageInput" class="hidden" accept="image/*" @change="handleFileUpload">
                
                <button type="button" @click="triggerFileInput" class="p-2.5 text-slate-400 hover:text-[#0F4C81] hover:bg-blue-50 rounded-full transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </button>
                
                <div class="flex-1 bg-slate-50 border border-slate-200 rounded-[1.5rem] px-4 py-2 focus-within:ring-2 focus-within:ring-[#0F4C81]/20 focus-within:bg-white focus-within:border-[#0F4C81]/30 transition-all flex items-center">
                    <textarea x-model="input" @keydown.enter.prevent="sendMessage" rows="1" class="w-full bg-transparent border-none focus:ring-0 focus:outline-none p-0 text-slate-700 placeholder-slate-400 resize-none max-h-32 text-sm leading-relaxed scrollbar-hide" placeholder="Nhập tin nhắn..."></textarea>
                </div>

                <button type="submit" class="p-2.5 bg-[#0F4C81] text-white rounded-full shadow-lg hover:bg-[#0a365c] hover:scale-105 active:scale-95 disabled:opacity-50 disabled:scale-100 disabled:cursor-not-allowed transition-all flex-shrink-0" :disabled="!input.trim() && !imageFile">
                    <svg class="w-5 h-5 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function chatRoom() {
        return {
            input: '',
            newMessages: [],
            lastMessageId: {{ $messages->max('id') ?? 0 }},
            userAvatar: 'https://ui-avatars.com/api/?name={{ auth()->user()->name ?? "Me" }}&background=0F4C81&color=fff',
            pollInterval: null,
            imageFile: null,
            imagePreview: null,
            
            init() {
                this.scrollToBottom();
                
                this.$watch('input', () => {
                   const el = this.$el.querySelector('textarea');
                   el.style.height = 'auto';
                   el.style.height = Math.min(el.scrollHeight, 128) + 'px';
                });

                this.pollInterval = setInterval(() => {
                    this.fetchMessages();
                }, 3000);
            },

            triggerFileInput() {
                this.$refs.imageInput.click();
            },

            handleFileUpload(e) {
                const file = e.target.files[0];
                if (!file) return;

                if (file.size > 5 * 1024 * 1024) {
                    alert('Ảnh quá lớn (Max 5MB)');
                    return;
                }

                this.imageFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage() {
                this.imageFile = null;
                this.imagePreview = null;
                this.$refs.imageInput.value = '';
            },

            fetchMessages() {
                fetch(`{{ route('chat.fetch', $event['id']) }}?last_id=${this.lastMessageId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.messages && data.messages.length > 0) {
                            const incoming = data.messages.filter(msg => !msg.is_me); 
                            
                            if (incoming.length > 0) {
                                this.newMessages.push(...incoming);
                                this.lastMessageId = Math.max(this.lastMessageId, ...data.messages.map(m => m.id));
                                this.$nextTick(() => this.scrollToBottom());
                            } else {
                                this.lastMessageId = Math.max(this.lastMessageId, ...data.messages.map(m => m.id));
                            }
                        }
                    })
                    .catch(err => console.error("Polling error", err));
            },
            
            sendMessage() {
                if (!this.input.trim() && !this.imageFile) return;
                
                const content = this.input; 
                const imageFile = this.imageFile;
                const imagePreview = this.imagePreview;

                // Clear input immediately
                this.input = ''; 
                this.removeImage();
                const el = this.$el.querySelector('textarea');
                el.style.height = 'auto';
                
                // Optimistic UI
                const tempId = Date.now();
                this.newMessages.push({
                    id: tempId,
                    content: content,
                    is_me: true,
                    avatar: this.userAvatar,
                    time: 'Đang gửi...',
                    attachments: imagePreview ? { type: 'image', url: imagePreview } : null
                });
                
                this.$nextTick(() => this.scrollToBottom());

                // FormData for File Upload
                const formData = new FormData();
                formData.append('content', content);
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                fetch('{{ route("chat.store", $event["id"]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const index = this.newMessages.findIndex(m => m.id === tempId);
                        if (index !== -1) {
                            this.newMessages[index].time = data.message.time;
                            this.newMessages[index].id = data.message.id;
                            // Update URL to real URL if needed, though preview is fine. 
                            // Usually better to keep preview until refresh to save bandwidth, 
                            // but updating ensures valid public link.
                            if (data.message.attachments) {
                                this.newMessages[index].attachments = data.message.attachments;
                            }
                            this.lastMessageId = Math.max(this.lastMessageId, data.message.id);
                        }
                    } else {
                        alert(data.message || "Lỗi gửi tin nhắn");
                    }
                })
                .catch(err => {
                    console.error("Failed to send", err);
                    alert("Không thể gửi tin nhắn. Vui lòng thử lại.");
                });
            },
            
            scrollToBottom() {
                const container = document.getElementById('message-container');
                container.scrollTop = container.scrollHeight;
            }
        }
    }
</script>
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection
