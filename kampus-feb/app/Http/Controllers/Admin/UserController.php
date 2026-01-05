<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
    $this->middleware('admin'); // atau middleware role checking Anda
}

    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);

        $stats = [
            'total' => User::count(),
            'admins' => User::admins()->count(),
            'users' => User::regularUsers()->count(),
            'active' => User::active()->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        // ✅ Konsisten dengan view - hanya super admin
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menambah user.');
        }
        
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // ✅ Double check authorization
        if (!auth()->user()->isSuperAdmin() && in_array($request->role, ['super_admin', 'admin'])) {
            abort(403, 'Hanya Super Admin yang dapat membuat akun Admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'phone' => 'nullable|string|max:20',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'password' => 'required|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        try {
            DB::beginTransaction();
            
            $user = User::create($validated);

            Log::info('New user created', [
                'user_id' => $user->id,
                'role' => $user->role,
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user', [
                'error' => $e->getMessage(),
                'created_by' => auth()->id(),
            ]);
            
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isSuperAdmin() && $user->isAdmin()) {
            abort(403, 'Anda tidak dapat mengedit admin lain.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // ✅ Prevent self role change
        if ($user->id === auth()->id() && $request->role !== $user->role) {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }

        // ✅ Authorization checks
        if (!auth()->user()->isSuperAdmin() && $user->isAdmin()) {
            abort(403, 'Anda tidak dapat mengedit admin lain.');
        }

        if (!auth()->user()->isSuperAdmin() && in_array($request->role, ['super_admin', 'admin'])) {
            abort(403, 'Hanya Super Admin yang dapat mengubah role menjadi Admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')
                    ->ignore($user->id)
                    ->whereNull('deleted_at')
            ],
            'phone' => 'nullable|string|max:20',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'password' => 'nullable|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', $user->is_active);

        try {
            DB::beginTransaction();
            
            $user->update($validated);

            Log::info('User updated', [
                'user_id' => $user->id,
                'updated_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'updated_by' => auth()->id(),
            ]);
            
            return back()
                ->with('error', 'Terjadi kesalahan saat mengupdate data.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function destroy(User $user)
    {
        // ✅ Prevent self deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // ✅ Authorization check
        if ($user->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menghapus admin.');
        }

        try {
            DB::beginTransaction();
            
            $userId = $user->id;
            $userEmail = $user->email;
            
            $user->forceDelete();

            Log::info('User permanently deleted', [
                'user_id' => $userId,
                'deleted_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus permanen.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'deleted_by' => auth()->id(),
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function toggleStatus(User $user)
    {
        // ✅ Prevent self toggle
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        // ✅ Authorization check
        if ($user->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengubah status admin.');
        }

        try {
            // ✅ Atomic update
            $user->update(['is_active' => !$user->is_active]);

            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            return back()->with('success', "User berhasil {$status}.");

        } catch (\Exception $e) {
            Log::error('Error toggling user status', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat mengubah status.');
        }
    }
}