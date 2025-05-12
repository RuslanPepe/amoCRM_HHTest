<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>amoCRM</title>
</head>
<body>
<div class="container">
{{--  @foreach($leads['leads'] as $lead)--}}
{{--    <div class="item">--}}
{{--      <p class="id">{{ 'Id: '.$lead['id'] }}</p>--}}
{{--      <p class="name">{{ 'Название: '.$lead['name'] }}</p>--}}
{{--      <label for="{{ $lead['id'] }}"><input class="inputNotes" type="text" name="notes" id="{{ $lead['id'] }}"></label>--}}
{{--      <button type="submit">Сохранить примечание</button>--}}
{{--    </div>--}}
{{--  @endforeach--}}

{{--  @foreach($leads['leads'][0] as $key=>$lead)--}}
{{--    {{ $key }}--}}
{{--    {{ var_dump($lead) }}--}}
{{--    <br>--}}
{{--  @endforeach--}}

{{--  {{ var_dump($leads['leads'][2]['_embedded']) }}--}}
{{--  {{ var_dump($leads['leads'][1]['_embedded']) }}--}}
</div>
</body>
</html>
