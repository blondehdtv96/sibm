@extends('layouts.admin-modern')

@section('title', 'Create PPDB Setting')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create PPDB Setting</h2>
            <p class="text-sm text-gray-500 mt-1">Set up a new student registration period</p>
        </div>
        <a href="{{ route('admin.ppdb-settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Settings
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <form action="{{ route('admin.ppdb-settings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="registration_start" class="block text-sm font-medium text-gray-700 mb-2">Registration Start Date *</label>
                    <input 
                        type="date" 
                        id="registration_start" 
                        name="registration_start" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('registration_start') border-red-500 @enderror"
                        value="{{ old('registration_start') }}"
                        required
                    >
                    @error('registration_start')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="registration_end" class="block text-sm font-medium text-gray-700 mb-2">Registration End Date *</label>
                    <input 
                        type="date" 
                        id="registration_end" 
                        name="registration_end" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('registration_end') border-red-500 @enderror"
                        value="{{ old('registration_end') }}"
                        required
                    >
                    @error('registration_end')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Requirements</label>
                <div id="requirements-container" class="space-y-2">
                    <div class="requirement-item flex gap-2">
                        <input 
                            type="text" 
                            name="requirements[]" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                            placeholder="e.g., Birth certificate copy"
                            value="{{ old('requirements.0') }}"
                        >
                    </div>
                </div>
                <button type="button" id="add-requirement" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    + Add Requirement
                </button>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">Note: Only one setting can be active at a time. Activating this will deactivate others.</p>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.ppdb-settings.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Create Setting
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('add-requirement').addEventListener('click', function() {
    const container = document.getElementById('requirements-container');
    const newItem = document.createElement('div');
    newItem.className = 'requirement-item flex gap-2';
    newItem.innerHTML = `
        <input 
            type="text" 
            name="requirements[]" 
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
            placeholder="e.g., Family card copy"
        >
        <button type="button" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors remove-requirement">
            Remove
        </button>
    `;
    container.appendChild(newItem);
    
    newItem.querySelector('.remove-requirement').addEventListener('click', function() {
        newItem.remove();
    });
});

// Handle removal of existing items
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-requirement')) {
        e.target.closest('.requirement-item').remove();
    }
});
</script>
@endpush
@endsection
