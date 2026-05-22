@extends($themeMaster)

@section('title', 'Liên hệ')

@section('content')
    <h1>Liên hệ — theme: {{ $theme }}</h1>
    <p>Route <code>/contact</code> dùng theme override: <strong>{{ $theme }}</strong></p>
@endsection
