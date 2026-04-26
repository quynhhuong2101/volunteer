<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with(['event.organizer'])
            ->whereHas('event', function($q) {
                $q->whereNotIn('status', ['cancelled', 'rejected']);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $stats = [
            'total_requests' => $budgets->count(),
            'pending_amount' => $budgets->where('status', 'pending')->sum('total_estimated'),
            'approved_amount' => $budgets->where('status', 'approved')->sum('total_approved'),
            'pending_count' => $budgets->where('status', 'pending')->count(),
        ];
        
        return view('admin.budgets.index', compact('budgets', 'stats'));
    }

    public function show($id)
    {
        $budget = Budget::with(['event.organizer', 'items'])->findOrFail($id);
        return view('admin.budgets.show', compact('budget'));
    }

    public function approve($id)
    {
        $budget = Budget::with('event.organizer')->findOrFail($id);
        // Auto-approve the estimated amount if not specified otherwise
        $budget->update([
            'status' => 'approved',
            'total_approved' => $budget->total_estimated
        ]);
        
        // Notification
        \App\Models\Notification::create([
            'user_id' => $budget->event->organizer_id,
            'title' => 'Ngân sách được duyệt',
            'message' => 'Ngân sách cho sự kiện "' . $budget->event->title . '" đã được phê duyệt.',
            'type' => 'success',
            'is_read' => false,
            'link' => route('organization.finance.plan.detail', $budget->event_id)
        ]);

        return redirect()->back()->with('success', 'Đã phê duyệt yêu cầu tài chính.');
    }

    public function reject($id)
    {
        $budget = Budget::with('event.organizer')->findOrFail($id);
        $budget->update(['status' => 'rejected']);
        
        // Notification
        \App\Models\Notification::create([
            'user_id' => $budget->event->organizer_id,
            'title' => 'Ngân sách bị từ chối',
            'message' => 'Ngân sách cho sự kiện "' . $budget->event->title . '" đã bị từ chối.',
            'type' => 'error',
            'is_read' => false,
            'link' => route('organization.finance.plan.detail', $budget->event_id)
        ]);
        
        return redirect()->back()->with('success', 'Đã từ chối yêu cầu.');
    }
}
