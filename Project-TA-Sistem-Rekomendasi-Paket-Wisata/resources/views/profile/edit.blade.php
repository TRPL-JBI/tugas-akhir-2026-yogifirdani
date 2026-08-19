@extends('template')

@section('content')
<div class="min-h-screen relative flex items-center justify-center py-8 px-4 font-outfit overflow-hidden pt-24 bg-[#f8f9fa]">
    <div class="container mx-auto max-w-4xl relative z-10">
        
        <!-- Alerts -->
        @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/50 text-red-500 px-6 py-4 rounded-2xl mb-6 shadow-xl animate-fadeIn">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Main Card - Smaller & Compact Light Mode -->
        <div class="bg-white border border-gray-150 shadow-xl rounded-[2rem] overflow-hidden flex flex-col md:flex-row mx-auto w-full">
            
            <!-- Left Sidebar - Clean Light Background -->
            <aside class="w-full md:w-64 bg-gray-50 border-r border-gray-150 p-6 flex flex-col items-center">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-tr from-[#57c9d1] to-[#3ca7af] rounded-2xl flex items-center justify-center text-white text-4xl font-bold shadow-xl transform rotate-2 hover:rotate-0 transition-all duration-500">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                
                <h2 class="text-lg font-bold text-gray-800 mb-0.5 text-center px-2">{{ $user->name }}</h2>
                <p class="text-gray-400 text-[10px] mb-6 uppercase tracking-widest">{{ __('messages.profile_premium_member') }}</p>

                <nav class="w-full space-y-2">
                    <a href="{{ lroute('profile') }}" class="w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 text-gray-600 hover:bg-gray-100 hover:text-[#57c9d1] border border-transparent hover:border-gray-200">
                        <i class="fa fa-arrow-left text-lg"></i>
                        <span class="text-xs font-semibold">{{ __('messages.profile_back_to_profile') }}</span>
                    </a>
                </nav>
            </aside>

            <!-- Right Content Area - More Compact -->
            <main class="flex-1 p-5 md:p-8 relative bg-white">
                
                @if (session('success'))
                <div id="success-alert" class="absolute top-6 right-6 md:top-10 md:right-10 bg-green-500/20 border border-green-500/50 text-green-500 px-4 py-2 rounded-xl shadow-xl animate-fadeIn transition-all duration-500 z-50 flex items-center gap-2">
                    <i class="ion-ios-checkmark-circle text-lg"></i>
                    <span class="text-xs font-bold">{{ session('success') }}</span>
                </div>
                @endif

                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                        <span class="w-1 h-6 bg-[#57c9d1] rounded-full shadow-[0_0_10px_#57c9d1]"></span>
                        {{ __('messages.profile_edit_account_info') }}
                    </h3>
                </div>

                <form action="{{ lroute('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_username_label') }}</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-[#57c9d1]/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                        </div>

                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_phone_label') }}</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="{{ __('messages.phone_placeholder') }}"
                                class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-[#57c9d1]/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                        </div>
                    </div>

                    <div class="group">
                        <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_email_label') }}</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-[#57c9d1]/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="text-white text-sm font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 inline-block" style="background-color: rgb(87, 201, 209); box-shadow: 0 4px 15px rgba(87, 201, 209, 0.3);">
                            {{ __('messages.profile_save_changes') }}
                        </button>
                    </div>
                </form>

                <div class="mt-10 mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                        <span class="w-1 h-6 bg-yellow-400 rounded-full shadow-[0_0_10px_#facc15]"></span>
                        {{ __('messages.profile_change_password_title') }}
                    </h3>
                </div>

                <form action="{{ lroute('profile.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="group">
                        <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_current_password') }}</label>
                        <input type="password" name="current_password" required placeholder="{{ __('messages.current_password_placeholder') }}"
                            class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-yellow-400/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_new_password') }}</label>
                            <input type="password" name="password" required placeholder="{{ __('messages.new_password_placeholder') }}"
                                class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-yellow-400/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                        </div>

                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_confirm_password') }}</label>
                            <input type="password" name="password_confirmation" required placeholder="{{ __('messages.confirm_password_placeholder') }}"
                                class="w-full bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium focus:outline-none focus:border-yellow-400/40 focus:bg-white transition-colors shadow-inner placeholder-gray-400">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-gray-100 hover:bg-yellow-50 text-gray-700 hover:text-yellow-600 border border-gray-200 hover:border-yellow-400 text-sm font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 inline-block">
                            {{ __('messages.profile_update_password_btn') }}
                        </button>
                    </div>
                </form>

            </main>
        </div>
        
        <!-- Footer Info -->
        <p class="text-center text-gray-300 text-[10px] mt-6 tracking-wide">
            {{ __('messages.profile_footer') }}
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    });
</script>

@push('styles')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    .backdrop-blur-md {
        -webkit-backdrop-filter: blur(8px);
    }
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Ubah warna teks navbar menjadi hitam di halaman ini agar terlihat di background putih */
    #ftco-navbar:not(.scrolled) .nav-link,
    #ftco-navbar:not(.scrolled) .dropdown-item {
        color: #222222 !important;
    }
    #ftco-navbar .nav-item.active .nav-link,
    #ftco-navbar .nav-link:hover {
        color: rgb(87, 201, 209) !important;
    }
    #ftco-navbar .nav-link i {
        color: inherit !important;
    }
    #ftco-navbar:not(.scrolled) .navbar-toggler {
        color: #222222 !important;
    }
</style>
@endpush
@endsection
