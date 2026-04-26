<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    // 1. Budget Planning
    // 1. Budget Planning
    public function index()
    {
        $organizerId = auth()->id();
        $events = \App\Models\Event::where('organizer_id', $organizerId)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->with(['budget'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('organization.finance.plan_list', compact('events'));
    }

    public function plan($id)
    {
        $currentEvent = \App\Models\Event::with('budget.items')->findOrFail($id);
        
        if (in_array($currentEvent->status, ['cancelled', 'rejected'])) {
             return redirect()->route('organization.finance.index')->with('error', 'Chiến dịch đã bị hủy hoặc từ chối.');
        }

        // Load existing items or empty array
        $items = $currentEvent->budget && $currentEvent->budget->items->count() > 0 
            ? $currentEvent->budget->items->map(function($item) {
                return [
                    'name' => $item->name,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'source' => $item->source
                ];
            })
            : []; // Empty start

        return view('organization.finance.plan_detail', compact('items', 'currentEvent'));
    }

    public function submitPlan(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        
        if (in_array($event->status, ['cancelled', 'rejected'])) {
             return redirect()->back()->with('error', 'Chiến dịch đã bị hủy hoặc từ chối.');
        }

        $data = json_decode($request->items, true);
        if (!is_array($data) || empty($data)) {
             return redirect()->back()->with('error', 'Vui lòng thêm ít nhất một khoản chi.');
        }

        // Create or Update Budget
        $budget = \App\Models\Budget::firstOrCreate(
            ['event_id' => $id],
            ['status' => 'draft', 'total_estimated' => 0]
        );

        // Sync Items (Delete old, create new for simplicity)
        $budget->items()->delete();
        
        $totalEstimated = 0;
        foreach ($data as $item) {
            $amount = ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1);
            $totalEstimated += $amount;
            
            $budget->items()->create([
                'name' => $item['name'] ?? 'Khoản chi không tên',
                'unit_price' => $item['unit_price'] ?? 0,
                'quantity' => $item['quantity'] ?? 1,
                'source' => $item['source'] ?? 'fund'
            ]);
        }
        
        $budget->update([
            'status' => 'pending', 
            'total_estimated' => $totalEstimated
        ]);
        
        return redirect()->route('organization.finance.plan.detail', $id)->with('success', 'Đã gửi bản dự trù ngân sách. Vui lòng chờ Admin duyệt.');
    }

    // 2. Expense Tracker
    public function trackerList()
    {
        $organizerId = auth()->id();
        $events = \App\Models\Event::where('organizer_id', $organizerId)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->with(['budget'])
            ->withSum('expenses', 'amount')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('organization.finance.tracker_list', compact('events'));
    }

    public function trackerDetail($id)
    {
        $currentEvent = \App\Models\Event::with(['budget', 'expenses.user'])->findOrFail($id);

        if (in_array($currentEvent->status, ['cancelled', 'rejected'])) {
             return redirect()->route('organization.finance.tracker')->with('error', 'Chiến dịch đã bị hủy hoặc từ chối.');
        }

        $budget_total = $currentEvent->budget ? $currentEvent->budget->total_approved : 0;
        $budget_used = $currentEvent->expenses()->sum('amount');
        
        $percent = $budget_total > 0 ? ($budget_used / $budget_total) * 100 : 0;
        
        $expenses = $currentEvent->expenses()->orderBy('occurred_at', 'desc')->get();

        return view('organization.finance.tracker_detail', compact('currentEvent', 'budget_total', 'budget_used', 'percent', 'expenses'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'proof_image' => 'required|image|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/expenses'), $filename);
            $imagePath = 'uploads/expenses/' . $filename;
        }

        \App\Models\Expense::create([
            'event_id' => $request->event_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'proof_image' => $imagePath,
            'occurred_at' => now(),
        ]);
        
        // Update Budget Spent
        $event = \App\Models\Event::with('budget')->find($request->event_id);
        
        if (in_array($event->status, ['cancelled', 'rejected'])) {
             return redirect()->back()->with('error', 'Không thể chi tiêu cho chiến dịch đã hủy.');
        }

        if ($event->budget) {
            $event->budget->increment('total_spent', $request->amount);
        }

        return redirect()->back()->with('success', 'Đã lưu khoản chi mới thành công!');
    }

    // 3. Settlement
    // 3. Settlement
    public function settlement()
    {
        $organizerId = auth()->id();
        // Fetch events that ended or are approved (for demo purposes)
        $events = \App\Models\Event::where('organizer_id', $organizerId)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->with(['budget'])
            ->withSum('expenses', 'amount')
            ->orderBy('end_time', 'desc')
            ->get()
            ->map(function ($event) {
                $planned = $event->budget ? $event->budget->total_approved : 0;
                $actual = $event->expenses_sum_amount ?? 0;
                $diff = $planned - $actual; // Positive = Surplus
                
                return (object) [
                    'id' => $event->id,
                    'title' => $event->title,
                    'end_time' => $event->end_time,
                    'planned' => $planned,
                    'actual' => $actual,
                    'diff' => $diff,
                    'status' => $event->status // e.g., 'ended'
                ];
            });

        return view('organization.finance.settlement', compact('events'));
    }

    public function settlementDetail($id)
    {
        $event = \App\Models\Event::with(['budget.items', 'expenses.user'])->findOrFail($id);

        if (in_array($event->status, ['cancelled', 'rejected'])) {
             return redirect()->route('organization.finance.settlement')->with('error', 'Chiến dịch đã bị hủy hoặc từ chối.');
        }
        
        // Financial Summary
        $planned = $event->budget ? $event->budget->total_approved : 0;
        $actual = $event->expenses()->sum('amount');
        $surplus = $planned - $actual;

        // Breakdown by Budget Sources (Mock logic as Expenses don't typically have 'source' unless tagged)
        // For simplicity, we compare Total Plan vs Total Actual
        
        return view('organization.finance.settlement_detail', compact('event', 'planned', 'actual', 'surplus'));
    }
}
