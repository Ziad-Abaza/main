<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ChildLevelSubscription;
use App\Models\ChildrenUniversity;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ChildLevelController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_payments']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = ChildLevelSubscription::with(['child.user', 'level']);

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by level
            if ($request->filled('level_id')) {
                $query->where('level_id', $request->level_id);
            }

            // Search by child name or level name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('child', function ($childQuery) use ($search) {
                        $childQuery->where('code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('level', function ($levelQuery) use ($search) {
                        $levelQuery->where('name', 'like', "%{$search}%");
                    });
                });
            }

            $subscriptions = $query->orderBy('created_at', 'desc')->paginate(20);
            $levels = Level::all();

            return view('dashboard.child_levels.index', compact('subscriptions', 'levels'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch child level subscriptions');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $children = ChildrenUniversity::with('user')->get();
            $levels = Level::all();
            return view('dashboard.child_levels.create', compact('children', 'levels'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load create form');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'child_id' => 'required|exists:children_universities,id',
                'level_id' => 'required|exists:levels,level_id',
                'subscribe_date' => 'required|date',
                'expiry_date' => 'required|date|after:subscribe_date',
                'status' => 'required|in:active,inactive,expired,suspended',
            ]);

            // Check if child already has an active subscription for this level
            $existingSubscription = ChildLevelSubscription::where('child_id', $validated['child_id'])
                ->where('level_id', $validated['level_id'])
                ->where('status', 'active')
                ->first();

            if ($existingSubscription) {
                return back()->withInput()->with('error', 'Child already has an active subscription for this level');
            }

            ChildLevelSubscription::create($validated);

            return redirect()->route('console.child_levels.index')->with('success', 'Child level subscription created successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to create child level subscription');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildLevelSubscription $childLevel)
    {
        try {
            $childLevel->load(['child.user', 'level']);
            return view('dashboard.child_levels.show', compact('childLevel'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to display child level subscription');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildLevelSubscription $childLevel)
    {
        try {
            $children = ChildrenUniversity::with('user')->get();
            $levels = Level::all();
            return view('dashboard.child_levels.edit', compact('childLevel', 'children', 'levels'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildLevelSubscription $childLevel)
    {
        try {
            $validated = $request->validate([
                'child_id' => 'required|exists:children_universities,id',
                'level_id' => 'required|exists:levels,level_id',
                'subscribe_date' => 'required|date',
                'expiry_date' => 'required|date|after:subscribe_date',
                'status' => 'required|in:active,inactive,expired,suspended',
            ]);

            // Check if another child already has an active subscription for this level
            $existingSubscription = ChildLevelSubscription::where('child_id', $validated['child_id'])
                ->where('level_id', $validated['level_id'])
                ->where('status', 'active')
                ->where('subscription_id', '!=', $childLevel->subscription_id)
                ->first();

            if ($existingSubscription) {
                return back()->withInput()->with('error', 'Child already has an active subscription for this level');
            }

            $childLevel->update($validated);

            return redirect()->route('console.child_levels.show', $childLevel)->with('success', 'Child level subscription updated successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update child level subscription');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildLevelSubscription $childLevel)
    {
        try {
            $childLevel->delete();
            return redirect()->route('console.child_levels.index')->with('success', 'Child level subscription deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete child level subscription');
        }
    }

    /**
     * Update subscription status.
     */
    public function updateStatus(Request $request, ChildLevelSubscription $childLevel)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive,expired,suspended'
            ]);

            $childLevel->update(['status' => $request->status]);

            return redirect()->back()->with('success', "Subscription status updated to {$request->status}");
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update subscription status');
        }
    }

    /**
     * Export child level subscriptions.
     */
    public function export(Request $request)
    {
        try {
            $query = ChildLevelSubscription::with(['child.user', 'level']);

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('level_id')) {
                $query->where('level_id', $request->level_id);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('child', function ($childQuery) use ($search) {
                        $childQuery->where('code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('level', function ($levelQuery) use ($search) {
                        $levelQuery->where('name', 'like', "%{$search}%");
                    });
                });
            }

            if ($request->filled('date_from')) {
                $query->whereDate('subscribe_date', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('subscribe_date', '<=', $request->date_to);
            }

            $subscriptions = $query->orderBy('created_at', 'desc')->get();

            // Generate CSV
            $filename = 'child_level_subscriptions_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ];

            $callback = function () use ($subscriptions) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // CSV headers
                fputcsv($file, [
                    'Subscription ID',
                    'Child Code',
                    'Child Name',
                    'Parent Name',
                    'Level Name',
                    'Subscribe Date',
                    'Expiry Date',
                    'Status',
                    'Created Date'
                ]);

                // CSV data
                foreach ($subscriptions as $subscription) {
                    fputcsv($file, [
                        $subscription->subscription_id,
                        $subscription->child->code ?? 'N/A',
                        $subscription->child->user->name ?? 'N/A',
                        $subscription->child->user->name ?? 'N/A',
                        $subscription->level->name ?? 'N/A',
                        $subscription->subscribe_date ? (is_string($subscription->subscribe_date) ? $subscription->subscribe_date : $subscription->subscribe_date->format('Y-m-d H:i:s')) : 'N/A',
                        $subscription->expiry_date ? (is_string($subscription->expiry_date) ? $subscription->expiry_date : $subscription->expiry_date->format('Y-m-d H:i:s')) : 'N/A',
                        ucfirst($subscription->status),
                        $subscription->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to export child level subscriptions');
        }
    }
}
