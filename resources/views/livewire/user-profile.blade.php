<div class="max-w-4xl mx-auto space-y-6">
    
    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-secondary-900">My Profile</h1>
        <p class="text-sm text-secondary-500 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-xl border border-secondary-200 shadow-sm overflow-hidden">
        <div class="border-b border-secondary-200">
            <nav class="flex -mb-px">
                <button 
                    wire:click="$set('activeTab', 'profile')"
                    class="px-6 py-4 text-sm font-semibold {{ $activeTab === 'profile' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-secondary-500 hover:text-secondary-700' }}"
                >
                    Profile Information
                </button>
                <!-- <button 
                    wire:click="$set('activeTab', 'password')"
                    class="px-6 py-4 text-sm font-semibold {{ $activeTab === 'password' ? 'text-primary-600 border-b-2 border-primary-600' : 'text-secondary-500 hover:text-secondary-700' }}"
                >
                    Change Password
                </button> -->
            </nav>
        </div>

        {{-- Profile Tab --}}
        @if($activeTab === 'profile')
            <div class="p-6 space-y-6">
                
                {{-- Success/Error Messages --}}
                @if(session('profile-success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('profile-success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('profile-error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-red-800">{{ session('profile-error') }}</p>
                        </div>
                    </div>
                @endif

                <form wire:submit="updateProfile">
                    
                    {{-- Avatar Section --}}
                    <div class="pb-6 border-b border-secondary-200">
                        <h3 class="text-sm font-semibold text-secondary-900 mb-4">Profile Picture</h3>
                        <div class="flex items-start gap-6">
                            {{-- Current Avatar --}}
                            <div class="flex-shrink-0">
                                @if($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}" class="w-24 h-24 rounded-xl object-cover border-2 border-primary-200">
                                @elseif($existingAvatar)
                                    <img src="{{ Storage::url($existingAvatar) }}" class="w-24 h-24 rounded-xl object-cover border-2 border-secondary-200">
                                @else
                                    <div class="w-24 h-24 rounded-xl bg-gradient-to-br from-primary-100 to-orange-light-200 flex items-center justify-center border-2 border-primary-200">
                                        <span class="text-3xl font-bold text-primary-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Upload Controls --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <label class="btn-secondary cursor-pointer text-sm">
                                        <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Upload New
                                    </label>
                                    
                                    @if($existingAvatar)
                                        <button 
                                            type="button"
                                            wire:click="deleteAvatar"
                                            wire:confirm="Hapus avatar?"
                                            class="text-sm text-red-600 hover:text-red-700 font-medium"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </div>
                                <p class="text-xs text-secondary-500 mt-2">JPG, PNG. Max 2MB</p>
                                @error('avatar') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                
                                {{-- Upload Progress --}}
                                <div wire:loading wire:target="avatar" class="mt-2">
                                    <div class="flex items-center gap-2 text-xs text-primary-600">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Basic Info --}}
                    <div class="py-6 border-b border-secondary-200 space-y-4">
                        <h3 class="text-sm font-semibold text-secondary-900 mb-4">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" class="input" placeholder="John Doe">
                                @error('name') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="label">Email <span class="text-red-500">*</span></label>
                                <input type="email" wire:model="email" class="input" placeholder="john@example.com">
                                @error('email') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="label">No. Telepon</label>
                                <input type="text" wire:model="phone" class="input" placeholder="+62 812 3456 7890">
                                @error('phone') <p class="error-message">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="label">Role</label>
                                <input type="text" value="{{ Auth::user()->roles->pluck('name')->join(', ') }}" class="input bg-secondary-50" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Digital Signature Section --}}
                    <div class="py-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-semibold text-secondary-900">Digital Signature</h3>
                            <p class="text-xs text-secondary-500 mt-1">Upload tanda tangan digital Anda (akan otomatis digunakan saat membuat PR)</p>
                        </div>

                        <div class="flex items-start gap-6">
                            {{-- Current Signature --}}
                            <div class="flex-shrink-0">
                                @if($signature)
                                    <div class="w-48 h-24 rounded-lg border-2 border-primary-200 bg-white p-2 flex items-center justify-center">
                                        <img src="{{ $signature->temporaryUrl() }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                @elseif($existingSignature)
                                    <div class="w-48 h-24 rounded-lg border-2 border-secondary-200 bg-white p-2 flex items-center justify-center">
                                        <img src="{{ Storage::url($existingSignature) }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-48 h-24 rounded-lg border-2 border-dashed border-secondary-300 bg-secondary-50 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto text-secondary-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                            <p class="text-xs text-secondary-500">No signature</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Upload Controls --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <label class="btn-secondary cursor-pointer text-sm">
                                        <input type="file" wire:model="signature" accept="image/*" class="hidden">
                                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Upload Signature
                                    </label>
                                    
                                    @if($existingSignature)
                                        <button 
                                            type="button"
                                            wire:click="deleteSignature"
                                            wire:confirm="Hapus signature?"
                                            class="text-sm text-red-600 hover:text-red-700 font-medium"
                                        >
                                            Delete
                                        </button>
                                    @endif
                                </div>
                                <p class="text-xs text-secondary-500 mt-2">Scan atau foto tanda tangan Anda. Format: JPG, PNG. Max 2MB</p>
                                @error('signature') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                                
                                {{-- Upload Progress --}}
                                <div wire:loading wire:target="signature" class="mt-2">
                                    <div class="flex items-center gap-2 text-xs text-primary-600">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading...
                                    </div>
                                </div>

                                {{-- Info Alert --}}
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-xs text-blue-800">Signature yang di-upload akan otomatis digunakan saat Anda membuat PR baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-end gap-3 pt-6">
                        <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="updateProfile, avatar, signature">
                            <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                            <span wire:loading wire:target="updateProfile">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Password Tab --}}
        <!-- @if($activeTab === 'password')
            <div class="p-6">
                
                {{-- Success/Error Messages --}}
                @if(session('password-success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-green-800">{{ session('password-success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('password-error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-red-800">{{ session('password-error') }}</p>
                        </div>
                    </div>
                @endif

                <form wire:submit="updatePassword" class="max-w-md">
                    <div class="space-y-4">
                        <div>
                            <label class="label">Password Saat Ini <span class="text-red-500">*</span></label>
                            <input type="password" wire:model="current_password" class="input" placeholder="••••••••">
                            @error('current_password') <p class="error-message">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="label">Password Baru <span class="text-red-500">*</span></label>
                            <input type="password" wire:model="new_password" class="input" placeholder="••••••••">
                            @error('new_password') <p class="error-message">{{ $message }}</p> @enderror
                            <p class="text-xs text-secondary-500 mt-1">Minimal 8 karakter</p>
                        </div>

                        <div>
                            <label class="label">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                            <input type="password" wire:model="new_password_confirmation" class="input" placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                            <span wire:loading wire:target="updatePassword">
                                <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif -->
    </div>
</div>