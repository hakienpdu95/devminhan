@extends($themeMaster)

@section('title', 'Blog — ' . config('app.name'))
@section('meta_description', 'Bài viết, kiến thức và cập nhật mới nhất.')

@section('content')
    {{-- Page header --}}
    <div class="mb-10">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-primary">Blog</p>
        <h1 class="text-3xl font-bold lg:text-4xl">Bài viết mới nhất</h1>
        <p class="mt-3 max-w-2xl text-base-content/70">
            Trang <code class="rounded bg-base-200 px-1.5 py-0.5 text-sm">/blog</code> đang render với
            layout <strong>app</strong> + theme <span class="badge badge-primary badge-sm">{{ $theme }}</span>.
        </p>
    </div>

    {{-- Card grid — pure DaisyUI, themed by tokens --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (range(1, 6) as $i)
            <article class="card bg-base-100 shadow-sm border border-base-300 transition hover:shadow-md">
                <figure class="aspect-video bg-gradient-to-br from-primary/20 to-secondary/20"></figure>
                <div class="card-body">
                    <div class="flex items-center gap-2 text-xs text-base-content/60">
                        <span class="badge badge-ghost badge-sm">Chuyên mục</span>
                        <span>· 5 phút đọc</span>
                    </div>
                    <h2 class="card-title text-lg">Tiêu đề bài viết số {{ $i }}</h2>
                    <p class="text-sm text-base-content/70">
                        Đoạn mô tả ngắn cho bài viết, tự động đổi màu theo theme đang chọn.
                    </p>
                    <div class="card-actions mt-2 justify-end">
                        <a href="#" class="btn btn-primary btn-sm">Đọc tiếp</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection
