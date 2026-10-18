<?php
// Tự động nhận diện đường dẫn ảnh
if (!isset($img_path)) {
    if (file_exists('view/image/iphone 15 pro max.jpeg')) {
        $img_path = 'view/image/';
    } elseif (file_exists('../view/image/iphone 15 pro max.jpeg')) {
        $img_path = '../view/image/';
    } else {
        $img_path = 'view/image/';
    }
}

// Lấy ID sản phẩm từ request hoặc mặc định ID = 2 (Samsung S24 Ultra)
$id_sp = isset($_GET['id']) ? (int)$_GET['id'] : 2;

// Dữ liệu mẫu sản phẩm nếu controller chưa truyền biến $sp_detail
$products_mock = [
    1 => [
        'id' => 1,
        'name' => 'iPhone 15 Pro Max 256GB Titan Tự Nhiên',
        'price_old' => '34.990.000',
        'price_new' => '29.990.000',
        'price_num' => 29990000,
        'discount' => '-20%',
        'stock' => 15,
        'sold' => 215,
        'rating' => 5,
        'image' => 'iphone 15 pro max.jpeg',
        'brand' => 'Apple',
        'desc' => 'iPhone 15 Pro Max là chiếc điện thoại đỉnh cao với thiết kế khung viền Titanium chuẩn hàng không vũ trụ, cực nhẹ và bền bỉ. Trang bị chip Apple A17 Pro tiến trình 3nm mang lại hiệu năng gaming cấp độ console. Camera tiềm vọng zoom quang học 5x sắc nét cùng cổng sạc USB-C tốc độ cao 10Gbps.',
        'specs' => [
            'Màn hình' => 'OLED 6.7" Super Retina XDR, 120Hz ProMotion',
            'Hệ điều hành' => 'iOS 17 (Nâng cấp iOS 18)',
            'Camera sau' => 'Chính 48MP, Phụ 12MP & 12MP (Zoom 5x)',
            'Camera trước' => '12MP TrueDepth',
            'Chip xử lý' => 'Apple A17 Pro 6 nhân',
            'RAM / ROM' => '8GB / 256GB',
            'Pin & Sạc' => '4422 mAh, Sạc nhanh 20W'
        ]
    ],
    2 => [
        'id' => 2,
        'name' => 'Samsung Galaxy S24 Ultra 5G (Galaxy AI) 256GB',
        'price_old' => '33.990.000',
        'price_new' => '28.990.000',
        'price_num' => 28990000,
        'discount' => '-15%',
        'stock' => 8,
        'sold' => 148,
        'rating' => 5,
        'image' => 'Samsung Galaxy S24 Ultra 5G.jpg',
        'brand' => 'Samsung',
        'desc' => 'Samsung Galaxy S24 Ultra mang đến trải nghiệm AI toàn diện. Thiết kế viền Titanium đẳng cấp, màn hình phẳng hoàn toàn với kính cường lực Corning Gorilla Armor chống chói đỉnh cao. Camera mắt thần bóng đêm 200MP tích hợp công cụ chỉnh ảnh AI thông minh và bút S-Pen quyền năng.',
        'specs' => [
            'Màn hình' => 'Dynamic AMOLED 2X 6.8", Quad HD+, 120Hz, 2600 nits',
            'Hệ điều hành' => 'Android 14, One UI 6.1 (Cập nhật 7 năm)',
            'Camera sau' => 'Chính 200MP, Phụ 50MP, 12MP, 10MP (Zoom 100x)',
            'Camera trước' => '12MP Dual Pixel AF',
            'Chip xử lý' => 'Snapdragon 8 Gen 3 for Galaxy',
            'RAM / ROM' => '12GB / 256GB',
            'Pin & Sạc' => '5000 mAh, Sạc nhanh 45W'
        ]
    ],
    3 => [
        'id' => 3,
        'name' => 'Xiaomi 14 5G 256GB Ống Kính Leica',
        'price_old' => '22.990.000',
        'price_new' => '20.990.000',
        'price_num' => 20990000,
        'discount' => '-10%',
        'stock' => 20,
        'sold' => 68,
        'rating' => 4,
        'image' => 'Xiaomi 14 5G 256GB.jpg',
        'brand' => 'Xiaomi',
        'desc' => 'Xiaomi 14 mở ra kỷ nguyên mới với cụm 3 camera đồng chế tác cùng Leica thế hệ mới. Khung viền vát phẳng siêu gọn gàng trong lòng bàn tay. Vi xử lý Snapdragon 8 Gen 3 cực đỉnh, màn hình CrystalRes 1.5K siêu sáng 3000 nits và sạc siêu tốc HyperCharge 90W.',
        'specs' => [
            'Màn hình' => 'LTPO OLED 6.36", 1.5K, 120Hz, 3000 nits',
            'Hệ điều hành' => 'Xiaomi HyperOS, Android 14',
            'Camera sau' => '3 Camera 50MP Leica Summilux',
            'Camera trước' => '32MP HDR',
            'Chip xử lý' => 'Snapdragon 8 Gen 3 (4nm)',
            'RAM / ROM' => '12GB / 256GB',
            'Pin & Sạc' => '4610 mAh, Sạc HyperCharge 90W'
        ]
    ],
    4 => [
        'id' => 4,
        'name' => 'OPPO Reno11 F 5G Chuyên Gia Chân Dung',
        'price_old' => '9.490.000',
        'price_new' => '8.990.000',
        'price_num' => 8990000,
        'discount' => '-5%',
        'stock' => 50,
        'sold' => 92,
        'rating' => 5,
        'image' => 'OPPO Reno11 F 5G.png',
        'brand' => 'OPPO',
        'desc' => 'OPPO Reno11 F 5G nổi bật với mặt lưng thiết kế vân đá kim sa lấp lánh, kháng nước bụi IP65 bền bỉ. Camera siêu nét 64MP ghi lại chân dung rực rỡ, pin trâu 5000 mAh cùng sạc nhanh siêu tốc SuperVOOC 67W.',
        'specs' => [
            'Màn hình' => 'AMOLED 6.7", FHD+, 120Hz, 1.07 tỷ màu',
            'Hệ điều hành' => 'ColorOS 14, Android 14',
            'Camera sau' => 'Chính 64MP & Phụ 8MP, 2MP',
            'Camera trước' => '32MP Chân Dung Sắc Nét',
            'Chip xử lý' => 'MediaTek Dimensity 7050 5G',
            'RAM / ROM' => '8GB / 256GB',
            'Pin & Sạc' => '5000 mAh, Sạc nhanh SuperVOOC 67W'
        ]
    ],
    7 => [
        'id' => 7,
        'name' => 'iPhone 16 256GB Apple Intelligence Chính Hãng',
        'price_old' => '29.990.000',
        'price_new' => '28.990.000',
        'price_num' => 28990000,
        'discount' => 'Mới',
        'stock' => 30,
        'sold' => 55,
        'rating' => 5,
        'image' => 'iPhone 16 256GB.png',
        'brand' => 'Apple',
        'desc' => 'iPhone 16 mang đến cuộc cách mạng với Apple Intelligence và Nút Điều Khiển Camera (Camera Control). Hệ thống camera kép 48MP Fusion chụp ảnh độ phân giải siêu cao và quay video không gian Spatial Video cho kính Apple Vision Pro.',
        'specs' => [
            'Màn hình' => 'OLED 6.1" Super Retina XDR, Dynamic Island',
            'Hệ điều hành' => 'iOS 18',
            'Camera sau' => 'Fusion 48MP & 12MP Ultra Wide',
            'Camera trước' => '12MP TrueDepth',
            'Chip xử lý' => 'Apple A18 6 nhân 3nm',
            'RAM / ROM' => '8GB / 256GB',
            'Pin & Sạc' => '3561 mAh, Sạc nhanh 25W MagSafe'
        ]
    ]
];

$sp = $products_mock[$id_sp] ?? $products_mock[2];
if (!empty($chitiet) && is_array($chitiet)) {
    $sp['id'] = (int)$chitiet['id'];
    $sp['name'] = $chitiet['ten_sp'];
    $sp['price_old'] = number_format((float)($chitiet['gia_goc'] ?? $chitiet['gia']), 0, ',', '.');
    $sp['price_new'] = number_format((float)($chitiet['gia_km'] ?? $chitiet['gia']), 0, ',', '.');
    $sp['price_num'] = (float)($chitiet['gia_km'] ?? $chitiet['gia']);
    $sp['stock'] = (int)$chitiet['so_luong_ton'];
    if (!empty($chitiet['hinh'])) {
        $sp['image'] = $chitiet['hinh'];
    }
}
?>

<div class="container mb-5 mt-4">
    <!-- Breadcrumb điều hướng -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2 px-3 bg-white rounded-3 shadow-sm">
            <li class="breadcrumb-item"><a href="index.php?act=trangchu" class="text-decoration-none text-primary"><i class="fas fa-home me-1"></i> Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?act=trangchu&brand=<?=strtolower($sp['brand'])?>" class="text-decoration-none text-primary">Điện thoại <?=$sp['brand']?></a></li>
            <li class="breadcrumb-item active fw-semibold" aria-current="page"><?=htmlspecialchars($sp['name'])?></li>
        </ol>
    </nav>

    <!-- KHU VỰC THÔNG TIN SẢN PHẨM CHÍNH [U4] -->
    <div class="row g-4 bg-white p-4 rounded-4 shadow-sm border-blue mb-4">
        
        <!-- Cột Trái: Hình ảnh và Thư viện Thumbnail -->
        <div class="col-12 col-md-5">
            <div class="border rounded-4 p-4 mb-3 text-center position-relative bg-white" style="min-height: 380px; display: flex; align-items: center; justify-content: center;">
                <span class="badge product-badge badge-tag-sale fs-6"><?=$sp['discount']?></span>
                <img src="<?=$img_path . $sp['image']?>" class="img-fluid rounded" alt="<?=htmlspecialchars($sp['name'])?>" id="mainDetailImage" style="max-height: 320px; object-fit: contain;">
            </div>
            
            <!-- Danh sách Thumbnail -->
            <div class="d-flex justify-content-center gap-2">
                <img src="<?=$img_path . $sp['image']?>" class="img-thumbnail rounded-3 thumbnail-img active" width="70" height="70" alt="Góc 1" onclick="changeDetailImage(this.src, this)">
                <img src="<?=$img_path?>Nen VHU.jpg" class="img-thumbnail rounded-3 thumbnail-img" width="70" height="70" alt="Góc 2" onclick="changeDetailImage(this.src, this)">
                <img src="<?=$img_path . $sp['image']?>" class="img-thumbnail rounded-3 thumbnail-img" width="70" height="70" alt="Góc 3" onclick="changeDetailImage(this.src, this)">
            </div>
        </div>

        <!-- Cột Phải: Thông tin & Mua hàng -->
        <div class="col-12 col-md-7">
            <h2 class="fw-bold text-dark mb-2"><?=htmlspecialchars($sp['name'])?></h2>
            
            <div class="d-flex flex-wrap align-items-center gap-3 mb-3 small">
                <span class="text-warning">⭐⭐⭐⭐⭐ <strong>(<?=$sp['rating']?>.0)</strong></span>
                <span class="text-muted border-start ps-3">Đã bán: <strong><?=$sp['sold']?></strong></span>
                <?php if ($sp['stock'] > 0): ?>
                    <span class="text-success border-start ps-3 fw-bold"><i class="fas fa-check-circle me-1"></i> Còn hàng (Tồn kho: <?=$sp['stock']?>)</span>
                <?php else: ?>
                    <span class="text-danger border-start ps-3 fw-bold"><i class="fas fa-times-circle me-1"></i> Hết hàng</span>
                <?php endif; ?>
            </div>

            <!-- Khung Giá -->
            <div class="bg-light p-3 rounded-4 mb-4 d-flex align-items-baseline gap-3">
                <span class="text-danger fw-bold fs-2"><?=$sp['price_new']?>đ</span>
                <span class="text-muted text-decoration-line-through fs-5"><?=$sp['price_old']?>đ</span>
                <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">Tiết kiệm 5.000.000đ</span>
            </div>

            <!-- Tùy chọn Dung lượng -->
            <h6 class="fw-bold mb-2">Chọn phiên bản dung lượng:</h6>
            <div class="d-flex flex-wrap gap-2 mb-4">
                <input type="radio" class="btn-check" name="capacity" id="cap256" checked>
                <label class="btn btn-outline-primary rounded-3 px-3 py-2 text-start" for="cap256">
                    <span class="fw-bold d-block">256GB</span>
                    <small class="text-muted"><?=$sp['price_new']?>đ</small>
                </label>

                <input type="radio" class="btn-check" name="capacity" id="cap512">
                <label class="btn btn-outline-primary rounded-3 px-3 py-2 text-start" for="cap512">
                    <span class="fw-bold d-block">512GB</span>
                    <small class="text-muted">32.490.000đ</small>
                </label>

                <input type="radio" class="btn-check" name="capacity" id="cap1tb">
                <label class="btn btn-outline-primary rounded-3 px-3 py-2 text-start" for="cap1tb">
                    <span class="fw-bold d-block">1TB</span>
                    <small class="text-muted">37.990.000đ</small>
                </label>
            </div>

            <!-- Khuyến mãi đi kèm chuẩn TGDD -->
            <div class="border rounded-3 border-primary mb-4 overflow-hidden">
                <div class="bg-primary text-white p-2 px-3 fw-bold small">
                    <i class="fas fa-gift me-2 text-warning"></i> KHUYẾN MÃI TRỊ GIÁ 2.000.000đ
                </div>
                <div class="p-3 bg-white small">
                    <ul class="mb-0 ps-3 text-secondary lh-lg">
                        <li>Tặng phiếu giảm giá 500.000đ mua phụ kiện chính hãng.</li>
                        <li>Thu cũ đổi mới trợ giá thêm đến 2.000.000đ.</li>
                        <li>Tặng củ sạc nhanh và ốp lưng cao cấp.</li>
                        <li>Bảo hành 1 đổi 1 trong 30 ngày đầu nếu lỗi nhà sản xuất.</li>
                    </ul>
                </div>
            </div>

            <!-- Form chọn số lượng & Thêm vào giỏ hàng [W] -->
            <form action="index.php?act=themgiohang" method="GET" class="d-flex flex-column gap-3">
                <input type="hidden" name="act" value="themgiohang">
                <input type="hidden" name="id" value="<?=$sp['id']?>">
                <input type="hidden" name="tensp" value="<?=htmlspecialchars($sp['name'])?>">
                <input type="hidden" name="dongia" value="<?=$sp['price_num']?>">
                <input type="hidden" name="hinh" value="<?=$sp['image']?>">

                <div class="d-flex align-items-center gap-3">
                    <label class="fw-bold small text-secondary">Số lượng mua:</label>
                    <div class="input-group" style="width: 140px;">
                        <button type="button" class="btn btn-outline-secondary" onclick="decQty()">-</button>
                        <input type="number" id="buyQty" name="sl" class="form-control text-center fw-bold" value="1" min="1" max="<?=$sp['stock']?>">
                        <button type="button" class="btn btn-outline-secondary" onclick="incQty(<?=$sp['stock']?>)">+</button>
                    </div>
                    <span class="small text-muted">(Tồn kho: <?=$sp['stock']?> máy)</span>
                </div>

                <div class="d-flex gap-3 mt-2">
                    <?php if ($sp['stock'] > 0): ?>
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1 fw-bold rounded-4 btn-add-cart py-3 shadow" 
                                data-id="<?=$sp['id']?>" 
                                data-name="<?=htmlspecialchars($sp['name'])?>" 
                                data-price="<?=$sp['price_num']?>" 
                                data-img="<?=$sp['image']?>">
                            <i class="fas fa-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary btn-lg flex-grow-1 fw-bold rounded-4 py-3 disabled">
                            <i class="fas fa-ban me-2"></i> SẢN PHẨM TẠM HẾT HÀNG
                        </button>
                    <?php endif; ?>
                </div>
            </form>

        </div>
    </div>

    <!-- KHU VỰC THÔNG SỐ KỸ THUẬT & MÔ TẢ & BÌNH LUẬN ĐÁNH GIÁ [U4] -->
    <div class="row g-4">
        <!-- Cột Mô tả và Thông số -->
        <div class="col-12 col-lg-7">
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <h4 class="fw-bold border-bottom pb-2 mb-3 text-primary"><i class="fas fa-info-circle me-2"></i> Đặc điểm nổi bật</h4>
                <div class="text-secondary lh-lg mb-4">
                    <p><?=nl2br(htmlspecialchars($sp['desc']))?></p>
                </div>

                <!-- Bảng thông số kỹ thuật -->
                <h5 class="fw-bold border-bottom pb-2 mb-3 text-dark"><i class="fas fa-microchip me-2 text-primary"></i> Thông số kỹ thuật</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover small">
                        <tbody>
                            <?php foreach ($sp['specs'] as $spec_key => $spec_val): ?>
                                <tr>
                                    <th style="width: 35%;" class="text-muted"><?=$spec_key?></th>
                                    <td class="fw-semibold"><?=$spec_val?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cột Bình luận & Đánh giá [U4] -->
        <div class="col-12 col-lg-5">
            <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                <h4 class="fw-bold border-bottom pb-2 mb-3 text-primary"><i class="fas fa-star me-2 text-warning"></i> Đánh giá & Nhận xét</h4>
                
                <!-- Tóm tắt số sao -->
                <div class="text-center p-3 bg-light rounded-3 mb-4">
                    <div class="fs-1 fw-bold text-warning">4.9 / 5</div>
                    <div class="text-warning mb-1">⭐⭐⭐⭐⭐</div>
                    <div class="small text-muted">Dựa trên 56 lượt đánh giá từ khách hàng đã mua</div>
                </div>

                <!-- Form gửi đánh giá chấm sao [U4] [W] -->
                <form action="index.php?act=themdanhgia" method="POST" class="mb-4 bg-light p-3 rounded-4 border">
                    <input type="hidden" name="id_sp" value="<?=$sp['id']?>">
                    <h6 class="fw-bold mb-2 text-dark"><i class="fas fa-pen me-1"></i> Gửi đánh giá của bạn</h6>
                    
                    <div class="mb-2">
                        <label class="form-label small text-muted mb-1">Họ tên của bạn:</label>
                        <input type="text" name="hoten" class="form-control form-control-sm rounded-3" placeholder="Nhập họ và tên..." required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small text-muted mb-1">Chấm điểm sao:</label>
                        <select class="form-select form-select-sm rounded-3" name="sao">
                            <option value="5" selected>⭐⭐⭐⭐⭐ (Rất hài lòng)</option>
                            <option value="4">⭐⭐⭐⭐ (Hài lòng)</option>
                            <option value="3">⭐⭐⭐ (Bình thường)</option>
                            <option value="2">⭐⭐ (Chưa hài lòng)</option>
                            <option value="1">⭐ (Kém chất lượng)</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small text-muted mb-1">Nội dung nhận xét:</label>
                        <textarea class="form-control form-control-sm rounded-3" name="noidung" rows="3" placeholder="Chia sẻ trải nghiệm sử dụng thực tế của bạn..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                        <i class="fas fa-paper-plane me-1"></i> Gửi đánh giá
                    </button>
                </form>

                <!-- Danh sách bình luận hợp lệ (chưa bị khóa) [24/6] -->
                <div class="review-list">
                    <div class="d-flex mb-3 border-bottom pb-3">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px;">
                                HQ
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold">Hoàng Quân</h6>
                                <small class="text-muted">Hôm qua</small>
                            </div>
                            <div class="text-warning small mb-1">⭐⭐⭐⭐⭐ <span class="badge bg-success-subtle text-success ms-1"><i class="fas fa-check"></i> Đã mua tại shop</span></div>
                            <p class="mb-0 small text-secondary">Máy dùng siêu mượt, màn hình sắc nét và pin dùng cả ngày không hết. Giao hàng trong 1 tiếng rất ấn tượng!</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3 border-bottom pb-3">
                        <div class="me-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px;">
                                TM
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold">Trần Mai Anh</h6>
                                <small class="text-muted">3 ngày trước</small>
                            </div>
                            <div class="text-warning small mb-1">⭐⭐⭐⭐⭐ <span class="badge bg-success-subtle text-success ms-1"><i class="fas fa-check"></i> Đã mua tại shop</span></div>
                            <p class="mb-0 small text-secondary">Màu máy bên ngoài rất đẹp, camera zoom rõ nét từng chi tiết. Đóng gói rất cẩn thận.</p>
                        </div>
                    </div>
                </div>

                <div class="small text-muted text-center pt-2">
                    <i class="fas fa-shield-alt text-primary me-1"></i> Các đánh giá được kiểm duyệt theo quy định chất lượng.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chuyển đổi ảnh chi tiết khi click thumbnail
function changeDetailImage(src, el) {
    document.getElementById('mainDetailImage').src = src;
    document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
    el.classList.add('active');
}

// Tăng giảm số lượng mua
function decQty() {
    const input = document.getElementById('buyQty');
    let val = parseInt(input.value) || 1;
    if (val > 1) input.value = val - 1;
}

function incQty(max) {
    const input = document.getElementById('buyQty');
    let val = parseInt(input.value) || 1;
    if (val < max) input.value = val + 1;
}
</script>

<script>
// Chuyển đổi ảnh chi tiết khi click thumbnail
function changeDetailImage(src, el) {
    document.getElementById('mainDetailImage').src = src;
    document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
    el.classList.add('active');
}

// Tăng giảm số lượng mua
function decQty() {
    const input = document.getElementById('buyQty');
    let val = parseInt(input.value) || 1;
    if (val > 1) input.value = val - 1;
}

function incQty(max) {
    const input = document.getElementById('buyQty');
    let val = parseInt(input.value) || 1;
    if (val < max) input.value = val + 1;
}
</script>
</div>