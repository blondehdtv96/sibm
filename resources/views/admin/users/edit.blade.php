@extends('layouts.admin')

@section('title', 'Edit User')

@php
    $pageTitle = 'Edit User';
    $pageDescription = 'Update user account information';
    $breadcrumbs = [
        ['title' => 'Users', 'url' => route('admin.users.index')],
        ['title' => $user->name, 'url' => route('admin.users.show', $user)],
        ['title' => 'Edit', 'url' => '#']
    ];
@endphp

@section('content')
<div class="ios-card">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" x-data="{ 
        previewImage: '{{ $user->profile_image_url }}',
        showPassword: false,
        showPasswordConfirmation: false
    }">
        @csrf
        @method('PUT')
        
        <div class="ios-card-body">
            <div class="ios-grid ios-grid-cols-1 ios-gap-lg">
                <!-- Profile Image -->
                <div class="ios-form-group">
                    <label class="ios-form-label">Profile Image</label>
                    <div class="ios-flex ios-items-center ios-gap-md">
                        <div class="profile-image-preview">
                            <template x-if="previewImage">
                                <img :src="previewImage" alt="Preview">
                            </template>
                            <template x-if="!previewImage">
                                <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </div>
                        <div class="ios-flex-1">
                            <input 
                                type="file" 
                                name="profile_image" 
                                id="profile_image"
                                accept="image/*"
                                class="ios-input"
                                @change="previewImage = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                            >
                            <p class="ios-text-secondary ios-text-sm ios-mt-xs">JPG, PNG or GIF. Max 2MB.</p>
                        </div>
                    </div>
                    @error('profile_image')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Name -->
                <div class="ios-form-group">
                    <label for="name" class="ios-form-label">Full Name *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="ios-input @error('name') ios-input-error @enderror" 
                        value="{{ old('name', $user->name) }}"
                        required
                        autofocus
                    >
                    @error('name')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="ios-form-group">
                    <label for="email" class="ios-form-label">Email Address *</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="ios-input @error('email') ios-input-error @enderror" 
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="ios-form-group">
                    <label for="phone" class="ios-form-label">Phone Number</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        id="phone" 
                        class="ios-input @error('phone') ios-input-error @enderror" 
                        value="{{ old('phone', $user->phone) }}"
                    >
                    @error('phone')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role -->
                <div class="ios-form-group">
                    <label for="role" class="ios-form-label">Role *</label>
                    <select 
                        name="role" 
                        id="role" 
                        class="ios-select @error('role') ios-input-error @enderror"
                        required
                        @if($user->id === auth()->id()) disabled @endif
                    >
                        <option value="">Select a role...</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                    @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="ios-text-secondary ios-text-sm ios-mt-xs">You cannot change your own role.</p>
                    @else
                    <p class="ios-text-secondary ios-text-sm ios-mt-xs">
                        <strong>Admin:</strong> Full system access. 
                        <strong>Teacher:</strong> Content management. 
                        <strong>Student:</strong> Limited access.
                    </p>
                    @endif
                    @error('role')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ios-divider"></div>

                <div class="ios-alert ios-alert-info">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <strong>Change Password</strong>
                        <p>Leave password fields empty to keep the current password.</p>
                    </div>
                </div>

                <!-- Password -->
                <div class="ios-form-group">
                    <label for="password" class="ios-form-label">New Password</label>
                    <div class="ios-input-group">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            id="password" 
                            class="ios-input @error('password') ios-input-error @enderror"
                        >
                        <button 
                            type="button" 
                            class="ios-input-group-button"
                            @click="showPassword = !showPassword"
                        >
                            <svg x-show="!showPassword" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <svg x-show="showPassword" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="ios-text-secondary ios-text-sm ios-mt-xs">Minimum 8 characters</p>
                    @error('password')
                        <span class="ios-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="ios-form-group">
                    <label for="password_confirmation" class="ios-form-label">Confirm New Password</label>
                    <div class="ios-input-group">
                        <input 
                            :type="showPasswordConfirmation ? 'text' : 'password'" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="ios-input"
                        >
                        <button 
                            type="button" 
                            class="ios-input-group-button"
                            @click="showPasswordConfirmation = !showPasswordConfirmation"
                        >
                            <svg x-show="!showPasswordConfirmation" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <svg x-show="showPasswordConfirmation" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="ios-card-footer">
            <div class="ios-flex ios-items-center ios-justify-between">
                <div>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="ios-inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ios-button-danger ios-button-ghost">Delete User</button>
                    </form>
                    @endif
                </div>
                <div class="ios-flex ios-items-center ios-gap-sm">
                    <a href="{{ route('admin.users.index') }}" class="ios-button-ghost">Cancel</a>
                    <button type="submit" class="ios-button-primary">Update User</button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.profile-image-preview {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--ios-gray-light);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: var(--ios-gray);
}

.profile-image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ios-input-group {
    position: relative;
    display: flex;
}

.ios-input-group .ios-input {
    flex: 1;
    padding-right: 40px;
}

.ios-input-group-button {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--ios-gray);
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ios-input-group-button:hover {
    color: var(--ios-blue);
}

.ios-divider {
    height: 1px;
    background: var(--ios-separator);
    margin: 16px 0;
}
</style>
@endsection
