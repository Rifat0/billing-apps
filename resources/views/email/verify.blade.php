<x-mail::message>
    <h2>Hello {{$user->name}},</h2>

    Thank you for creating an account with us. Don't forget to verify your email address.

    
    <x-mail::button :url="route('users.emailVerify', $user->verification_token)">
        Verify Account
    </x-mail::button>

    Thank you
    Regards,
    Team {{ config('app.name') }}
</x-mail::message>

<x-mail::panel>
    Here are your account details:  
    Name: {{$user->name}}
    Email: {{$user->email}}
</x-mail::panel>