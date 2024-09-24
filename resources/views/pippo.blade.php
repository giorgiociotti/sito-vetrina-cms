@extends('layouts.base')
<!DOCTYPE html>
<html>
<head>
    <title>Pippo</title> 
</head>
<body>

@section('content')
    <h1>Ecco Pippo!</h1>
    <img src="{{ $pippoImageUrl }}" alt="Pippo">.
@endsection

</body>
</html>
