<x-mail::layout>
<x-slot:header>
    <x-mail::header :url="route('auth.login')">
        {{ config('core.mail_name') }}
    </x-mail::header>
</x-slot:header>
# Hello {{ $user->name }}

<p>
    Welcome to our website! Your login password is: <strong>{{ config('core.password_default') }}</strong>
</p>

<p>
    Please change your <a href="{{ route('first-time-pass', ['email' => $user->email, 'token' => $token]) }}">password</a> after login. Token expires in {{ config('core.password_expire_tokens') }} minutes.
</p>

<p style="margin-top: 40px;">Thanks,<br></p>
<strong>{{ config('core.mail_name') }}</strong>
<x-slot:footer>
    <x-mail::footer>
        © {{ date('Y') }} | {{ config('core.copyright') }}. @lang('All rights reserved.')
    </x-mail::footer>
</x-slot:footer>
</x-mail::layout>
