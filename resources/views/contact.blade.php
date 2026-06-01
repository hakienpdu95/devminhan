@extends($themeMaster)

@section('title', 'Liên hệ — ' . config('app.name'))
@section('meta_description', 'Liên hệ với chúng tôi.')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="mb-8 text-center">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-primary">Liên hệ</p>
            <h1 class="text-3xl font-bold lg:text-4xl">Gửi lời nhắn cho chúng tôi</h1>
            <p class="mt-3 text-base-content/70">
                Layout <strong>app</strong> + theme <span class="badge badge-primary badge-sm">{{ $theme }}</span>.
            </p>
        </div>

        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body">
                <form class="space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="form-control">
                            <span class="label-text mb-1 font-medium">Họ tên</span>
                            <input type="text" class="input input-bordered w-full" placeholder="Nguyễn Văn A">
                        </label>
                        <label class="form-control">
                            <span class="label-text mb-1 font-medium">Email</span>
                            <input type="email" class="input input-bordered w-full" placeholder="ban@email.com">
                        </label>
                    </div>

                    <label class="form-control">
                        <span class="label-text mb-1 font-medium">Chủ đề</span>
                        <select class="select select-bordered w-full">
                            <option disabled selected>Chọn chủ đề</option>
                            <option>Tư vấn</option>
                            <option>Hợp tác</option>
                            <option>Hỗ trợ kỹ thuật</option>
                        </select>
                    </label>

                    <label class="form-control">
                        <span class="label-text mb-1 font-medium">Nội dung</span>
                        <textarea class="textarea textarea-bordered min-h-32 w-full" placeholder="Nội dung lời nhắn..."></textarea>
                    </label>

                    <button type="button" class="btn btn-primary w-full">Gửi lời nhắn</button>
                </form>
            </div>
        </div>
    </div>
@endsection
