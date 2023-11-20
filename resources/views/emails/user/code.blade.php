@component('mail::message')
    @component('mail::panel')
        {{ $user->name }} {{ $user->surname }} <br>
        <br>Ваш код:{{$maildata['code']}}
    @endcomponent
@endcomponent

