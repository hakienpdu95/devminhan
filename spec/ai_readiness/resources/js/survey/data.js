/* ===========================================================
   THUCHOCVN · AI Readiness — survey content (data-driven)
   Option format: [label, domain, score]   domain ∈ workflow|sales|hr|data|ai
   Questions with no scoring just omit domain/score.
   =========================================================== */
export const SURVEY = [
  {
    key: "company", icon: "building", title: "Thông tin doanh nghiệp",
    desc: "Vài thông tin nền để cá nhân hoá báo cáo cho bạn.",
    cheer: "Chỉ 1 phút — rồi mình vào phần thú vị ngay 👇",
    qs: [
      { t: "text", q: "Tên doanh nghiệp", req: true, ph: "Nhập tên doanh nghiệp" },
      { t: "select", q: "Ngành nghề", req: true, ph: "Chọn ngành nghề",
        opts: ["Nông nghiệp / Thực phẩm", "Bán lẻ / TMĐT", "Dịch vụ", "Sản xuất", "Giáo dục / Đào tạo", "Bảo hiểm / Tài chính", "Khác"] },
      { t: "select", q: "Số năm hoạt động", ph: "Chọn số năm",
        opts: ["Dưới 1 năm", "1 - 3 năm", "3 - 5 năm", "Trên 5 năm"] },
      { t: "single", q: "Quy mô nhân sự hiện tại", req: true, cols: 4,
        opts: [["Dưới 10"], ["10 - 50"], ["51 - 200"], ["Trên 200"]] },
      { t: "select", q: "Quy mô doanh thu", ph: "Chọn khoảng doanh thu",
        opts: ["Dưới 1 tỷ/năm", "1 - 5 tỷ/năm", "5 - 20 tỷ/năm", "Trên 20 tỷ/năm"] },
      { t: "single", q: "Mô hình vận hành", cols: 3, opts: [["Offline"], ["Online"], ["Kết hợp"]] },
      { t: "grid2", qs: [
        { t: "text", q: "Người phụ trách khảo sát", req: true, ph: "Họ và tên" },
        { t: "text", q: "Chức vụ", ph: "Nhập chức vụ" },
        { t: "text", q: "Số điện thoại", req: true, ph: "Nhập số điện thoại" },
        { t: "text", q: "Email", req: true, ph: "Nhập email" }
      ] }
    ]
  },
  {
    key: "workflow", icon: "workflow", title: "Workflow & Vận hành",
    desc: "Quy trình và hệ thống vận hành hiện tại của bạn.",
    cheer: "Mỗi lựa chọn sẽ cập nhật điểm AI Readiness ngay lập tức ⚡",
    qs: [
      { t: "single", q: "Doanh nghiệp đang vận hành theo?", cols: 4, opts: [
        ["Quy trình chuẩn", "workflow", 18], ["Theo kinh nghiệm", "workflow", 8],
        ["Theo chỉ đạo trực tiếp", "workflow", 0], ["Chưa rõ quy trình", "workflow", -15] ] },
      { t: "multi", q: "Phòng ban hiện có", cols: 3, opts: [
        ["Sales"], ["Marketing"], ["CSKH"], ["Kế toán"], ["Nhân sự"], ["Kho vận"], ["Sản xuất"], ["IT"], ["Khác"] ] },
      { t: "multi", q: "Công cụ quản lý hiện tại", cols: 4, opts: [
        ["Excel", "workflow", -5], ["Google Sheet", "workflow", -2], ["Zalo", "workflow", -8], ["Sổ sách giấy", "workflow", -10],
        ["CRM", "workflow", 12], ["ERP", "workflow", 15], ["Phần mềm nội bộ", "workflow", 10] ] },
      { t: "multi", q: "Vấn đề lớn nhất hiện tại", cols: 4, opts: [
        ["Nhân sự quên việc", "workflow", -14], ["Khó kiểm soát tiến độ", "workflow", -15], ["Dữ liệu phân tán", "data", -12],
        ["Khó đào tạo nhân sự", "hr", -10], ["Sai sót lặp lại", "workflow", -12], ["Sales không follow", "sales", -12],
        ["CEO khó kiểm soát", "workflow", -15], ["Không có SOP", "workflow", -15] ] },
      { t: "grid2", qs: [
        { t: "textarea", q: "Công đoạn mất nhiều thời gian nhất", ph: "Mô tả chi tiết..." },
        { t: "textarea", q: "Bộ phận thường xảy ra lỗi nhất", ph: "Mô tả chi tiết..." } ] },
      { t: "single", q: "Ảnh hưởng khi nhân sự nghỉ việc", cols: 4, opts: [
        ["Rất lớn", "hr", -18], ["Trung bình", "hr", -8], ["Ít", "hr", 4], ["Không đáng kể", "hr", 10] ] },
      { t: "toggle", q: "Hiện đã có sẵn hệ thống / tài liệu nào? (tick nếu CÓ)", cols: 4, opts: [
        ["SOP", "workflow", 15], ["KPI", "hr", 15], ["Workflow", "workflow", 15], ["Dashboard", "workflow", 12],
        ["CRM", "sales", 20], ["ERP", "data", 15], ["Phân quyền", "data", 15], ["Phê duyệt", "workflow", 8] ] }
    ]
  },
  {
    key: "sales", icon: "sales", title: "Sales & Khách hàng",
    desc: "Hệ thống bán hàng và quản lý khách hàng.",
    cheer: "Đây là nơi AI thường tạo ROI nhanh nhất 🚀",
    qs: [
      { t: "multi", q: "Nguồn khách hàng hiện tại", cols: 4, opts: [
        ["Facebook"], ["TikTok"], ["Website"], ["Sale thị trường"], ["Giới thiệu"], ["Đại lý"], ["Sàn TMĐT"], ["Khác"] ] },
      { t: "multi", q: "Lead hiện quản lý bằng gì?", cols: 5, opts: [
        ["Excel", "sales", -8], ["Google Sheet", "sales", -4], ["CRM", "sales", 18], ["Zalo", "sales", -6], ["Không quản lý", "sales", -18] ] },
      { t: "multi", q: "Tình trạng đang gặp phải", cols: 3, opts: [
        ["Mất khách hàng", "sales", -18], ["Không nhớ follow", "sales", -15], ["Không biết sale nào chăm khách", "sales", -12],
        ["Không đo hiệu quả sale", "sales", -12], ["Sale nghỉ mất data", "sales", -12], ["Không có lịch sử khách hàng", "sales", -8] ] },
      { t: "grid2", qs: [
        { t: "textarea", q: "Quy trình sale hiện tại", ph: "Mô tả các bước trong quy trình sale..." },
        { t: "select", q: "Bao nhiêu % lead bị bỏ quên?", ph: "Chọn tỷ lệ", opts: ["Dưới 10%", "10 - 30%", "30 - 50%", "Trên 50%"] } ] },
      { t: "toggle", q: "CEO có xem realtime các thông tin này không? (tick nếu CÓ)", cols: 5, opts: [
        ["Lead", "sales", 8], ["Doanh thu", "sales", 8], ["Tỷ lệ chốt", "sales", 10], ["KPI sale", "sales", 10], ["Hiệu suất", "sales", 8] ] },
      { t: "single", q: "Đang dùng CRM chưa?", cols: 2, opts: [["Có", "sales", 18], ["Không", "sales", -12]] },
      { t: "text", q: "Nếu có, đang dùng CRM nào?", ph: "Tên phần mềm CRM" }
    ]
  },
  {
    key: "hr", icon: "hr", title: "Nhân sự & Đào tạo",
    desc: "Quản trị nhân sự, đào tạo và KPI.",
    cheer: "Sắp xong nửa chặng rồi — tuyệt vời! 💪",
    qs: [
      { t: "single", q: "Có checklist onboarding cho nhân sự mới không?", cols: 3, opts: [
        ["Có đầy đủ", "hr", 15], ["Có nhưng chưa chuẩn", "hr", 5], ["Chưa có", "hr", -15] ] },
      { t: "multi", q: "Hệ thống KPI / phân công công việc?", cols: 4, opts: [
        ["Có KPI", "hr", 15], ["Có task management", "hr", 10], ["Có đánh giá định kỳ", "hr", 10], ["Chưa rõ trách nhiệm", "hr", -12] ] },
      { t: "multi", q: "Vấn đề nhân sự đang gặp", cols: 3, opts: [
        ["Nhân sự mới khó bắt việc", "hr", -15], ["Phụ thuộc người cũ", "hr", -18], ["Không có tài liệu đào tạo", "hr", -12],
        ["Đào tạo thủ công", "hr", -10], ["Không đo năng suất", "hr", -10], ["Việc chồng chéo", "workflow", -8] ] },
      { t: "textarea", q: "Mô tả thêm về vấn đề nhân sự / đào tạo", ph: "Nhập nội dung..." }
    ]
  },
  {
    key: "data", icon: "data", title: "Dữ liệu & Hệ thống",
    desc: "Cấu trúc dữ liệu, hệ thống và mức độ số hoá.",
    cheer: "Dữ liệu sạch = nền móng để AI hoạt động hiệu quả 🧱",
    qs: [
      { t: "multi", q: "Dữ liệu hiện đang lưu ở đâu?", cols: 4, opts: [
        ["Excel / Google Sheet", "data", -4], ["Google Drive", "data", 10], ["Máy tính cá nhân", "data", -8], ["Server nội bộ", "data", 15],
        ["Cloud", "data", 15], ["Phần mềm quản lý", "data", 12], ["Zalo / Chat", "data", -8], ["Giấy tờ", "data", -12] ] },
      { t: "multi", q: "Các vấn đề dữ liệu đang gặp", cols: 3, opts: [
        ["Dữ liệu trùng lặp", "data", -15], ["Mất dữ liệu", "data", -20], ["Không đồng bộ", "data", -15],
        ["Sai dữ liệu", "data", -12], ["Khó tìm kiếm", "data", -10], ["Không backup", "data", -12] ] },
      { t: "grid2", qs: [
        { t: "single", q: "Dữ liệu khách hàng có tập trung không?", cols: 1, opts: [
          ["Có, tập trung hoàn toàn", "data", 20], ["Có, nhưng chưa hoàn toàn", "data", 8],
          ["Không, dữ liệu phân tán", "data", -10], ["Rất phân tán, khó quản lý", "data", -18] ] },
        { t: "single", q: "Có phân quyền truy cập dữ liệu không?", cols: 1, opts: [
          ["Có, đầy đủ", "data", 15], ["Có, nhưng chưa rõ ràng", "data", 5], ["Không", "data", -12] ] } ] },
      { t: "single", q: "Có báo cáo realtime không?", cols: 3, opts: [
        ["Có, đầy đủ", "data", 15], ["Có, nhưng chưa realtime", "data", 5], ["Không", "data", -10] ] },
      { t: "multi", q: "Công nghệ / dịch vụ đang dùng", cols: 6, opts: [
        ["API", "data", 8], ["Automation", "workflow", 8], ["AI", "ai", 8], ["OCR", "data", 8], ["Chatbot", "ai", 8], ["Workflow", "workflow", 10] ] },
      { t: "rating", q: "Hệ thống hiện đáp ứng nhu cầu ở mức độ nào?", def: 2, opts: [
        ["Rất kém", "data", -15], ["Kém", "data", -8], ["Trung bình", "data", 0], ["Tốt", "data", 8], ["Rất tốt", "data", 15] ] }
    ]
  },
  {
    key: "ai", icon: "ai", title: "AI Readiness",
    desc: "Mức độ sẵn sàng và nhu cầu ứng dụng AI.",
    cheer: "Phần quan trọng nhất — quyết định lộ trình AI của bạn 🤖",
    qs: [
      { t: "multi", q: "Đã từng sử dụng AI ở công cụ nào?", cols: 4, opts: [
        ["ChatGPT", "ai", 8], ["Gemini", "ai", 8], ["Microsoft Copilot", "ai", 8], ["AI Chatbot", "ai", 8],
        ["AI viết nội dung", "ai", 8], ["AI phân tích dữ liệu", "ai", 8], ["AI tạo hình ảnh", "ai", 8], ["Chưa từng dùng AI", "ai", -10] ] },
      { t: "single", q: "Mức độ hiểu biết AI của đội ngũ", cols: 5, opts: [
        ["Chưa biết gì về AI", "ai", -12], ["Biết cơ bản", "ai", 0], ["Đã thử sử dụng", "ai", 8],
        ["Đã dùng vào công việc", "ai", 15], ["Sử dụng thành thạo", "ai", 20] ] },
      { t: "multi", q: "Muốn AI hỗ trợ ở đâu nhất?", cols: 4, opts: [
        ["Sales & Marketing", "ai", 8], ["Đào tạo nội bộ", "ai", 8], ["CSKH", "ai", 8], ["Tự động hóa quy trình", "ai", 8],
        ["Nhập liệu & xử lý dữ liệu", "ai", 8], ["CEO Dashboard", "ai", 8], ["Báo cáo & phân tích", "ai", 8], ["Sản xuất / Vận hành", "ai", 8] ] },
      { t: "multi", q: "Điều lo ngại nhất khi ứng dụng AI?", cols: 3, opts: [
        ["Chi phí cao", "ai", -8], ["Không biết bắt đầu từ đâu", "ai", -12], ["Nhân sự không biết dùng", "ai", -10],
        ["Mất dữ liệu", "data", -10], ["Không hiệu quả", "ai", -8], ["Không phù hợp thực tế", "workflow", -8] ] },
      { t: "single", q: "Sẵn sàng chuyển đổi ở mức nào?", cols: 4, opts: [
        ["Chỉ muốn tìm hiểu", "ai", -5], ["Muốn thử nghiệm nhỏ", "ai", 8], ["Triển khai từng phần", "ai", 15], ["Triển khai toàn diện", "ai", 22] ] },
      { t: "textarea", q: "Mục tiêu kỳ vọng khi ứng dụng AI", ph: "Nhập nội dung..." }
    ]
  },
  {
    key: "overview", icon: "review", title: "Đánh giá tổng quan",
    desc: "Mức độ trưởng thành số và mức sẵn sàng chuyển đổi.",
    cheer: "Gần tới báo cáo của bạn rồi — cố thêm chút nữa! 🏁",
    qs: [
      { t: "rating", q: "Mức độ số hoá hiện tại", def: 2, opts: [
        ["Rất thấp", "workflow", -15], ["Thấp", "workflow", -8], ["Trung bình", "workflow", 0], ["Tốt", "workflow", 8], ["Rất cao", "workflow", 15] ] },
      { t: "grid2", qs: [
        { t: "single", q: "Sẵn sàng chuyển đổi số ở mức nào?", cols: 1, opts: [
          ["Chỉ muốn tìm hiểu", "workflow", -5], ["Muốn thử nghiệm nhỏ", "workflow", 5],
          ["Triển khai từng phần", "workflow", 12], ["Triển khai toàn diện", "workflow", 20] ] },
        { t: "single", q: "Ngân sách chuyển đổi số / AI?", cols: 1, opts: [
          ["Chưa có ngân sách", "ai", -5], ["Dưới 50 triệu/năm", "ai", 4], ["50 - 200 triệu/năm", "ai", 10],
          ["200 - 500 triệu/năm", "ai", 16], ["Trên 500 triệu/năm", "ai", 22] ] } ] },
      { t: "multi", q: "Kỳ vọng khi triển khai AI & tự động hoá", cols: 4, opts: [
        ["Tăng hiệu suất"], ["Giảm chi phí"], ["Giảm sai sót"], ["Tăng doanh thu"], ["Tăng trải nghiệm KH"], ["Dữ liệu realtime"], ["Chuẩn hóa quy trình"] ] },
      { t: "multi", q: "Muốn THUCHOCVN hỗ trợ điều gì nhất?", cols: 3, opts: [
        ["Khảo sát & đánh giá tổng thể"], ["Xây dựng SOP / Workflow"], ["Tư vấn & triển khai AI"],
        ["Đào tạo nhân sự dùng AI"], ["Xây dựng hệ thống dữ liệu"], ["Dashboard báo cáo"] ] }
    ]
  },
  {
    key: "extra", icon: "info", title: "Thông tin bổ sung",
    desc: "Giúp THUCHOCVN tư vấn chính xác hơn.",
    cheer: "Câu cuối rồi — sau đó là kết quả của bạn ✨",
    qs: [
      { t: "grid2", qs: [
        { t: "single", q: "Đã từng làm việc với đơn vị tư vấn / chuyển đổi số?", cols: 1, opts: [["Chưa từng"], ["Đã từng"], ["Đang làm"]] },
        { t: "emoji", q: "Mức độ hài lòng với kết quả đó?", opts: [
          ["😡", "Rất không"], ["🙁", "Không"], ["😐", "Bình thường"], ["🙂", "Hài lòng"], ["😍", "Rất hài lòng"] ] } ] },
      { t: "textarea", q: "Yêu cầu hoặc mong muốn đặc biệt", ph: "Nhập nội dung..." },
      { t: "grid2", qs: [
        { t: "select", q: "Kênh biết đến THUCHOCVN?", ph: "Chọn kênh", opts: ["Facebook", "Website", "Giới thiệu", "Sự kiện", "Đối tác"] },
        { t: "single", q: "Đồng ý để THUCHOCVN liên hệ tư vấn?", cols: 2, def: 0, opts: [["Có"], ["Không"]] } ] }
    ]
  },
  {
    key: "submit", icon: "send", title: "Xác nhận & Gửi",
    desc: "Kiểm tra lại trước khi xem kết quả.",
    cheer: "",
    summary: true, qs: []
  }
];

/* Domain weights for the overall score */
export const SURVEY_WEIGHTS = { workflow: 0.25, sales: 0.20, hr: 0.15, data: 0.20, ai: 0.20 };
export const DOMAIN_LABELS = { workflow: "Workflow", sales: "Sales", hr: "Nhân sự", data: "Dữ liệu", ai: "AI Readiness" };
