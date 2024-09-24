@extends('layout.blade.php')
<!DOCTYPE html>
<html>
<head>
    <title>Pippo</title>
</head>
@section('content')
<body>
    <h1>Ecco Pippo!</h1>
    <img src="{{ $pippoImageUrl }}" alt="Pippo">
</body>
@endsection

</html>
