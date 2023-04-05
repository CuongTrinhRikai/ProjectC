<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table aria-describedby="transaltion export">
    <thead>
    <tr>
        <th scope="col"><strong>Key</strong></th>
        @foreach($languages as $language)
        <th scope="col"><strong>{{$language->language_code}}</strong></th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($translations as $tran)
        <tr>
            <td>{{ $tran['key'] }}</td>
            @foreach($languages as $language)
            <td>{{$tran->text[$language->language_code] ?? $tran->text['en']}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
