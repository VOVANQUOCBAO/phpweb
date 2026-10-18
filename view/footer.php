<!-- ========================================================
     CHÂN TRANG (FOOTER) - CHUẨN THẾ GIỚI DI ĐỘNG & SAMSUNG
     ======================================================== -->
<footer class="bg-white border-top mt-auto pt-5 pb-3">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Cột 1: Thông tin tổng đài -->
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="fw-bold text-uppercase text-primary mb-3">Tổng đài hỗ trợ (Miễn phí)</h6>
                <ul class="list-unstyled small text-secondary lh-lg mb-0">
                    <li>Gọi mua hàng: <strong class="text-dark">1800.1060</strong> (7:30 - 22:00)</li>
                    <li>Kỹ thuật & CSKH: <strong class="text-dark">1800.1763</strong> (7:30 - 22:00)</li>
                    <li>Khiếu nại: <strong class="text-dark">1800.1062</strong> (8:00 - 21:30)</li>
                    <li>Bảo hành chính hãng: <strong class="text-dark">1800.1064</strong></li>
                </ul>
                <div class="mt-3">
                    <span class="badge bg-primary me-1"><i class="fab fa-facebook-f"></i></span>
                    <span class="badge bg-danger me-1"><i class="fab fa-youtube"></i></span>
                    <span class="badge bg-info me-1"><i class="fab fa-twitter"></i></span>
                    <span class="badge bg-dark"><i class="fab fa-tiktok"></i></span>
                </div>
            </div>

            <!-- Cột 2: Hệ thống cửa hàng & chính sách -->
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="fw-bold text-uppercase text-primary mb-3">Về ĐiệnThoạiZ</h6>
                <ul class="list-unstyled small text-secondary lh-lg mb-0">
                    <li><a href="#" class="text-decoration-none text-muted">Giới thiệu công ty</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Hệ thống 3.000+ siêu thị toàn quốc</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Chính sách bảo hành đổi mới 12 tháng</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Chính sách giao hàng siêu tốc 1 giờ</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Tuyển dụng mới nhất</a></li>
                </ul>
            </div>

            <!-- Cột 3: Hỗ trợ khách hàng -->
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="fw-bold text-uppercase text-primary mb-3">Hỗ trợ khách hàng</h6>
                <ul class="list-unstyled small text-secondary lh-lg mb-0">
                    <li><a href="index.php?act=theodoidonhang" class="text-decoration-none text-muted">Tra cứu tiến trình đơn hàng</a></li>
                    <li><a href="index.php?act=lichsumuahang" class="text-decoration-none text-muted">Chính sách hủy đơn & hoàn tiền</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Hướng dẫn mua trả góp 0% lãi suất</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Chính sách bảo vệ thông tin cá nhân</a></li>
                    <li><a href="#" class="text-decoration-none text-muted">Hóa đơn điện tử</a></li>
                </ul>
            </div>

            <!-- Cột 4: Phương thức thanh toán & chứng nhận -->
            <div class="col-12 col-md-6 col-lg-3">
                <h6 class="fw-bold text-uppercase text-primary mb-3">Thanh toán & Chứng nhận</h6>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-light text-dark border p-2"><i class="fab fa-cc-visa text-primary fs-5"></i> Visa</span>
                    <span class="badge bg-light text-dark border p-2"><i class="fab fa-cc-mastercard text-danger fs-5"></i> Master</span>
                    <span class="badge bg-light text-dark border p-2"><i class="fas fa-qrcode text-success fs-5"></i> VietQR</span>
                    <span class="badge bg-light text-dark border p-2"><i class="fas fa-money-bill-wave text-warning fs-5"></i> COD</span>
                </div>
                <div class="small text-muted">
                    <p class="mb-1"><i class="fas fa-shield-alt text-success me-1"></i> 100% Sản phẩm chính hãng</p>
                    <p class="mb-0"><i class="fas fa-award text-warning me-1"></i> Chứng nhận website TMĐT uy tín</p>
                </div>
            </div>
        </div>

        <hr class="text-muted opacity-25">

        <div class="row align-items-center small text-secondary pt-2">
            <div class="col-md-8 text-center text-md-start mb-2 mb-md-0">
                <p class="mb-0">© 2026 <strong>ĐiệnThoạiZ</strong>. Xây dựng theo kiến trúc thuần PHP (OOP + MVC) + MySQL + Vanilla JS + Bootstrap 5 (Chuẩn Lab 3 & Lab 3.1).</p>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <span class="badge bg-primary-subtle text-primary border border-primary">Version 3.1 MVC Ready</span>
            </div>
        </div>
    </div>
</footer>

<!-- ========================================================
     TOAST THÔNG BÁO GÓC PHẢI MÀN HÌNH (5 GIÂY)
     ======================================================== -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1065;">
    <div id="cartToast" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="d-flex align-items-center p-2">
            <div class="fs-3 me-2 ps-2 text-white">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toast-body fw-semibold py-2">
                <span id="toastMessage">Đã thêm sản phẩm vào giỏ hàng!</span>
                <div class="small opacity-75 mt-1">Giỏ hàng đã được cập nhật tự động.</div>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- ========================================================
     KHUNG CHATBOX / HỎI AI TÌM KIẾM SẢN PHẨM [24/6]
     ======================================================== -->
<!-- Nút tròn mở Chatbot AI -->
<div class="ai-chat-bubble" id="aiChatBubble" title="Hỏi Trợ lý AI tư vấn điện thoại" onclick="toggleAIChatbox()">
    <i class="fas fa-robot"></i>
</div>

<!-- Hộp thoại Chatbot AI -->
<div class="ai-chatbox-window" id="aiChatWindow">
    <div class="ai-chatbox-header">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="fas fa-robot"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Trợ Lý AI ĐiệnThoạiZ</h6>
                <small class="opacity-75">Tư vấn chọn mua thông minh 24/7</small>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" onclick="toggleAIChatbox()"></button>
    </div>

    <div class="ai-chatbox-body" id="aiChatBody">
        <div class="chat-bubble-msg chat-bubble-bot">
            👋 Xin chào bạn! Mình là Trợ lý AI của <strong>ĐiệnThoạiZ</strong>. Bạn đang muốn tìm dòng điện thoại như thế nào? Cứ hỏi mình nhé!
        </div>
        <div class="d-flex flex-wrap gap-1 mt-1">
            <button class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" style="font-size: 0.75rem;" onclick="askAIQuick('iPhone 16 mới')">iPhone 16 mới</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" style="font-size: 0.75rem;" onclick="askAIQuick('Điện thoại dưới 15 triệu')">Dưới 15 triệu</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" style="font-size: 0.75rem;" onclick="askAIQuick('Samsung AI')">Samsung AI</button>
            <button class="btn btn-outline-primary btn-sm rounded-pill py-0 px-2" style="font-size: 0.75rem;" onclick="askAIQuick('Chụp ảnh đẹp')">Chụp ảnh đẹp</button>
        </div>
    </div>

    <div class="ai-chatbox-footer">
        <form onsubmit="handleAISend(event)" class="d-flex gap-2">
            <input type="text" id="aiChatInput" class="form-control form-control-sm rounded-pill" placeholder="Hỏi AI: tìm điện thoại chụp ảnh, dưới 20tr..." autocomplete="off">
            <button type="submit" class="btn btn-primary btn-sm rounded-circle" style="width: 34px; height: 34px;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<!-- ========================================================
     NHÚNG BOOTSTRAP 5 JS & SCRIPT XỬ LÝ TOAST, THEME, CHAT AI
     ======================================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Quản lý Toast giỏ hàng và sự kiện Mua hàng
document.addEventListener("DOMContentLoaded", function() {
    const toastEl = document.getElementById('cartToast');
    const toastMsgEl = document.getElementById('toastMessage');
    const badgeCountEl = document.getElementById('headerCartBadge');
    let cartToastInstance = null;
    
    if (toastEl && typeof bootstrap !== 'undefined') {
        cartToastInstance = new bootstrap.Toast(toastEl, { delay: 5000 });
    }

    // Bắt sự kiện khi click vào nút "Thêm vào giỏ"
    const addCartBtns = document.querySelectorAll('.btn-add-cart');
    addCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const productName = this.getAttribute('data-name') || 'Sản phẩm';
            const productId = this.getAttribute('data-id') || '0';
            const price = this.getAttribute('data-price') || '0';
            const img = this.getAttribute('data-img') || '';

            // Cập nhật nội dung Toast đúng yêu cầu đề bài
            if (toastMsgEl) {
                toastMsgEl.innerHTML = `Đã thêm <strong>${productName}</strong> vào giỏ`;
            }
            if (cartToastInstance) {
                cartToastInstance.show();
            }

            // Tăng số lượng giỏ hàng trên giao diện ngay lập tức
            if (badgeCountEl) {
                let current = parseInt(badgeCountEl.textContent.trim()) || 0;
                badgeCountEl.textContent = current + 1;
            }

            // Gửi dữ liệu về Controller theo luồng thuần PHP (Fetch API ngầm hoặc cho phép href chạy)
            if (this.tagName.toLowerCase() === 'button' && !this.closest('a')) {
                // Gửi Fetch API ngầm để lưu vào $_SESSION['giohang']
                fetch(`index.php?act=themgiohang&id=${productId}&tensp=${encodeURIComponent(productName)}&dongia=${price}&hinh=${encodeURIComponent(img)}&ajax=1`)
                    .catch(err => console.log('Cart fetch: ', err));
            }
        });
    });

    // Khôi phục tùy biến Mùa, Font, Nền từ LocalStorage
    restoreUserPreferences();
});

// Hàm đổi chủ đề mùa [17/6] [24/6]
function changeThemeSeason(season) {
    document.body.classList.remove('theme-spring', 'theme-summer', 'theme-autumn', 'theme-winter');
    if (season && season !== 'default') {
        document.body.classList.add(season);
    }
    localStorage.setItem('selected_season', season);
}

// Hàm đổi Font chữ
function changeFontFamily(font) {
    document.body.classList.remove('font-segoe', 'font-bevietnam', 'font-roboto', 'font-montserrat');
    if (font) {
        document.body.classList.add(font);
    }
    localStorage.setItem('selected_font', font);
}

// Hàm đổi Nền
function changeBackgroundMode(bg) {
    document.body.classList.remove('bg-light-gray', 'bg-white-pure', 'bg-soft-blue');
    if (bg) {
        document.body.classList.add(bg);
    }
    localStorage.setItem('selected_bg', bg);
}

// Khôi phục cài đặt lưu trữ
function restoreUserPreferences() {
    const savedSeason = localStorage.getItem('selected_season');
    if (savedSeason) {
        changeThemeSeason(savedSeason);
        const sel = document.getElementById('seasonSelect');
        if (sel) sel.value = savedSeason;
    }

    const savedFont = localStorage.getItem('selected_font');
    if (savedFont) {
        changeFontFamily(savedFont);
        const sel = document.getElementById('fontSelect');
        if (sel) sel.value = savedFont;
    }

    const savedBg = localStorage.getItem('selected_bg');
    if (savedBg) {
        changeBackgroundMode(savedBg);
        const sel = document.getElementById('bgSelect');
        if (sel) sel.value = savedBg;
    }
}

// Đóng mở Chatbox AI [24/6]
function toggleAIChatbox() {
    const win = document.getElementById('aiChatWindow');
    if (win.style.display === 'flex') {
        win.style.display = 'none';
    } else {
        win.style.display = 'flex';
        document.getElementById('aiChatInput').focus();
    }
}

// Bấm nhanh gợi ý AI
function askAIQuick(text) {
    document.getElementById('aiChatInput').value = text;
    handleAISend(new Event('submit'));
}

// Xử lý AI phân tích và gợi ý sản phẩm
function handleAISend(e) {
    if (e) e.preventDefault();
    const input = document.getElementById('aiChatInput');
    const query = input.value.trim();
    if (!query) return;

    const chatBody = document.getElementById('aiChatBody');

    // Thêm tin nhắn của User
    const userMsg = document.createElement('div');
    userMsg.className = 'chat-bubble-msg chat-bubble-user';
    userMsg.textContent = query;
    chatBody.appendChild(userMsg);
    input.value = '';
    chatBody.scrollTop = chatBody.scrollHeight;

    // AI phân tích từ khóa và trả lời
    setTimeout(() => {
        const botMsg = document.createElement('div');
        botMsg.className = 'chat-bubble-msg chat-bubble-bot';
        
        const q = query.toLowerCase();
        let reply = '';

        if (q.includes('iphone') || q.includes('apple') || q.includes('16') || q.includes('15')) {
            reply = `🔥 Gợi ý cho bạn dòng <strong>Apple iPhone</strong> đỉnh cao:
            <ul class="mb-2 ps-3 mt-1">
                <li><strong>iPhone 16 256GB</strong>: 28.990.000đ (Siêu phẩm mới nhất)</li>
                <li><strong>iPhone 15 Pro Max 256GB</strong>: 29.990.000đ (Giảm 20%)</li>
                <li><strong>iPhone 13 128GB</strong>: 13.990.000đ (Bán chạy, giá hời)</li>
            </ul>
            <a href="index.php?act=chitiet&id=1" class="btn btn-primary btn-sm rounded-pill text-white text-decoration-none">Xem iPhone 15 Pro Max</a>`;
        } else if (q.includes('samsung') || q.includes('s24') || q.includes('ai')) {
            reply = `✨ Bạn đang quan tâm dòng <strong>Samsung Galaxy AI</strong>:
            <ul class="mb-2 ps-3 mt-1">
                <li><strong>Samsung Galaxy S24 Ultra 5G</strong>: 28.990.000đ (Quyền năng AI đỉnh cao, bút S-Pen, viền Titanium)</li>
            </ul>
            <a href="index.php?act=chitiet&id=2" class="btn btn-primary btn-sm rounded-pill text-white text-decoration-none">Xem Galaxy S24 Ultra</a>`;
        } else if (q.includes('dưới 15') || q.includes('rẻ') || q.includes('sinh viên') || q.includes('10 triệu')) {
            reply = `💰 Phân khúc tầm trung giá tốt cho bạn:
            <ul class="mb-2 ps-3 mt-1">
                <li><strong>OPPO Reno11 F 5G</strong>: 8.990.000đ (Chuyên gia chân dung)</li>
                <li><strong>iPhone 13 128GB</strong>: 13.990.000đ (Hiệu năng cực bền)</li>
            </ul>
            <a href="index.php?act=chitiet&id=4" class="btn btn-primary btn-sm rounded-pill text-white text-decoration-none">Xem OPPO Reno11 F</a>`;
        } else if (q.includes('ảnh') || q.includes('chụp') || q.includes('leica') || q.includes('xiaomi')) {
            reply = `📷 Siêu phẩm chụp ảnh chuyên nghiệp:
            <ul class="mb-2 ps-3 mt-1">
                <li><strong>Xiaomi 14 5G 256GB</strong>: 20.990.000đ (Ống kính huyền thoại Leica)</li>
                <li><strong>Samsung S24 Ultra</strong>: Camera 200MP Zoom 100x</li>
            </ul>
            <a href="index.php?act=chitiet&id=3" class="btn btn-primary btn-sm rounded-pill text-white text-decoration-none">Xem Xiaomi 14 Leica</a>`;
        } else {
            reply = `Cảm ơn bạn đã nhắn! ĐiệnThoạiZ hiện đang có chương trình khuyến mãi lớn cho các dòng <strong>iPhone 16, Samsung Galaxy S24 Ultra, Xiaomi 14 và OPPO Reno11</strong>. Bạn có muốn xem danh sách ưu đãi hôm nay không?`;
        }

        botMsg.innerHTML = reply;
        chatBody.appendChild(botMsg);
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 600);
}
</script>
</body>
</html>
