<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLost      = Item::where('type', 'Lost')->count();
        $totalFound     = Item::where('type', 'Found')->count();
        $totalClaimed   = Claim::where('status', 'Approved')->count();
        $totalPending   = Item::where('status', 'Pending')->count();
        $pendingUsers   = User::where('status', 'pending')->count();
        $recentItems    = Item::with('user')->latest()->take(10)->get();
        return view('admin.dashboard', compact(
            'totalLost', 'totalFound', 'totalClaimed', 'totalPending', 'pendingUsers', 'recentItems'
        ));
    }

    public function items(Request $request)
    {
        $query = Item::with('user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $items = $query->latest()->paginate(15);
        return view('admin.items', compact('items'));
    }

    public function updateItemStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Found,Lost,Resolved,Claimed',
        ]);
        Item::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Item status updated successfully.');
    }

    public function destroyItem($id)
    {
        Item::findOrFail($id)->delete();
        return back()->with('success', 'Item deleted successfully.');
    }

    public function users(Request $request)
    {
        $query = User::where('id', '!=', Auth::id());

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate(['role' => 'required|in:student,instructor,admin']);
        User::findOrFail($id)->update(['role' => $request->role]);
        return back()->with('success', 'User role updated successfully.');
    }

    public function destroyUser($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function claims()
    {
        $claims = Claim::with(['item', 'user'])->latest()->get();
        return view('admin.claims', compact('claims'));
    }

    public function approveClaim(Request $request, $claim)
    {
        $c = Claim::findOrFail($claim);
        $c->update(['status' => 'Approved']);
        if ($c->item) {
            $c->item->update(['status' => 'Resolved']);
        }
        return redirect()->route('admin.claims')->with('success', 'Claim approved successfully!');
    }

    public function rejectClaim(Request $request, $claim)
    {
        $c = Claim::findOrFail($claim);
        $c->update(['status' => 'Rejected']);
        return redirect()->route('admin.claims')->with('success', 'Claim rejected.');
    }

    public function verification()
    {
        $pendingUsers  = User::where('status', 'pending')->latest()->get();
        $verifiedUsers = User::where('status', 'verified')->latest()->get();
        $rejectedUsers = User::where('status', 'rejected')->latest()->get();
        return view('admin.verification', compact('pendingUsers', 'verifiedUsers', 'rejectedUsers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'verified']);
        return back()->with('success', $user->name . ' has been verified.');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        return back()->with('success', $user->name . ' has been rejected.');
    }

    public function analytics()
    {
        $totalLost      = Item::where('type', 'Lost')->count();
        $totalFound     = Item::where('type', 'Found')->count();
        $totalActivity  = Item::count();
        $successStories = Item::where('status', 'Resolved')->count();
        $returned       = Item::where('status', 'Resolved')->count();
        $active         = Item::where('status', 'Pending')->count();
        $returnRate     = $totalActivity > 0 ? round(($successStories / $totalActivity) * 100) : 0;
        $avgRecovery    = 2.4;

        // Monthly data
        $monthlyItems = Item::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('type', 'Lost')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthLabels = $monthlyItems->map(fn($i) => date('M', mktime(0, 0, 0, $i->month, 1)))->toArray();
        $monthData   = $monthlyItems->pluck('total')->toArray();

        // Category data
        $categories = Item::selectRaw('category, COUNT(*) as total')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $categoryLabels = $categories->pluck('category')->toArray();
        $categoryData   = $categories->pluck('total')->toArray();

        return view('admin.analytics', compact(
            'totalLost', 'totalFound', 'totalActivity', 'successStories',
            'returnRate', 'avgRecovery', 'returned', 'active',
            'monthLabels', 'monthData', 'categoryLabels', 'categoryData'
        ));
    }
    
    public function reports(Request $request)
    {
        $query = Item::latest();

        if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

        if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

        $items = $query->get();
        return view('admin.reports', compact('items'));
    }

    public function activity()
    {
        $items = Item::with('user')->latest()->get();
        return view('admin.activity', compact('items'));
    }
}