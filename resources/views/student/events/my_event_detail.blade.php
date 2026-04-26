@extends('layouts.student')

@section('header')
    <div class="flex items-center space-x-2">
        <a href="{{ route('student.events.registered') }}" class="text-gray-500 hover:text-primary transition-colors flex items-center gap-1 group">
             <div class="p-1.5 rounded-full group-hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
             </div>
             <span class="text-sm font-medium">Sự kiện của tôi</span>
        </a>
        <span class="text-slate-300">|</span>
        <span class="font-bold text-slate-700">Dashboard: {{ $event->title }}</span>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Event Info & Resources -->
    <div class="space-y-6">
        <!-- Event Compact Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-10 -mt-10 z-0"></div>
            
            <div class="relative z-10">
                <span class="inline-block px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-4 border border-indigo-100">
                    {{ $event->category }}
                </span>
                <h2 class="text-xl font-bold text-slate-800 mb-4 leading-tight">{{ $event->title }}</h2>
                
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Thời gian</p>
                            <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center flex-shrink-0 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Địa điểm</p>
                            <p class="text-sm font-bold text-slate-700 line-clamp-2">{{ $event->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('student.events.show', $event->id) }}" class="flex items-center justify-center w-full py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 font-bold rounded-xl text-sm transition-colors">
                        Xem chi tiết đầy đủ
                    </a>
                </div>
            </div>
        </div>

            </div>
        </div>

        <!-- Event Schedule Card -->
        @if($event->schedules->isNotEmpty())
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Lịch trình chi tiết
            </h3>
            
            <div class="space-y-6">
                @foreach($event->schedules->groupBy('date') as $date => $daySchedules)
                    <div class="relative pl-8 before:absolute before:inset-0 before:left-[11px] before:h-full before:w-0.5 before:bg-slate-100 last:before:h-8">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-indigo-50 border-2 border-indigo-200 flex items-center justify-center z-10">
                            <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        </div>
                        <div class="text-[10px] font-black uppercase text-indigo-500 tracking-widest mb-4">
                            {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($daySchedules as $item)
                                <div class="flex gap-3 group">
                                    <div class="w-10 shrink-0 text-[10px] font-black text-slate-400 pt-0.5">
                                        {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}
                                    </div>
                                    <div class="flex-1 pb-4 group-last:pb-2">
                                        <h4 class="text-sm font-bold text-slate-700 leading-tight group-hover:text-indigo-600 transition-colors">{{ $item->title }}</h4>
                                        @if($item->description)
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Resources Card -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                Tài nguyên & Kết nối
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('chat.show', $event->id) }}" class="flex items-center justify-between p-3 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <span class="font-bold text-sm">Nhóm Chat Sự Kiện</span>
                    </div>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Tasks -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Nhiệm vụ của bạn</h3>
                        <p class="text-xs text-slate-500 font-medium">Hoàn thành để được ghi nhận đóng góp</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-white border border-slate-200 rounded-full text-xs font-bold text-slate-600 shadow-sm">
                    {{ $tasks->where('status', 'completed')->count() }}/{{ $tasks->count() }} Hoàn thành
                </span>
            </div>

            <div class="p-6 flex-1 overflow-y-auto space-y-4" x-data="taskList()">
                @forelse($tasks as $task)
                <div class="group flex items-start gap-4 p-4 rounded-2xl border transition-all duration-300 {{ $task->status == 'completed' ? 'bg-emerald-50/50 border-emerald-100' : 'bg-white border-slate-100 hover:border-amber-200 hover:shadow-md' }}">
                    
                    <!-- Checkbox Area -->
                    <div class="pt-1">
                        <label class="relative flex items-center p-3 rounded-full cursor-pointer" for="task-{{ $task->id }}">
                            <input type="checkbox" 
                                id="task-{{ $task->id }}" 
                                class="peer relative h-6 w-6 cursor-pointer appearance-none rounded-full border-2 transition-all checked:border-emerald-500 checked:bg-emerald-500 hover:scale-105 {{ $task->status == 'completed' ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300' }}"
                                @if($task->status == 'completed') checked disabled @else @change="completeTask({{ $task->id }}, $el)" @endif
                            />
                            <div class="pointer-events-none absolute top-2/4 left-2/4 -translate-y-2/4 -translate-x-2/4 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-slate-800 {{ $task->status == 'completed' ? 'text-emerald-800 line-through decoration-emerald-500/50' : '' }}">{{ $task->title }}</h4>
                            @if($task->description)
                                <p class="text-xs text-slate-500 mt-1 mb-2 bg-slate-50 p-2 rounded-lg border border-slate-100 italic">{{ $task->description }}</p>
                            @endif
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $task->priority == 'high' ? 'bg-red-50 text-red-600 border border-red-100' : ($task->priority == 'medium' ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'bg-slate-100 text-slate-500') }}">
                                {{ $task->priority }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 mb-2 {{ $task->status == 'completed' ? 'opacity-50' : '' }}">Hãy hoàn thành nhiệm vụ này trước thời hạn.</p>
                        
                        <div class="flex items-center gap-3 text-xs font-bold text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Hạn chót: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('H:i d/m') : 'Không có' }}
                            </span>
                             @if($task->status == 'completed')
                                <span class="text-emerald-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    Đã xong
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-slate-800 font-bold mb-1">Không có nhiệm vụ nào</h3>
                    <p class="text-slate-400 text-sm">Bạn chưa được giao nhiệm vụ nào trong sự kiện này.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function taskList() {
        return {
            completeTask(id, checkbox) {
                if(!confirm('Xác nhận bạn đã hoàn thành nhiệm vụ này? BTC sẽ nhận được thông báo.')) {
                    checkbox.checked = false;
                    return;
                }

                // Call API to mark as complete
                fetch(`/student/tasks/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: 'completed' })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Refresh page to show updated status
                        window.location.reload();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                        checkbox.checked = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                    checkbox.checked = false;
                });
            }
        }
    }
</script>
@endpush
@endsection
