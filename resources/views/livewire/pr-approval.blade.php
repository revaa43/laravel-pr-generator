<div class="space-y-8">

    {{-- ========================================================= --}}
    {{-- FLASH MESSAGES --}}
    {{-- ========================================================= --}}
    @if (session('success'))
        <div class="flex items-center gap-3 p-3 rounded-lg border border-green-200 bg-green-50 text-green-700 shadow-soft">
            <x-icon name="check" class="w-5 h-5 text-green-600" />
            <span class="text-sm font-medium leading-tight">
                {{ session('success') }}
            </span>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-3 p-3 rounded-lg border border-red-200 bg-red-50 text-red-700 shadow-soft">
            <x-icon name="x" class="w-5 h-5 text-red-600" />
            <span class="text-sm font-medium leading-tight">
                {{ session('error') }}
            </span>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- TOP STAT CARDS --}}
    {{-- ========================================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- PENDING --}}
        <div class="rounded-xl border border-secondary-200 bg-white shadow-soft p-5 flex justify-between items-center">
            <div>
                <p class="text-xs font-medium text-secondary-500">Pending Approval</p>
                <h3 class="text-3xl font-bold text-secondary-900 mt-1">{{ $stats['pending'] }}</h3>
                <p class="text-xs text-amber-600 flex items-center gap-1 mt-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> Menunggu persetujuan
                </p>
            </div>

            <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                <x-icon name="clock" class="w-6 h-6" />
            </div>
        </div>

        {{-- APPROVED TODAY --}}
        <div class="rounded-xl border border-secondary-200 bg-white shadow-soft p-5 flex justify-between items-center">
            <div>
                <p class="text-xs font-medium text-secondary-500">Approved Today</p>
                <h3 class="text-3xl font-bold text-secondary-900 mt-1">{{ $stats['approved_today'] }}</h3>
                <p class="text-xs text-green-600 flex items-center gap-1 mt-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Hari ini
                </p>
            </div>

            <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                <x-icon name="check" class="w-6 h-6" />
            </div>
        </div>

        {{-- TOTAL AMOUNT --}}
        <div class="rounded-xl border border-secondary-200 bg-white shadow-soft p-5 flex justify-between items-center">
            <div>
                <p class="text-xs font-medium text-secondary-500">Total Amount Pending</p>
                <h3 class="text-2xl font-bold text-secondary-900 mt-1">
                    Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}
                </h3>
                <p class="text-xs text-secondary-500 mt-2">Pending approval</p>
            </div>

            <div class="w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center">
                <x-icon name="credit-card" class="w-6 h-6" />
            </div>
        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- FILTERS --}}
    {{-- ========================================================= --}}
    <div class="rounded-xl border border-secondary-200 bg-white shadow-soft p-5 space-y-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- SEARCH --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-secondary-600">Search</label>
                <input 
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    class="input bg-white border-secondary-200 focus:border-primary-400"
                    placeholder="PR number, perihal..."
                >
            </div>

            {{-- OUTLET --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-secondary-600">Outlet</label>
                <select wire:model.live="outletFilter"
                    class="input bg-white border-secondary-200 focus:border-primary-400">
                    <option value="">Semua Outlet</option>
                    @foreach($outlets as $outlet)
                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- DATE FROM --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-secondary-600">Dari Tanggal</label>
                <input type="date" 
                    wire:model.live="dateFrom"
                    class="input bg-white border-secondary-200 focus:border-primary-400">
            </div>

            {{-- DATE TO --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-secondary-600">Sampai Tanggal</label>
                <input type="date" 
                    wire:model.live="dateTo"
                    class="input bg-white border-secondary-200 focus:border-primary-400">
            </div>

        </div>

        <div class="flex justify-end">
            <button 
                wire:click="resetFilters"
                class="flex items-center gap-1.5 px-3 py-2 text-xs rounded-lg border border-secondary-200 text-secondary-700 hover:bg-secondary-100/60 transition"
            >
                <x-icon name="refresh" class="w-4 h-4" />
                Reset Filter
            </button>
        </div>

    </div>

    {{-- BULK ACTIONS - Tambahkan sebelum table --}}
    @if(count($selectedPrs) > 0)
    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-secondary-900">{{ count($selectedPrs) }} PR dipilih</p>
                <p class="text-xs text-secondary-600">Approve semua sekaligus dengan signature dari profile Anda</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if(Auth::user()->hasSignature())
                <button 
                    wire:click="bulkApprove"
                    wire:confirm="Approve {{ count($selectedPrs) }} PR sekaligus?"
                    class="btn-primary text-sm">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Bulk Approve
                </button>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-lg px-4 py-2">
                    <p class="text-xs text-amber-700">
                        <a href="{{ route('profile') }}" class="font-semibold underline">Set signature di Profile</a> untuk bulk approve
                    </p>
                </div>
            @endif

            <button 
                wire:click="$set('selectedPrs', [])"
                class="text-sm text-secondary-600 hover:text-secondary-900">
                Batal
            </button>
        </div>
    </div>
    @endif

    {{-- ========================================================= --}}
    {{-- APPROVAL TABLE --}}
    {{-- ========================================================= --}}
    <div class="rounded-xl border border-secondary-200 bg-white shadow-soft">

        <div class="overflow-x-auto rounded-xl">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-12">
                            <input type="checkbox"
                                wire:model.live="selectAll"
                                class="w-4 h-4 rounded border-secondary-300 text-primary-600 focus:ring-primary-500"
                            >
                        </th>
                        <th>PR Number</th>
                        <th>Tanggal</th>
                        <th>Perihal</th>
                        <th>Outlet</th>
                        <th>Total</th>
                        <th>Created By</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendingPrs as $pr)
                        <tr>
                            <td>
                                <input type="checkbox"
                                    wire:model.live="selectedPrs"
                                    value="{{ $pr->id }}"
                                    class="w-4 h-4 rounded border-secondary-300 text-primary-600 focus:ring-primary-500"
                                >
                            </td>

                            <td class="font-medium text-primary-600">
                                <a href="{{ route('pr.show', $pr->id) }}" class="hover:underline">
                                    {{ $pr->pr_number }}
                                </a>
                            </td>

                            <td>{{ $pr->tanggal->format('d M Y') }}</td>

                            <td class="max-w-xs truncate">{{ $pr->perihal }}</td>

                            <td>{{ $pr->outlet->name }}</td>

                            <td class="font-semibold">
                                Rp {{ number_format($pr->total, 0, ',', '.') }}
                            </td>

                            <td class="text-sm">{{ $pr->creator->name }}</td>

                            <td class="text-right">
                                <div class="flex justify-end items-center gap-2">

                                    {{-- VIEW --}}
                                    <a href="{{ route('pr.show', $pr->id) }}"
                                        class="text-secondary-600 hover:text-primary-600 p-1.5 rounded-lg hover:bg-secondary-50 transition-colors"
                                        title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    {{-- APPROVE --}}
                                    <button 
                                        wire:click="openApproveModal({{ $pr->id }})"
                                        class="text-green-600 hover:text-green-700 p-1.5 rounded-lg hover:bg-green-50 transition-colors"
                                        title="Approve PR">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>

                                    {{-- REJECT --}}
                                    <button 
                                        wire:click="openRejectModal({{ $pr->id }})"
                                        class="text-red-600 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition-colors"
                                        title="Reject PR">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <x-icon name="circle-x" class="w-14 h-14 mx-auto text-secondary-300" />
                                <p class="font-semibold text-secondary-700 mt-2">Tidak ada PR pending</p>
                                <p class="text-sm text-secondary-500">Semua PR sudah diproses</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <x-pagination :paginator="$pendingPrs" />
    </div>

    {{-- REJECT MODAL --}}
    @if($showRejectModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm animate-fade-in">

            <div class="w-full max-w-md bg-white rounded-xl shadow-2xl animate-scale-in">
                
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-red-200 bg-red-50 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-red-700">Reject Purchase Requisition</h3>
                    <p class="text-xs text-red-500 mt-1">Berikan alasan penolakan PR ini</p>
                </div>

                {{-- Form --}}
                <form wire:submit.prevent="rejectPr" class="p-6 space-y-5">

                    {{-- Input --}}
                    <div>
                        <label class="text-sm font-medium text-secondary-800">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>

                        <textarea 
                            wire:model="rejectionNote"
                            rows="4"
                            class="mt-2 input bg-white border-secondary-300 focus:border-red-400 @error('rejectionNote') input-error @enderror"
                            placeholder="Jelaskan alasan penolakan (minimal 10 karakter)"
                        ></textarea>

                        @error('rejectionNote')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-1 text-xs text-secondary-500">
                            {{ strlen($rejectionNote) }}/500 karakter
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 pt-2">
                        <button 
                            type="button"
                            wire:click="closeRejectModal"
                            class="w-full text-center px-4 py-2 rounded-lg border border-secondary-300 text-secondary-700 hover:bg-secondary-100 transition">
                            Batal
                        </button>

                        <button 
                            type="submit"
                            class="w-full text-center px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                            Reject PR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- APPROVE MODAL --}}
    @if($showApproveModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm animate-fade-in">

        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl animate-scale-in">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-primary-200 bg-gradient-to-r from-primary-50 to-orange-light-100 rounded-t-xl">
                <h3 class="text-lg font-semibold text-primary-700">Approve Purchase Requisition</h3>
                <p class="text-xs text-primary-600 mt-1">Upload tanda tangan untuk persetujuan PR</p>
            </div>

            {{-- Form --}}
            <form wire:submit.prevent="approvePr" class="p-6 space-y-5">

                {{-- Signature Preview --}}
                <div class="space-y-3">
                    <label class="text-sm font-medium text-secondary-800">
                        Tanda Tangan Manager <span class="text-red-500">*</span>
                    </label>

                    @if($managerSignature)
                        {{-- New uploaded signature --}}
                        <div class="relative inline-block">
                            <div class="w-full h-32 rounded-lg border-2 border-primary-200 bg-white p-3 flex items-center justify-center">
                                <img src="{{ $managerSignature->temporaryUrl() }}" class="max-w-full max-h-full object-contain">
                            </div>
                            <button 
                                type="button" 
                                wire:click="$set('managerSignature', null)"
                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <p class="text-xs text-green-600 mt-2 font-medium">✓ Signature baru akan digunakan</p>
                        </div>
                    @elseif($existingManagerSignature)
                        {{-- Signature from profile --}}
                        <div class="space-y-3">
                            <div class="w-full h-32 rounded-lg border-2 border-secondary-200 bg-white p-3 flex items-center justify-center">
                                <img src="{{ Storage::url($existingManagerSignature) }}" class="max-w-full max-h-full object-contain">
                            </div>
                            
                            <div class="flex items-start gap-2 text-xs bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-blue-700 font-medium">Menggunakan signature dari profile Anda</p>
                                    <p class="text-blue-600 mt-0.5">Upload signature baru di bawah jika ingin menggunakan yang berbeda</p>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- No signature --}}
                        <div class="w-full h-32 rounded-lg border-2 border-dashed border-secondary-300 bg-secondary-50 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-10 h-10 mx-auto text-secondary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                <p class="text-xs text-secondary-500 font-medium">Belum ada signature</p>
                                <p class="text-xs text-secondary-400 mt-1">Upload di bawah atau set di <a href="{{ route('profile') }}" class="text-primary-600 hover:underline">Profile</a></p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Upload Input --}}
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <label class="btn-secondary cursor-pointer text-sm">
                            <input type="file" wire:model="managerSignature" accept="image/*" class="hidden">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ $existingManagerSignature ? 'Ganti Signature' : 'Upload Signature' }}
                        </label>

                        @if(!Auth::user()->hasSignature())
                            <a href="{{ route('profile') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                atau set di Profile →
                            </a>
                        @endif
                    </div>

                    <p class="text-xs text-secondary-500">
                        Format: JPG, PNG. Max 2MB. Scan atau foto tanda tangan Anda.
                    </p>

                    @error('managerSignature') 
                        <p class="text-xs text-red-600 font-medium">{{ $message }}</p> 
                    @enderror

                    {{-- Upload Progress --}}
                    <div wire:loading wire:target="managerSignature" class="flex items-center gap-2 text-xs text-primary-600">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading signature...
                    </div>

                    {{-- Warning if no profile signature --}}
                    @if(!Auth::user()->hasSignature() && !$existingManagerSignature)
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-amber-800">Tips: Set signature di Profile</p>
                                    <p class="text-xs text-amber-700 mt-1">Upload signature sekali di <a href="{{ route('profile') }}" class="underline font-medium">Profile</a>, otomatis terisi untuk semua approval!</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 pt-2">
                    <button 
                        type="button"
                        wire:click="closeApproveModal"
                        class="w-full text-center px-4 py-2.5 rounded-lg border border-secondary-300 text-secondary-700 hover:bg-secondary-100 transition font-medium">
                        Batal
                    </button>

                    <button 
                        type="submit"
                        class="w-full text-center px-4 py-2.5 rounded-lg bg-gradient-to-r from-primary-600 to-primary-700 text-white hover:from-primary-700 hover:to-primary-800 transition shadow-orange font-medium"
                        wire:loading.attr="disabled"
                        wire:target="approvePr, managerSignature">
                        <span wire:loading.remove wire:target="approvePr">Approve PR</span>
                        <span wire:loading wire:target="approvePr">
                            <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

            </form>

        </div>

    </div>
    @endif
</div>