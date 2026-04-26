@extends('layouts.organization')

@section('header', 'Quản lý Điểm danh')

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col" x-data="smartAttendance()">
    
    <!-- Top Bar: Event Info & Tabs -->
    <!-- Tabs -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 shrink-0">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('organization.attendance.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <h2 class="text-2xl font-black text-slate-800">{{ $event->title }}</h2>
                <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100 uppercase tracking-wider">Live</span>
            </div>
            <p class="text-slate-500 text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i d/m/Y') }}
                <span class="w-1 h-1 rounded-full bg-slate-300 mx-1"></span>
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                {{ $event->location }}
            </p>
        </div>

        <div class="bg-white p-1.5 rounded-xl shadow-sm border border-slate-200 inline-flex">
            <button @click="activeTab = 'qr'" :class="{'bg-slate-900 text-white shadow-md': activeTab === 'qr', 'text-slate-500 hover:bg-slate-50 hover:text-slate-700': activeTab !== 'qr'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                Trạm QR Code
            </button>
            <button @click="activeTab = 'manual'" :class="{'bg-indigo-600 text-white shadow-md': activeTab === 'manual', 'text-slate-500 hover:bg-slate-50 hover:text-slate-700': activeTab !== 'manual'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Danh sách
            </button>
            <button @click="activeTab = 'tasks'" :class="{'bg-amber-500 text-white shadow-md': activeTab === 'tasks', 'text-slate-500 hover:bg-slate-50 hover:text-slate-700': activeTab !== 'tasks'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Nhiệm vụ
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 min-h-0 relative">
        
        <!-- Tab 1: QR Station -->
        <div x-show="activeTab === 'qr'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="h-full grid grid-cols-1 lg:grid-cols-3 gap-6 pb-6">
            
            <!-- QR Scanner Column -->
            <div class="lg:col-span-2 bg-gradient-to-tr from-slate-900 via-slate-800 to-indigo-900 rounded-[2.5rem] shadow-2xl overflow-hidden relative flex flex-col">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500/20 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>
                
                <div class="relative z-10 p-8 text-center shrink-0">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/10 text-white text-xs font-bold uppercase tracking-widest backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                        Live QR Station
                    </span>
                    <h3 class="text-white text-opacity-80 mt-4 font-medium">Chiếu mã này lên màn hình lớn để sinh viên quét</h3>
                </div>

                <!-- QR Center -->
                <div class="relative z-10 flex-1 flex items-center justify-center p-8">
                    <div class="relative group cursor-pointer" @click="refreshQR()">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-[2rem] blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-tilt"></div>
                        
                        <div class="relative bg-white p-6 rounded-[1.8rem] shadow-2xl transition-transform duration-300 group-hover:scale-[1.02]">
                            <div class="w-64 h-64 relative overflow-hidden rounded-xl bg-slate-50 flex items-center justify-center">
                                <template x-if="loading">
                                    <div class="flex flex-col items-center">
                                        <svg class="animate-spin h-10 w-10 text-indigo-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span class="text-xs font-bold text-slate-500 uppercase">Updating...</span>
                                    </div>
                                </template>
                                <img x-show="!loading" :src="qrUrl" class="w-full h-full object-contain" alt="QR Code">
                            </div>
                            <div class="mt-4 flex items-center justify-between text-xs font-bold text-slate-400">
                                <span>SESSION: #{{ $event->id }}</span>
                                <span class="flex items-center gap-1 text-indigo-500"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Reset: <span x-text="countdown" class="font-mono text-lg"></span>s</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Column -->
            <div class="flex flex-col gap-6">
                 <!-- Main Stat Card -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2 relative z-10">
                        <div>
                            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Tiến độ</p>
                            <h3 class="text-4xl font-black text-slate-800 mt-2">{{ $checked_in_count }}<span class="text-lg text-slate-400 font-bold ml-1">/ {{ $total_attendees }}</span></h3>
                        </div>
                        <div class="w-16 h-16 rounded-full border-4 border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xl bg-indigo-50">{{ round($percentage) }}%</div>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden mt-4 relative z-10">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>

                <!-- Live Feed -->
                <div class="flex-1 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                     <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                        <h4 class="font-bold text-slate-800">Mới check-in</h4>
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md animate-pulse">Live</span>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                        @forelse($students->where('status', 'checked_in')->sortByDesc('time')->take(10) as $student)
                        <div class="flex items-center p-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 font-bold flex items-center justify-center text-sm mr-3 border border-white">
                                {{ substr($student['name'], 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-bold text-slate-800 text-sm truncate">{{ $student['name'] }}</h5>
                                <p class="text-xs text-slate-400 font-medium truncate">{{ $student['id'] }}</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $student['time'] }}</span>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center h-48 text-slate-400">
                            <p class="text-xs font-medium">Chưa có ai check-in</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Manual List -->
        <div x-show="activeTab === 'manual'" x-cloak class="h-full flex flex-col bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] border border-slate-100 overflow-hidden pb-6">
            <!-- Toolbar -->
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
                 <div class="relative w-full md:w-80">
                    <input type="text" x-model="search" placeholder="Tìm sinh viên..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-none ring-1 ring-slate-200 bg-white focus:ring-2 focus:ring-indigo-500/20 focus:outline-none text-sm font-medium shadow-sm transition-shadow">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>
            <div class="flex-1 overflow-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 sticky top-0 z-10 font-bold text-xs text-slate-500 uppercase tracking-wider shadow-sm">
                        <tr>
                            <th class="p-4 pl-6 border-b border-slate-100">Thông tin</th>
                            <th class="p-4 border-b border-slate-100 text-center">Trạng thái</th>
                            <th class="p-4 pr-6 border-b border-slate-100 text-right">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="student in filteredStudents" :key="student.id">
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 pl-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm" x-text="student.name.charAt(0)"></div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm" x-text="student.name"></h4>
                                            <p class="text-xs text-slate-400 font-mono mt-0.5" x-text="student.id"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span x-show="student.status === 'checked_in'" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Đã điểm danh</span>
                                    <span x-show="student.status === 'pending'" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-400 border border-slate-200">Chưa điểm danh</span>
                                </td>
                                <td class="p-4 pr-6 text-right">
                                    <form method="POST" :action="`{{ route('organization.attendance.store', $event->id) }}`" class="inline" x-show="student.status === 'pending'">
                                        @csrf
                                        <input type="hidden" name="checkin_id" :value="student.checkin_id">
                                        <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold shadow-sm hover:bg-blue-700 whitespace-nowrap">Điểm danh</button>
                                    </form>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 3: Tasks Management -->
        <div x-show="activeTab === 'tasks'" x-cloak class="h-full flex flex-col gap-6 overflow-hidden pb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-full">
                <!-- Create Task Form -->
                <div class="md:col-span-1 bg-white rounded-3xl p-6 shadow-sm border border-slate-200 h-fit">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Giao nhiệm vụ mới</h3>
                    <form action="{{ route('organization.attendance.storeTask', $event->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tiêu đề</label>
                            <input type="text" name="title" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500/50 focus:bg-white text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mô tả (Nội dung)</label>
                            <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500/50 focus:bg-white text-sm" placeholder="Nhập nội dung chi tiết..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Đối tượng giao</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="assign_type" value="all" x-model="assignType" class="hidden peer">
                                    <div class="px-3 py-2 rounded-xl text-center text-xs font-bold ring-1 ring-slate-200 peer-checked:bg-amber-500 peer-checked:text-white peer-checked:ring-amber-500 transition-all">Tất cả</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="assign_type" value="user" x-model="assignType" class="hidden peer">
                                    <div class="px-3 py-2 rounded-xl text-center text-xs font-bold ring-1 ring-slate-200 peer-checked:bg-amber-500 peer-checked:text-white peer-checked:ring-amber-500 transition-all">Cá nhân</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="assign_type" value="group" x-model="assignType" class="hidden peer">
                                    <div class="px-3 py-2 rounded-xl text-center text-xs font-bold ring-1 ring-slate-200 peer-checked:bg-amber-500 peer-checked:text-white peer-checked:ring-amber-500 transition-all">Nhóm</div>
                                </label>
                            </div>
                        </div>

                        <!-- Individual Selection -->
                        <div x-show="assignType === 'user'" x-transition>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Chọn sinh viên</label>
                            <select name="user_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm">
                                <option value="">-- Chọn 1 sinh viên --</option>
                                @foreach($students->where('status', 'checked_in') as $student)
                                    <option value="{{ $student['user_id'] }}">{{ $student['name'] }}</option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-400 mt-1">* Chỉ hiện sinh viên đã điểm danh</p>
                        </div>

                        <!-- Group Selection -->
                        <div x-show="assignType === 'group'" x-transition>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Chọn nhóm (Ban)</label>
                            <select name="position_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm">
                                <option value="">-- Chọn 1 nhóm --</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mức độ</label>
                                <select name="priority" class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm">
                                    <option value="medium">Bình thường</option>
                                    <option value="high">Cao</option>
                                    <option value="low">Thấp</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hạn chót</label>
                                <input type="datetime-local" name="deadline" class="w-full px-3 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Tạo nhiệm vụ
                        </button>
                    </form>
                </div>

                <!-- Task List -->
                <div class="md:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Danh sách nhiệm vụ</h3>
                        <span class="text-xs font-bold text-slate-400">{{ count($tasks) }} nhiệm vụ</span>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        @forelse($tasks as $task)
                        <div @click="openTaskDetails({{ $task->id }})" class="flex items-start gap-4 p-4 rounded-2xl border border-slate-100 hover:border-amber-400 hover:shadow-md transition-all group bg-white shadow-sm cursor-pointer relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="w-10 h-10 rounded-xl {{ $task->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }} flex items-center justify-center border font-bold">
                                {{ $task->status == 'completed' ? '✓' : '!' }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-slate-800">{{ $task->title }}</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $task->priority == 'high' ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-500' }}">{{ $task->priority }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 uppercase font-bold tracking-tight">
                                    <span class="text-slate-400 font-normal">Đối tượng:</span> 
                                    @if($task->user)
                                        <span class="text-indigo-600">{{ $task->user->name }}</span>
                                    @elseif($task->position)
                                        <span class="text-amber-600">{{ $task->position->name }}</span>
                                    @else
                                        <span class="text-slate-600 underline decoration-slate-200">Tất cả thành viên</span>
                                    @endif
                                </p>
                                @if($task->description)
                                    <p class="text-xs text-slate-500 mt-2 line-clamp-2 bg-slate-50 p-2 rounded-lg italic">{{ $task->description }}</p>
                                @endif

                                <div class="flex items-center gap-3 mt-3 text-xs font-bold text-slate-400">
                                    <span>Hạn: {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('H:i d/m') : 'Không' }}</span>
                                    <span>•</span>
                                    <span class="uppercase">{{ $task->status }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center h-48 text-slate-400">
                             <svg class="w-12 h-12 mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                             <p class="font-medium">Chưa có nhiệm vụ nào.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Details Modal -->
    <div x-show="showTaskModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-cloak>
        
        <div @click.away="showTaskModal = false" 
             class="bg-white rounded-[2rem] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col border border-slate-200">
            
            <div class="p-6 border-b border-slate-100 flex justify-between items-start bg-slate-50/50">
                <div>
                    <h3 class="text-xl font-black text-slate-800" x-text="modalTask?.title || 'Đang tải...'"></h3>
                    <p class="text-xs font-bold text-amber-500 uppercase mt-1 tracking-wider" x-text="modalTask?.priority"></p>
                </div>
                <div class="flex items-center gap-2">
                    <button x-show="!isEditing && modalTask" @click="isEditing = true" class="p-2 hover:bg-amber-50 text-amber-500 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </button>
                    <button @click="showTaskModal = false" class="p-2 hover:bg-slate-200 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- View Mode -->
                <div x-show="!isEditing">
                    <!-- Task Desc -->
                    <div x-show="modalTask?.description" class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100">
                        <h4 class="text-[10px] font-black text-indigo-400 uppercase mb-2">Nội dung nhiệm vụ</h4>
                        <p class="text-sm text-slate-700 leading-relaxed italic" x-text="modalTask?.description"></p>
                    </div>

                    <!-- Student List -->
                    <div class="mt-6">
                        <h4 class="text-[10px] font-black text-slate-400 uppercase mb-3 tracking-widest flex items-center gap-2">
                            Trạng thái hoàn thành
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                            <span x-text="modalStudents.length + ' sinh viên'"></span>
                        </h4>
                        <!-- ... (same student list template as before) ... -->
                        <div class="space-y-2">
                            <template x-if="modalLoading">
                                <div class="flex flex-col items-center py-12 gap-3 opacity-50">
                                    <div class="w-10 h-10 border-4 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                                    <p class="text-xs font-bold text-slate-400">Đang lấy dữ liệu...</p>
                                </div>
                            </template>

                            <template x-for="s in modalStudents" :key="s.user_id">
                                <div class="flex items-center justify-between p-3 rounded-xl border border-slate-50 bg-slate-50/30 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-xs font-bold text-slate-400" x-text="s.name.charAt(0)"></div>
                                        <span class="text-sm font-bold text-slate-700" x-text="s.name"></span>
                                    </div>
                                    <div class="flex items-center gap-3 text-right">
                                        <template x-if="s.status === 'completed'">
                                            <div class="flex flex-col items-end">
                                                <span class="px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">Hoàn thành</span>
                                                <span class="text-[9px] text-slate-400 mt-0.5" x-text="s.completed_at"></span>
                                            </div>
                                        </template>
                                        <template x-if="s.status !== 'completed'">
                                            <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-400 text-[10px] font-black uppercase border border-slate-200">Chưa xong</span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div x-show="isEditing" x-cloak class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tiêu đề</label>
                        <input type="text" x-model="modalTask.title" class="w-full px-4 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mô tả</label>
                        <textarea x-model="modalTask.description" rows="3" class="w-full px-4 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 focus:ring-2 focus:ring-amber-500 text-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mức độ</label>
                            <select x-model="modalTask.priority" class="w-full px-4 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm font-bold">
                                <option value="low">Thấp</option>
                                <option value="medium">Bình thường</option>
                                <option value="high">Cao</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Hạn chót</label>
                            <input type="datetime-local" x-model="modalTask.deadlineFormatted" class="w-full px-4 py-2 rounded-xl bg-slate-50 border-none ring-1 ring-slate-200 text-sm">
                        </div>
                    </div>
                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button @click="isEditing = false" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">Hủy</button>
                        <button @click="saveTaskUpdate" class="flex-1 py-3 bg-amber-500 text-white font-bold rounded-xl shadow-lg shadow-amber-500/20 hover:bg-amber-600 transition-all flex items-center justify-center gap-2">
                             <template x-if="modalLoading">
                                <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                             </template>
                             Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan { 0% { top: 0%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    [x-cloak] { display: none !important; }
</style>

<script>
    function smartAttendance() {
        return {
            activeTab: 'qr',
            assignType: 'all',
            countdown: 30,
            qrUrl: '', // Will be set by refreshQR
            loading: false,
            search: '',
            students: @json($students),
            
            // Modal state
            showTaskModal: false,
            isEditing: false,
            modalLoading: false,
            modalTask: null,
            modalStudents: [],
            
            get filteredStudents() {
                if (this.search === '') return this.students;
                const lowerSearch = this.search.toLowerCase();
                return this.students.filter(s => 
                    s.name.toLowerCase().includes(lowerSearch) || 
                    s.id.toLowerCase().includes(lowerSearch)
                );
            },
            
            init() {
                this.refreshQR(); 
                setInterval(() => {
                    this.countdown--;
                    if (this.countdown <= 0) { this.refreshQR(); }
                }, 1000);
            },
            
            refreshQR() {
                this.loading = true;
                // Generate Dynamic Token: EVENT-{ID}-{RANDOM}
                // In production, this should be an API call to get a signed token
                const eventId = {{ $event->id }};
                const random = Math.random().toString(36).substr(2, 5);
                const token = `EVENT-${eventId}-${random}`;
                
                setTimeout(() => {
                    this.qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&margin=10&color=4338ca&data=${token}`;
                    this.countdown = 30; // Reset countdown
                    this.loading = false;
                }, 500);
            },

            async openTaskDetails(taskId) {
                this.modalLoading = true;
                this.modalTask = null;
                this.modalStudents = [];
                this.showTaskModal = true;

                try {
                    const response = await fetch(`/organization/attendance/{{ $event->id }}/task/${taskId}/details`);
                    const data = await response.json();
                    
                    this.modalTask = {
                        ...data.task,
                        deadlineFormatted: data.task.deadline ? data.task.deadline.slice(0, 16).replace(' ', 'T') : ''
                    };
                    this.modalStudents = data.students;
                    this.isEditing = false;
                } catch (error) {
                    console.error('Error fetching task details:', error);
                } finally {
                    this.modalLoading = false;
                }
            },

            async saveTaskUpdate() {
                this.modalLoading = true;
                try {
                    const response = await fetch(`/organization/attendance/{{ $event->id }}/task/${this.modalTask.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            title: this.modalTask.title,
                            description: this.modalTask.description,
                            priority: this.modalTask.priority,
                            deadline: this.modalTask.deadlineFormatted
                        })
                    });
                    
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Có lỗi xảy ra khi cập nhật!');
                    }
                } catch (error) {
                    console.error('Error updating task:', error);
                    alert('Lỗi kết nối!');
                } finally {
                    this.modalLoading = false;
                }
            }
        }
    }
</script>
@endsection


