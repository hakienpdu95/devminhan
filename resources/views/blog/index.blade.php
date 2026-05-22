@extends($themeMaster)

@section('title', 'Blog')

@section('content')
    <h1>Blog — theme: {{ $theme }}</h1>
    <p>Route <code>/blog</code> dùng theme override: <strong>{{ $theme }}</strong></p>
@endsection
