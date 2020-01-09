<!-- <html>
<head>
    <title>Mapデータ</title>
</head>
<body> -->
@extends('layouts.app')
@section('content')
    <h1>Map</h1>
    <!-- Map入力フォーム -->
    <form method="POST" action="/map"> 
    {{csrf_field()}}
     
    名称: <input type="text" name="name">
    <br>
    緯度: <input type="text" name="lat">
    経度: <input type="text" name="lng">
    <br>
    説明: <input type="text" name="description"> 
    <br>
    <input type="submit"> 
    </form> 
    <!-- 一覧表示 -->
    <table>
    <tr>
    <th>名称</th>
    <th>緯度</th>
    <th>経度</th>
    <th>説明</th>
    <th>作成日</th>
    <th>更新日</th>
    </tr>
    @foreach($list as $val)
    <tr>
        <td><a href="/show/{{$val->id}}">{{$val->name}}</a></td>
        <td>{{$val->lat}}</td>
        <td>{{$val->lng}}</td>
        <td>{{$val->description}}</td>
        <td>{{$val->created_at}}</td>
        <td>{{$val->updated_at}}</td>
    </tr>
    @endforeach
    </table>
</body>
</html>