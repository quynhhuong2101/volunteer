@extends('layouts.student')

@section('header', 'Điểm danh & Tasks')

@section('content')
<div x-data="studentCheckinApp()" class="space-y-8">

    <!-- Top Section: Scanner & Manual Input -->
    <div class="grid grid-cols-1 gap-6">
        
        <!-- Mobile ONLY: QR Scanner Card -->
        <div class="lg:hidden relative bg-[#0F4C81] rounded-3xl p-8 text-center text-white flex flex-col items-center justify-center overflow-hidden min-h-[320px] shadow-lg">
            <!-- Background Decoration (Optional subtle lines/glow) -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
            
            <!-- Default State: QR Icon & Text -->
            <div x-show="!isScanning" class="relative z-10 flex flex-col items-center">
                <div class="w-32 h-32 mb-6 border-2 border-dashed border-white/30 rounded-2xl flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                </div>
                
                <h2 class="text-2xl font-bold mb-2">Quét mã QR Điểm danh</h2>
                <p class="text-blue-100 text-sm mb-8 max-w-xs mx-auto">Đưa camera vào mã QR được cung cấp bởi ban tổ chức để điểm danh tự động.</p>
                
                <div class="flex flex-col gap-3 w-full max-w-xs items-center">
                    <button @click="openCamera()" class="w-full bg-white text-[#0F4C81] px-6 py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-blue-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Mở Camera
                    </button>
                    <button @click="$refs.qrInput.click()" class="w-full bg-[#0F4C81] border border-white/30 text-white px-6 py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        Tải ảnh QR
                    </button>
                    <input type="file" x-ref="qrInput" class="hidden" accept="image/*" @change="handleFileUpload($event)">
                </div>
            </div>

            <!-- Active State: Camera Video -->
            <div x-show="isScanning" class="absolute inset-0 z-20 bg-black flex flex-col">
                <div id="reader" class="flex-1 w-full h-full"></div>
                <button @click="stopCamera()" class="absolute top-4 right-4 bg-black/50 text-white rounded-full p-2 hover:bg-black/70 z-50">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <!-- Desktop ONLY: Banner -->
        <div class="hidden lg:flex bg-gradient-to-br from-[#0F4C81] to-[#1e5c94] rounded-3xl p-8 text-white flex-col justify-center items-center text-center shadow-sm">
             <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
            </div>
            <h2 class="text-2xl font-extrabold mb-2 text-yellow-300 drop-shadow-md">Sử dụng điện thoại để quét QR</h2>
            <p class="text-blue-100 max-w-md">Truy cập trang này trên điện thoại của bạn để sử dụng tính năng quét mã QR điểm danh nhanh chóng và tiện lợi.</p>
        </div>


    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center gap-4">
        <button @click="activeTab = 'tasks'" 
            :class="activeTab === 'tasks' ? 'bg-[#0F4C81] text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50'"
            class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            Danh sách công việc
            <span :class="activeTab === 'tasks' ? 'bg-white text-[#0F4C81]' : 'bg-slate-100 text-slate-500'" class="px-1.5 py-0.5 rounded text-xs font-extrabold ml-1">{{ count($tasks ?? []) }}</span>
        </button>
        
        <button @click="activeTab = 'history'" 
            :class="activeTab === 'history' ? 'bg-[#0F4C81] text-white' : 'bg-white text-slate-500 border border-slate-200 hover:bg-slate-50'"
            class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Lịch sử điểm danh
        </button>
    </div>

    <!-- Content Area -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 min-h-[300px]">
        
        <!-- Tasks List -->
        <div x-show="activeTab === 'tasks'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
             @if(isset($tasks) && count($tasks) > 0)
                <div class="flex flex-col gap-4">
                    @foreach($tasks as $task)
                    <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:border-[#0F4C81] hover:bg-slate-50 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl {{ $task['status'] == 'completed' ? 'bg-emerald-50 text-emerald-500 border-emerald-100' : 'bg-amber-50 text-amber-500 border-amber-100' }} flex items-center justify-center font-bold text-xl border">
                                {{ $task['status'] == 'completed' ? '✓' : '!' }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 group-hover:text-[#0F4C81] transition-colors">{{ $task['title'] }}</h4>
                                @if($task['description'])
                                    <p class="text-[10px] text-slate-500 bg-slate-100 p-1.5 rounded mt-1 italic">{{ $task['description'] }}</p>
                                @endif
                                <div class="flex items-center gap-3 text-xs text-slate-500 mt-1">
                                    <span class="font-medium">{{ $task['event'] }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span>Hạn: {{ \Carbon\Carbon::parse($task['deadline'])->format('H:i d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg uppercase tracking-wider">{{ $task['priority'] }}</span>
                            @if($task['status'] !== 'completed')
                                <button @click.stop="completeTask({{ $task['id'] }})" class="p-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                    <svg class="w-16 h-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    <p class="font-medium">Không có nhiệm vụ nào cần làm.</p>
                </div>
            @endif
        </div>

        <!-- History List -->
        <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
             @if(isset($history) && count($history) > 0)
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs font-bold text-slate-400 border-b border-slate-100">
                                <th class="py-3 pl-2">HOẠT ĐỘNG</th>
                                <th class="py-3">ĐỊA ĐIỂM</th>
                                <th class="py-3">THỜI GIAN</th>
                                <th class="py-3 text-right pr-2">TRẠNG THÁI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($history as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800">{{ $item['event'] }}</td>
                                <td class="py-4 text-sm text-slate-500">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ $item['location'] }}
                                    </div>
                                </td>
                                <td class="py-4 text-sm font-bold text-slate-600">{{ \Carbon\Carbon::parse($item['timestamp'])->format('H:i - d/m/Y') }}</td>

                                <td class="py-4 text-right pr-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                        {{ ucfirst($item['status']) == 'Success' ? 'Thành công' : $item['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                     <p class="font-medium">Chưa có lịch sử điểm danh.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function studentCheckinApp() {
        return {
            activeTab: 'history', 
            isScanning: false,
            scanner: null,

            openCamera() {
                if (this.isScanning) return;
                
                // Feature Detection specifically for Secure Context
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    if (confirm("Lỗi: Trình duyệt không hỗ trợ Camera hoặc kết nối không bảo mật (HTTP).\n\nBạn có muốn tải ảnh QR lên thay thế không?")) {
                         this.$refs.qrInput.click();
                    }
                    return;
                }

                this.isScanning = true;
                
                this.$nextTick(() => {
                    this.scanner = new Html5Qrcode("reader");
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                    
                    this.scanner.start({ facingMode: "environment" }, config, this.onScanSuccess.bind(this), this.onScanFailure)
                    .catch(err => {
                        console.error("Camera Error:", err);
                        
                        if (confirm("Không thể mở Camera. Bạn có muốn tải ảnh QR lên thay thế không?")) {
                             this.$refs.qrInput.click();
                        }

                        this.isScanning = false;
                        this.stopCamera();
                    });
                });
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                const html5QrCode = new Html5Qrcode("reader");
                html5QrCode.scanFile(file, true)
                .then(decodedText => {
                    this.submitCheckin(decodedText);
                })
                .catch(err => {
                    alert('Không tìm thấy mã QR trong ảnh!');
                });
            },

            onScanSuccess(decodedText, decodedResult) {
                this.stopCamera();
                this.submitCheckin(decodedText);
            },

            onScanFailure(error) {
                // Ignore frame parse errors
            },

            stopCamera() {
                if (this.scanner) {
                    this.scanner.stop().then(() => {
                        this.scanner.clear();
                        this.isScanning = false;
                    }).catch(err => {
                        console.warn("Stop failed", err);
                        this.isScanning = false;
                    });
                }
            },


            submitCheckin(token) {
                 fetch('{{ route("student.checkin.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ token: token })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Xử lý thành công!');
                    window.location.reload();
                })
                .catch(err => alert("Lỗi kết nối đến máy chủ!"));
            },

            completeTask(id) {
                if(!confirm('Xác nhận hoàn thành nhiệm vụ này?')) return;

                fetch(`/student/tasks/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: 'completed' })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        alert('Có lỗi xảy ra!');
                    }
                })
                .catch(err => alert("Lỗi kết nối!"));
            }
        }
    }
</script>
@endsection
