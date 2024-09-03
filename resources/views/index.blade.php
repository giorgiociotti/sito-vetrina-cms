@extends('layouts.app')

@section('content')
    <h1>Pagine</h1>
    <a href="{{ route('pages.create') }}">Crea Nuova Pagina</a>
    <ul>
        @foreach($pages as $page)
            <li>{{ $page->title }} - <a href="{{ route('pages.edit', $page->id) }}">Modifica</a> - 
                <form action="{{ route('pages.destroy', $page->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Elimina</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
