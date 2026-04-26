@extends('layouts.admin')

@section('header', 'Trung tâm Điều phối Hệ thống')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-in fade-in duration-700">
    
    <!-- 1. Key Metrics Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($stats as $key => $stat)
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-4 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 group-hover:scale-110 transition-transform duration-500">
                    @if($key == 'total_students')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    @elseif($key == 'total_organizers')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    @elseif($key == 'active_events')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    @endif
                </div>
                <div class="flex flex-col items-end">
                    <span class="flex items-center gap-1 text-[10px] font-black {{ $stat['growth'] >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-lg">
                        {{ $stat['growth'] >= 0 ? '↑' : '↓' }} {{ abs($stat['growth']) }}%
                    </span>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight mb-1">{{ number_format($stat['value']) }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- 2. Charts & Actionable Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Activity Chart -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Biểu đồ Tương tác Hệ thống</h3>
                    <p class="text-sm text-slate-500">Theo dõi lượt tham gia và hiệu suất nhiệm vụ (30 ngày gần nhất)</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg text-[10px] font-bold text-slate-600 border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Tham gia
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg text-[10px] font-bold text-slate-600 border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Hoàn thành
                    </div>
                </div>
            </div>

            <div class="h-[350px] relative">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Urgency Feed -->
        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                        Phê duyệt cần gấp
                    </h3>
                    <span class="px-2 py-1 bg-red-500/20 text-red-400 text-[10px] font-black rounded-lg border border-red-500/30 animate-pulse">URGENT</span>
                </div>
                
                <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($pendingTasks as $task)
                    <a href="{{ $task['link'] }}" class="block p-4 bg-white/5 border border-white/10 rounded-2xl hover:bg-white/10 transition-all group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ $task['department'] }}</span>
                            <span class="text-[10px] text-slate-500">{{ $task['deadline'] }}</span>
                        </div>
                        <p class="text-sm font-bold group-hover:text-indigo-300 transition-colors leading-relaxed">{{ $task['title'] }}</p>
                    </a>
                    @empty
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <p class="text-slate-400 font-bold">Tất cả đã được giải quyết!</p>
                    </div>
                    @endforelse
                </div>

                <a href="{{ route('admin.events.index', ['status' => 'pending']) }}" class="mt-8 block w-full py-4 bg-indigo-600 text-white font-black text-center rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20">
                    Xem tất cả yêu cầu
                </a>
            </div>
        </div>
    </div>

    <!-- 3. Organizations & Activities Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Activity Feed -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-slate-800">Hoạt động thời gian thực</h3>
                <div class="flex gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Live Feed</span>
                </div>
            </div>

            <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-[19px] before:w-px before:bg-slate-100">
                @foreach($recentActivities as $activity)
                <div class="relative pl-12 flex items-start gap-4 group/item">
                    <div class="absolute left-0 top-1 w-10 h-10 rounded-full bg-white border border-slate-100 shadow-sm flex items-center justify-center z-10 group-hover/item:border-{{ $activity['color'] }}-500 transition-colors">
                        <svg class="w-4 h-4 text-{{ $activity['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           @if($activity['icon'] == 'check-circle') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                           @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                           @endif
                        </svg>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                         <div class="flex justify-between items-start">
                            <p class="text-sm text-slate-600 leading-snug">
                                <span class="font-black text-slate-800">{{ $activity['user'] }}</span> 
                                {{ $activity['action'] }} 
                                <span class="font-bold text-indigo-600">{{ $activity['target'] }}</span>
                            </p>
                            <span class="text-[10px] font-bold text-slate-400 ml-4 shrink-0">{{ $activity['time'] }}</span>
                         </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Organizations List -->
        <div class="bg-indigo-50/50 rounded-[2.5rem] p-8 border border-indigo-100/50">
             <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-black text-slate-800">Tổ chức hoạt động tích cực</h3>
                <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 2.944a11.955 11.955 0 01-8.618 3.04m8.618-3.04V21m0-18.056L3 6.944M21 6.944L12 2.944" /></svg>
            </div>

            <div class="space-y-4">
                @foreach($topOrganizers as $index => $org)
                <div class="p-4 bg-white rounded-2xl border border-indigo-100/50 flex items-center gap-4 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-black flex items-center justify-center shrink-0">
                        #{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-800 line-clamp-1">{{ $org->name }}</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $org->events_count }} Chiến dịch đã tạo</p>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 p-6 bg-white/60 rounded-3xl border border-white flex items-center justify-between">
                <div>
                   <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Xuất báo cáo hệ thống</p>
                   <p class="text-sm font-bold text-slate-700">Tải xuống dữ liệu tổng hợp .PDF</p>
                </div>
                <button class="p-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    // Create Gradients
    const participationGradient = ctx.createLinearGradient(0, 0, 0, 400);
    participationGradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
    participationGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    const tasksGradient = ctx.createLinearGradient(0, 0, 0, 400);
    tasksGradient.addColorStop(0, 'rgba(52, 211, 153, 0.4)');
    tasksGradient.addColorStop(1, 'rgba(52, 211, 153, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Lượt tham gia',
                    data: @json($chartData['participation']),
                    borderColor: '#4f46e5',
                    backgroundColor: participationGradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#4f46e5',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                },
                {
                    label: 'Hoàn thành nhiệm vụ',
                    data: @json($chartData['tasks_completed']),
                    borderColor: '#10b981',
                    backgroundColor: tasksGradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 10, weight: 'bold' },
                    bodyFont: { size: 12 },
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.5)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10, weight: 'bold' },
                        padding: 10
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10, weight: 'bold' },
                        padding: 10,
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                }
            }
        }
    });
});
</script>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
@endpush
@endsection

