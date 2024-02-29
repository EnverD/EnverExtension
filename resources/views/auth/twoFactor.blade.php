<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('verify.store') }}">
        @csrf
        <a href="/" class="login-title">
            <h1>H8.DK</h1>
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>

        <div class="mb-4 text-sm text-gray-600">
            {{ new Illuminate\Support\HtmlString(__("Received an email with a login code? If not, click <a class=\"hover:underline\" href=\":url\">here</a>.", ['url' => route('verify.resend')])) }}
        </div>

        <div>
            <x-input-label for="two_factor_code" :value="__('Code')" />
            <x-text-input id="two_factor_code" class="block mt-1 w-full" type="text" name="two_factor_code" required autofocus />
            <x-input-error :messages="$errors->get('two_factor_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>