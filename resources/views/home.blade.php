@extends($themeMaster)

@section('title', 'Trang chủ')

@section('content')
    <h1>Trang chủ — theme: {{ $theme }}</h1>
    <p>Route <code>/</code> dùng theme mặc định: <strong>{{ $theme }}</strong></p>
@endsection
