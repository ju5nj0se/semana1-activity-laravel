<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\User;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::query()->with('user');

        // Filtros
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }
        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
        }
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        $audits = $query->latest()->paginate(10);

        $users = User::all();
        $events = Audit::select('event')->distinct()->pluck('event');
        $models = Audit::select('auditable_type')->distinct()->pluck('auditable_type');

        return view('audits.index', compact('audits', 'users', 'events', 'models'));
    }
}
