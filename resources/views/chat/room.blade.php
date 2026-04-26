{{-- Determine layout based on user role --}}
@extends(auth()->user()->role === 'student' ? 'layouts.student' : 'layouts.organization')

@section('header', 'Thảo luận: ' . $event['name'])

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="chatRoom()">
    
    <!-- Chat Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                #
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg">{{ $event['name'] }}</h2>
                <div class="flex items-center text-sm text-slate-500">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $event['members_count'] }} thành viên đang hoạt động
                </div>
            </div>
        </div>

        @if(auth()->user()->role !== 'student')
        <!-- Admin Actions -->
        <form action="{{ route('chat.destroy', $event['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn giải tán nhóm này không? Hành động này không thể hoàn tác.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm px-4 py-2 hover:bg-red-50 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Giải tán nhóm
            </button>
        </form>
        @endif
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/30" id="message-container">
        @foreach($messages as $msg)
            @if($msg['is_me'])
                <!-- My Message -->
                <div class="flex flex-row-reverse gap-3">
                    <img src="{{ $msg['avatar'] }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm flex-shrink-0">
                    <div class="flex flex-col items-end max-w-[70%]">
                        @if(isset($msg['attachments']['type']) && $msg['attachments']['type'] == 'image')
                            <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                <img src="{{ $msg['attachments']['url'] }}" class="max-w-full max-h-60 object-cover cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                            </div>
                        @endif
                        @if($msg['content'])
                            <div class="bg-indigo-600 text-white px-5 py-3 rounded-2xl rounded-tr-none shadow-sm text-base">
                                {{ $msg['content'] }}
                            </div>
                        @endif
                        <span class="text-xs text-slate-400 mt-1 font-medium">{{ $msg['time'] }}</span>
                    </div>
                </div>
            @else
                <!-- Others Message -->
                <div class="flex gap-3">
                    <img src="{{ $msg['avatar'] }}" class="w-10 h-10 rounded-full border-2 border-white shadow-sm flex-shrink-0">
                    <div class="flex flex-col items-start max-w-[70%]">
                        <div class="flex items-baseline gap-2 mb-1 pl-1">
                            <span class="text-sm font-bold text-slate-700">{{ $msg['user_name'] }}</span>
                        </div>
                        
                        @if(isset($msg['attachments']['type']) && $msg['attachments']['type'] == 'image')
                            <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                <img src="{{ $msg['attachments']['url'] }}" class="max-w-full max-h-60 object-cover cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                            </div>
                        @endif

                        @if($msg['content'])
                            <div class="bg-white text-slate-700 px-5 py-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-base">
                                {{ $msg['content'] }}
                            </div>
                        @endif
                        <span class="text-xs text-slate-400 mt-1 font-medium">{{ $msg['time'] }}</span>
                    </div>
                </div>
            @endif
        @endforeach
        
        <!-- Live Message Placeholder (Alpine) -->
        <template x-for="msg in newMessages" :key="msg.id">
            <div class="w-full">
                <!-- My Message -->
                <template x-if="msg.is_me === true">
                    <div class="flex flex-row-reverse gap-3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <img :src="userAvatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm flex-shrink-0">
                        <div class="flex flex-col items-end max-w-[70%]">
                            
                            <template x-if="msg.attachments && msg.attachments.type == 'image'">
                                <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                    <img :src="msg.attachments.url" class="max-w-full max-h-60 object-cover">
                                </div>
                            </template>

                            <template x-if="msg.content">
                                <div class="bg-indigo-600 text-white px-5 py-3 rounded-2xl rounded-tr-none shadow-sm text-base" x-text="msg.content"></div>
                            </template>
                            
                            <span class="text-xs text-slate-400 mt-1 font-medium" x-text="msg.time || 'Vừa xong'"></span>
                        </div>
                    </div>
                </template>

                <!-- Others Message -->
                <template x-if="msg.is_me === false">
                    <div class="flex gap-3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <img :src="msg.avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm flex-shrink-0">
                        <div class="flex flex-col items-start max-w-[70%]">
                            <div class="flex items-baseline gap-2 mb-1 pl-1">
                                <span class="text-sm font-bold text-slate-700" x-text="msg.user_name"></span>
                            </div>
                            
                            <template x-if="msg.attachments && msg.attachments.type == 'image'">
                                 <div class="mb-1 overflow-hidden rounded-2xl border border-slate-200">
                                    <img :src="msg.attachments.url" class="max-w-full max-h-60 object-cover cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                                </div>
                            </template>

                            <template x-if="msg.content">
                                <div class="bg-white text-slate-700 px-5 py-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-base" x-text="msg.content"></div>
                            </template>
                            
                            <span class="text-xs text-slate-400 mt-1 font-medium" x-text="msg.time"></span>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    <!-- Input Area -->
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

        <form @submit.prevent="sendMessage" class="flex gap-4 items-end max-w-5xl mx-auto">
            <input type="file" x-ref="imageInput" class="hidden" accept="image/*" @change="handleFileUpload">
            
            <button type="button" @click="triggerFileInput" class="p-3 text-slate-400 hover:text-indigo-600 transition-colors rounded-xl hover:bg-slate-50">
                 <!-- Image Icon -->
                 <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </button>
            
            <div class="flex-1 bg-slate-50 rounded-2xl border border-slate-200 focus-within:ring-2 focus-within:ring-indigo-100 transition-all p-2">
                <textarea x-model="input" @keydown.enter.prevent="sendMessage" rows="1" class="w-full bg-transparent border-none focus:ring-0 focus:outline-none p-2 text-slate-700 placeholder-slate-400 resize-none max-h-32" placeholder="Nhập tin nhắn (Enter để gửi)..." style="min-height: 44px;"></textarea>
            </div>
            <button type="submit" class="p-4 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!input.trim() && !imageFile">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
            </button>
        </form>
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
                   el.style.height = 'auto'; // Reset
                   el.style.height = Math.min(el.scrollHeight, 128) + 'px'; // Expand
                });

                // Start Polling
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
                            // Filter explicitly
                            const incoming = data.messages.filter(msg => msg.is_me === false); 
                            
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
                el.style.height = 'auto'; // Reset height
                
                // Optimistic UI Update
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
@endsection
