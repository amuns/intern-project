<x-app-layout>
    @include('layouts.header')
    <div class="login-wrapper relative">
        <div class="card">
            <form method="POST" action="{{ route('login') }}" class="w-[400px] mx-auto p-6">
                <h2 class="text-2xl font-semibold text-center mb-5">
                    Login to your account
                </h2>
                <p class="text-center text-gray-500 mb-6">
                    or
                    <a href="{{ route('register') }}" class="ptitle">
                        create new account
                    </a>
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @csrf
                <div class="mb-4 mt-4">
                    <x-input type="email" name="email" placeholder="Your email address" :value="old('email')" />
                </div>
                <div class="mb-4">
                    <x-input type="password" name="password" placeholder="Your password" :value="old('password')" />
                </div>
                <div class="flex justify-between items-center mb-5">
                    <div class="flex items-center">
                        <input id="loginRememberMe" type="checkbox"
                            class="mr-3 rounded border-gray-300 text-purple-500" />
                        <label for="loginRememberMe">Remember Me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="ptitle">
                            Forgot Password?
                        </a>
                    @endif
                </div>
                <button class="primary-button w-full">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-app-layout>

@include('layouts.footer')
