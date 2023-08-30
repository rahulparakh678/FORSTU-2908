<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your mobile number by entering the verification code sent to you?') }}
        </div>

        <form method="POST" action="{{ route('mobile.verification.verify') }}">
            @csrf
            <div>
                <label for="code" class="block font-medium text-sm text-gray-700">Verification Code</label>
                <input type="text" name="code" id="code" class="form-input mt-1 block w-full" autofocus />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="btn btn-primary">
                    {{ __('Verify') }}
                </button>
            </div>
        </form>

        @if (session('resent'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A fresh verification code has been sent to your mobile number.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('mobile.verification.resend') }}">
            @csrf
            <div class="mt-4 flex items-center justify-end">
                <button type="submit" class="font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('Resend Verification Code') }}
                </button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
