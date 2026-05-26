<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Kupon Qurban</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-group:focus-within label {
            color: #475569;
        }

        .input-group:focus-within i {
            color: #475569;
        }

        .input-group:focus-within input {
            border-color: #475569;
            box-shadow: 0 0 0 1px #475569;
        }
    </style>
</head>

<body class="bg-[#020617] min-h-screen font-sans text-slate-800 relative">

    {{-- Luxury Background Decoration --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full bg-slate-500/10 blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full bg-slate-600/10 blur-[120px] animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] rounded-full bg-gray-500/10 blur-[100px] animate-pulse"
            style="animation-delay: 4s;"></div>

        {{-- Subtle Grid Pattern --}}
        <div class="absolute inset-0 opacity-[0.03]"
            style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div
            class="w-full max-w-5xl h-auto bg-white rounded-2xl shadow-[0_0_50px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col md:flex-row relative z-10 animate-fade-in-up">

            {{-- Left Side: Branding / Visual --}}
            <div
                class="hidden md:flex w-1/2 bg-slate-900 relative flex-col justify-between p-12 text-white overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 opacity-90 z-10">
                </div>
                {{-- Abstract Pattern --}}
                <div class="absolute inset-0 z-0 opacity-20"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>

                <div class="relative z-20">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ asset('assets/images/logo.png') }}" class="h-10 w-auto bg-white rounded-lg p-1"
                            alt="Logo">
                        <span class="text-xl font-bold tracking-wider text-slate-300">ONLINE KUPON</span>
                    </div>
                    <h2 class="text-4xl font-extrabold leading-tight mb-4">
                        Sistem Kelola <br>
                        <span class="text-slate-400">Kupon Qurban</span> Digital.
                    </h2>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                        Aplikasi khusus Admin untuk mengelola data karyawan, mengimport data kupon, serta menyetujui pertukaran kupon qurban secara real-time.
                    </p>
                </div>

                <div class="relative z-20 space-y-4">
                    <div class="flex items-center gap-4 text-xs font-semibold text-slate-400 uppercase tracking-widest">
                        <span>Plant 1</span>
                        <span class="w-1 h-1 bg-slate-500 rounded-full"></span>
                        <span>Plant 3</span>
                        <span class="w-1 h-1 bg-slate-500 rounded-full"></span>
                        <span>Plant 4</span>
                    </div>
                    <div class="text-[10px] text-slate-500">
                        &copy; {{ date('Y') }} PT Mada Wikri Tunggal. Presented By Ardyan Syahputra.
                    </div>
                </div>
            </div>

            {{-- Right Side: Login Form --}}
            <div
                class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-gradient-to-br from-white via-white to-slate-50/30 relative">
                <div class="max-w-sm mx-auto w-full">

                    <div class="text-center md:text-left mb-10">
                        {{-- Mobile Branding --}}
                        <div class="flex md:hidden justify-center mb-8">
                            <div class="relative">
                                {{-- Gradient Glow --}}
                                <div
                                    class="absolute -inset-4 bg-gradient-to-tr from-slate-500/20 to-gray-500/20 blur-2xl rounded-full">
                                </div>
                                <img src="{{ asset('assets/images/logo.png') }}"
                                    class="h-16 w-auto relative z-10 drop-shadow-[0_4px_10px_rgba(100,116,139,0.4)]"
                                    alt="Logo">
                            </div>
                        </div>

                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome Back!</h3>
                        <p class="text-slate-500 text-sm mt-2 font-medium">Please sign in to access your dashboard.</p>
                    </div>

                    @if(session('success'))
                        <div
                            class="bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm mb-6 flex items-center gap-2 shadow-sm">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div
                            class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6 shadow-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="input-group">
                            <label for="username"
                                class="block text-xs font-bold uppercase text-slate-400 mb-1.5 transition-colors text-center md:text-left">Username</label>
                            <div class="relative">
                                <i
                                    class="fas fa-user-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors"></i>
                                <input type="text" name="username" id="username" required autofocus autocomplete="off"
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white transition-all"
                                    placeholder="Enter your username" value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="flex justify-center md:justify-between items-center mb-1.5 gap-2">
                                <label for="password"
                                    class="block text-xs font-bold uppercase text-slate-400 transition-colors">Password</label>
                                <span class="text-[10px] text-slate-400 font-medium tracking-tight">* Admin Only</span>
                            </div>
                            <div class="relative">
                                <i
                                    class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 transition-colors"></i>
                                <input type="password" name="password" id="password" required
                                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="w-[80%] bg-gradient-to-r from-slate-700 to-slate-600 hover:from-slate-600 hover:to-slate-500 text-white font-bold py-4 rounded-lg shadow-lg shadow-slate-500/20 hover:shadow-slate-500/40 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-3 group">
                                <span class="text-sm uppercase tracking-widest text-center">Sign In to Dashboard</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </button>
                            
                            <a href="{{ url('/tukar/1') }}" 
                                class="w-[20%] bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-bold py-4 rounded-lg shadow-sm transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center group" title="Halaman Tukar Kupon">
                                <i class="fas fa-qrcode text-lg group-hover:scale-110 transition-transform"></i>
                            </a>
                        </div>

                    </form>

                    <div class="mt-8 text-center border-t border-slate-100 pt-6">
                        <p class="text-xs text-slate-400">
                            Need help? Contact <a href="#" class="text-slate-600 font-bold hover:underline">IT
                                Support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- end flex wrapper --}}

</body>

</html>
