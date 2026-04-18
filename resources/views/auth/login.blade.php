<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sushi Mentai PR System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .fade-in { animation: fadeIn 0.4s ease both; }
        .fade-in-2 { animation: fadeIn 0.4s 0.08s ease both; }
    </style>
</head>
<body class="min-h-screen bg-secondary-50 antialiased">

    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- ══ LEFT: PHOTO PANEL ══ --}}
        <div class="hidden lg:block relative overflow-hidden">

            {{-- Photo --}}
            <img
                src="/sushi-mentai-store.jpg"
                alt="Sushi Mentai Store"
                class="absolute inset-0 w-full h-full object-cover object-center"
            >

            {{-- Subtle dark overlay so text is readable --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/10"></div>

            {{-- Bottom content --}}
            <div class="absolute bottom-0 left-0 right-0 p-10 fade-in-2">
                <p class="text-xs font-semibold tracking-widest text-white/60 uppercase mb-3">Internal Platform</p>
                <h2 class="text-3xl font-bold text-white leading-snug mb-3">
                    Purchase Requisition<br>Management System
                </h2>
                <p class="text-sm text-white/60 max-w-sm leading-relaxed">
                    Platform internal untuk pengelolaan purchase requisition operasional Sushi Mentai.
                </p>

                {{-- <div class="mt-6 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-xs text-white/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 inline-block"></span>
                        Digital Approval
                    </span>
                    <span class="text-white/20">·</span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-white/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 inline-block"></span>
                        Real-time Tracking
                    </span>
                    <span class="text-white/20">·</span>
                    <span class="inline-flex items-center gap-1.5 text-xs text-white/50">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-400 inline-block"></span>
                        Activity Log
                    </span>
                </div> --}}
            </div>
        </div>

        {{-- ══ RIGHT: FORM PANEL ══ --}}
        <div class="flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-sm fade-in">

                {{-- Logo --}}
                <div class="mb-8">
                    <img src="/sushi-mentai-logo.png" alt="Sushi Mentai" class="h-10 w-auto mb-6">
                    <h1 class="text-xl font-bold text-secondary-900 mb-1">Selamat datang</h1>
                    <p class="text-sm text-secondary-500">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                {{-- Error --}}
                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 rounded-lg flex gap-2.5 items-start">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-xs text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-secondary-700 mb-1.5">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@sushimentai.com"
                            required autofocus
                            class="w-full px-3.5 py-2.5 text-sm border border-secondary-200 rounded-lg bg-secondary-50 text-secondary-900 placeholder-secondary-400
                                   focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-primary-400 focus:bg-white transition"
                        >
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-secondary-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full px-3.5 py-2.5 pr-10 text-sm border border-secondary-200 rounded-lg bg-secondary-50 text-secondary-900 placeholder-secondary-400
                                       focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-primary-400 focus:bg-white transition"
                            >
                            <button type="button" onclick="togglePwd()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-secondary-400 hover:text-secondary-600 transition">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-3.5 h-3.5 rounded border-secondary-300 text-primary-500 focus:ring-primary-400 cursor-pointer">
                            <span class="text-xs text-secondary-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-700 transition">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg transition shadow-sm hover:shadow-orange">
                        Masuk
                    </button>
                </form>

                <!-- {{-- Divider --}}
                <div class="flex items-center gap-3 my-6">
                    <div class="flex-1 h-px bg-secondary-100"></div>
                    <span class="text-xs text-secondary-400 font-medium tracking-wide uppercase">Demo</span>
                    <div class="flex-1 h-px bg-secondary-100"></div>
                </div>

                {{-- Demo Accounts --}}
                @php
                    $demoAccounts = [
                        ['role' => 'Super Admin', 'initial' => 'SA', 'email' => 'superadmin@company.com', 'color' => 'bg-violet-100 text-violet-700'],
                        ['role' => 'Manager',     'initial' => 'MG', 'email' => 'manager@company.com',    'color' => 'bg-blue-100 text-blue-700'],
                        ['role' => 'Staff',       'initial' => 'ST', 'email' => 'staff1@company.com',     'color' => 'bg-green-100 text-green-700'],
                    ];
                @endphp

                <div class="space-y-2">
                    @foreach ($demoAccounts as $acc)
                        <div class="flex items-center justify-between px-3 py-2.5 rounded-lg border border-secondary-100 hover:border-primary-200 hover:bg-primary-50/40 transition cursor-default">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg {{ $acc['color'] }} flex items-center justify-center text-[10px] font-bold flex-shrink-0">
                                    {{ $acc['initial'] }}
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-secondary-800">{{ $acc['role'] }}</p>
                                    <p class="text-[11px] text-secondary-400">{{ $acc['email'] }}</p>
                                </div>
                            </div>
                            <button type="button"
                                onclick="fillDemo('{{ $acc['email'] }}')"
                                class="text-[11px] font-semibold text-primary-600 hover:text-primary-700 px-2.5 py-1 rounded-md hover:bg-primary-100 transition">
                                Gunakan
                            </button>
                        </div>
                    @endforeach
                </div>

                <p class="text-center text-[11px] text-secondary-400 mt-4">
                    Password demo: <code class="bg-secondary-100 text-secondary-600 px-1.5 py-0.5 rounded font-mono">password</code>
                </p> -->

                {{-- Footer --}}
                <p class="text-center text-[11px] text-secondary-300 mt-8">
                    © {{ date('Y') }} Sushi Mentai. All rights reserved.
                </p>

            </div>
        </div>

    </div>

    <script>
        function togglePwd() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        }

        function fillDemo(email) {
            document.getElementById('email').value    = email;
            document.getElementById('password').value = 'password';
        }
    </script>

</body>
</html>