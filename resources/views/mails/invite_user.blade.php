@component('mail::message')

    Welcome, {{ $data['user']->name }}, <br>
    Our Administrator Chose you to like our admins groups member.

    if you want to accept this invitation click on the button below
    @component('mail::button', ['url' => admin_url("password/reset/" . $data['token'] ."?email=".$data['user']->email)])
        Set Password
    @endcomponent
    This password set link will expire in 60 minutes.

    Thanks,<br>
    {{ settings("name_en") }}
@endcomponent
{{--    If you did not request a password reset, no further action is required.--}}
