@component('mail::message')
    <h2>Hey, It's me {{ $data->first_name }}</h2>


    User details:
    First Name: {{ $data->first_name }}
    Last Name: {{ $data->last_name }}
    Email: {{ $data->email }}
    Company: {{ $data->company }}
    Phone Nr: {{ $data->phone_nr }}
    Message: {{ $data->message }}
    Thank you
    {{ config('app.name') }}
@endcomponent
