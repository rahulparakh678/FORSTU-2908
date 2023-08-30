<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('resent'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-medium text-red-600 hover:text-red-500">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
