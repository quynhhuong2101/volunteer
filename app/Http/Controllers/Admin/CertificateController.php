<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('code');
        $certificate = null;
        $recentCertificates = [];

        if ($search) {
            $certificate = Certificate::with(['user', 'event'])
                ->where('code', $search)
                ->first();
        } else {
            // Still provide recent ones for context, but the UI will focus on search
            $recentCertificates = Certificate::with(['user', 'event'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('admin.certificates.index', compact('certificate', 'recentCertificates', 'search'));
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'student')->get(); // Using 'role' column
        $events = \App\Models\Event::where('status', 'approved')->orderBy('created_at', 'desc')->get();
        return view('admin.certificates.create', compact('users', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'code' => 'nullable|unique:certificates,code',
            'issued_at' => 'required|date',
            'template_url' => 'nullable|url'
        ]);

        // Extra check for event status
        $event = \App\Models\Event::find($request->event_id);
        if ($event->status == 'cancelled') {
            return back()->with('error', 'Không thể cấp chứng nhận cho sự kiện đã hủy.');
        }

        $data = $request->all();
        if (empty($data['code'])) {
            $data['code'] = 'CERT-' . strtoupper(uniqid());
        }

        Certificate::create($data);

        return redirect()->route('admin.certificates.index')->with('success', 'Đã cấp chứng nhận mới thành công.');
    }

    public function edit($id)
    {
        $certificate = Certificate::findOrFail($id);
        $users = \App\Models\User::where('role', 'student')->get();
        $events = \App\Models\Event::all();
        return view('admin.certificates.edit', compact('certificate', 'users', 'events'));
    }

    public function update(Request $request, $id)
    {
         $certificate = Certificate::findOrFail($id);
         
         $request->validate([
             'code' => 'required|unique:certificates,code,'.$id,
             'issued_at' => 'required|date',
             'template_url' => 'nullable|url'
         ]);

         $certificate->update($request->all());

         return redirect()->route('admin.certificates.index')->with('success', 'Cập nhật chứng nhận thành công.');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();
        return redirect()->route('admin.certificates.index')->with('success', 'Đã xóa chứng nhận.');
    }
}
