<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    
    public $avatar;
    public $existingAvatar;
    
    public $signature;
    public $existingSignature;
    
    // Password change
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    
    public $activeTab = 'profile'; // profile | password

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'signature' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'avatar.image' => 'File harus berupa gambar',
        'avatar.max' => 'Ukuran avatar maksimal 2MB',
        'signature.image' => 'File harus berupa gambar',
        'signature.max' => 'Ukuran signature maksimal 2MB',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->existingAvatar = $user->avatar_path;
        $this->existingSignature = $user->signature_path;
    }

    public function updateProfile()
    {
        $this->validate();

        try {
            $user = Auth::user();
            
            // Update basic info
            $user->name = $this->name;
            $user->email = $this->email;
            $user->phone = $this->phone;

            // Upload new avatar
            if ($this->avatar) {
                // Delete old avatar
                if ($this->existingAvatar && Storage::disk('public')->exists($this->existingAvatar)) {
                    Storage::disk('public')->delete($this->existingAvatar);
                }
                
                $avatarPath = $this->avatar->store('avatars', 'public');
                $user->avatar_path = $avatarPath;
                $this->existingAvatar = $avatarPath;
                $this->avatar = null; // Reset
            }

            // Upload new signature
            if ($this->signature) {
                // Delete old signature
                if ($this->existingSignature && Storage::disk('public')->exists($this->existingSignature)) {
                    Storage::disk('public')->delete($this->existingSignature);
                }
                
                $signaturePath = $this->signature->store('signatures', 'public');
                $user->signature_path = $signaturePath;
                $this->existingSignature = $signaturePath;
                $this->signature = null; // Reset
            }

            $user->save();

            session()->flash('profile-success', 'Profile berhasil diupdate');

        } catch (\Exception $e) {
            session()->flash('profile-error', 'Gagal update profile: ' . $e->getMessage());
        }
    }

    public function deleteAvatar()
    {
        try {
            $user = Auth::user();
            
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            
            $user->avatar_path = null;
            $user->save();
            
            $this->existingAvatar = null;
            
            session()->flash('profile-success', 'Avatar berhasil dihapus');
            
        } catch (\Exception $e) {
            session()->flash('profile-error', 'Gagal menghapus avatar');
        }
    }

    public function deleteSignature()
    {
        try {
            $user = Auth::user();
            
            if ($user->signature_path && Storage::disk('public')->exists($user->signature_path)) {
                Storage::disk('public')->delete($user->signature_path);
            }
            
            $user->signature_path = null;
            $user->save();
            
            $this->existingSignature = null;
            
            session()->flash('profile-success', 'Signature berhasil dihapus');
            
        } catch (\Exception $e) {
            session()->flash('profile-error', 'Gagal menghapus signature');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Password saat ini harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            $user = Auth::user();

            // Verify current password
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Password saat ini tidak sesuai');
                return;
            }

            // Update password
            $user->password = Hash::make($this->new_password);
            $user->save();

            // Reset form
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';

            session()->flash('password-success', 'Password berhasil diupdate');

        } catch (\Exception $e) {
            session()->flash('password-error', 'Gagal update password');
        }
    }

    public function render()
    {
        return view('livewire.user-profile')
            ->layout('components.layouts.app', ['title' => 'My Profile']);
    }
}