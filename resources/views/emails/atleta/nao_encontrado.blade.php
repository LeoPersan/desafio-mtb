@component('mail::message')
# Atleta não encontrado

Dados do Strava

@component('mail::table')
|   |   |
|---|---|
|refresh_token:|**{{$refresh_token}}**|
|access_token:|**{{$access_token}}**|
|id:|**{{$athlete->id}}**|
|username:|**{{$athlete->username}}**|
|resource_state:|**{{$athlete->resource_state}}**|
|firstname:|**{{$athlete->firstname}}**|
|lastname:|**{{$athlete->lastname}}**|
|city:|**{{$athlete->city}}**|
|state:|**{{$athlete->state}}**|
|country:|**{{$athlete->country}}**|
|sex:|**{{$athlete->sex}}**|
|premium:|**{{$athlete->premium}}**|
|summit:|**{{$athlete->summit}}**|
|created_at:|**{{$athlete->created_at}}**|
|updated_at:|**{{$athlete->updated_at}}**|
|badge_type_id:|**{{$athlete->badge_type_id}}**|
|profile_medium:|**{{$athlete->profile_medium}}**|
|profile:|**{{$athlete->profile}}**|
|friend:|**{{$athlete->friend}}**|
|follower:|**{{$athlete->follower}}**|
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
