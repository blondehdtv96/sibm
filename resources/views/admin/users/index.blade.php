@extends('layouts.admin-modern')

@section('title', 'Pengguna')

@section('content')
<div class="space-y-6" x-data="{ 
    selectedUsers: [],
    bulkAction: '',
    bulkRole: '',
    showBulkModal: false
}">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola akun pengguna dan peran</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New User
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="search" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari pengguna berdasarkan nama, email, atau telepon..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                >
            </div>
            <div class="w-full md:w-48">
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="teacher" {{ request('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Hapus
                </a>
            @endif
        </form>
    </div>
    
    <!-- Bulk Actions Bar -->
    <div x-show="selectedUsers.length > 0" x-transition class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">
                <span x-text="selectedUsers.length"></span> pengguna dipilih
            </span>
            <div class="flex items-center space-x-2">
                <button @click="bulkAction = 'change_role'; showBulkModal = true" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                    Ubah Peran
                </button>
                <button @click="bulkAction = 'delete'; showBulkModal = true" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm">
                    Hapus Terpilih
                </button>
            </div>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left w-16">
                                <input 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-ios-blue focus:ring-ios-blue"
                                    @change="selectedUsers = $event.target.checked ? {{ $users->pluck('id')->toJson() }} : []"
                                >
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input 
                                    type="checkbox" 
                                    class="rounded border-gray-300 text-ios-blue focus:ring-ios-blue"
                                    value="{{ $user->id }}"
                                    x-model="selectedUsers"
                                >
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($user->profile_image)
                                        <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-ios-blue rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->role === 'admin') bg-red-100 text-red-700
                                    @elseif($user->role === 'teacher') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-gray-400 hover:text-ios-blue transition-colors" title="View">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-gray-400 hover:text-ios-blue transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-500 mb-6">{{ request('search') ? 'Try adjusting your search criteria' : 'Get started by creating your first user' }}</p>
                @if(!request('search'))
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create User
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Bulk Action Modal -->
<div x-show="showBulkModal" 
     x-transition
     class="ios-modal-overlay"
     @click.self="showBulkModal = false">
    <div class="ios-modal">
        <div class="ios-modal-header">
            <h3 x-text="bulkAction === 'delete' ? 'Delete Users' : 'Change Role'"></h3>
            <button @click="showBulkModal = false" class="ios-button-ghost ios-button-sm">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.users.bulk-action') }}">
            @csrf
            <input type="hidden" name="action" x-model="bulkAction">
            <template x-for="userId in selectedUsers" :key="userId">
                <input type="hidden" name="user_ids[]" :value="userId">
            </template>
            
            <div class="ios-modal-body">
                <template x-if="bulkAction === 'delete'">
                    <div>
                        <p>Are you sure you want to delete <span x-text="selectedUsers.length"></span> user(s)?</p>
                        <p class="ios-text-secondary ios-text-sm">This action cannot be undone.</p>
                    </div>
                </template>
                
                <template x-if="bulkAction === 'change_role'">
                    <div class="ios-form-group">
                        <label class="ios-form-label">Select New Role</label>
                        <select name="role" x-model="bulkRole" class="ios-select" required>
                            <option value="">Choose a role...</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                </template>
            </div>
            
            <div class="ios-modal-footer">
                <button type="button" @click="showBulkModal = false" class="ios-button-ghost">Cancel</button>
                <button type="submit" 
                        class="ios-button-primary"
                        :class="{ 'ios-button-danger': bulkAction === 'delete' }">
                    <span x-text="bulkAction === 'delete' ? 'Delete' : 'Update'"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.user-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--ios-blue);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
}

.bulk-actions {
    padding: 12px 16px;
    background: var(--ios-blue-light);
    border-bottom: 1px solid var(--ios-separator);
}
</style>
@endsection
