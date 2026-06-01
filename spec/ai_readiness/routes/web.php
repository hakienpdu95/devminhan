<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AI Readiness — routes
|--------------------------------------------------------------------------
| Thêm các route dưới đây vào routes/web.php của bạn.
*/

// Trang khảo sát
Route::get('/ai-readiness', fn () => view('ai-readiness'))->name('ai-readiness');

// (Tuỳ chọn) Nhận dữ liệu khảo sát khi người dùng bấm "Xem báo cáo"
// Bật phần này nếu bạn muốn lưu kết quả về DB. Xem README để biết cách
// gọi fetch() trong hàm submit() của Alpine.
Route::post('/api/ai-readiness', function (Request $request) {
    $data = $request->validate([
        'answers'  => 'required|array',
        'scores'   => 'required|array',
        'overall'  => 'required|integer',
        'level'    => 'required|string',
    ]);

    // TODO: lưu $data vào model, ví dụ:
    // \App\Models\AiReadinessSubmission::create([
    //     'payload' => $data['answers'],
    //     'scores'  => $data['scores'],
    //     'overall' => $data['overall'],
    //     'level'   => $data['level'],
    // ]);

    return response()->json(['ok' => true]);
})->name('ai-readiness.store');
