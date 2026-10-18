<?php
// Xác định đường dẫn tương đối tới ảnh tùy theo ngữ cảnh gọi view
if (!isset($img_path)) {
    if (file_exists('view/image/iphone 15 pro max.jpeg')) {
        $img_path = 'view/image/';
    } elseif (file_exists('../view/image/iphone 15 pro max.jpeg')) {
        $img_path = '../view/image/';
    } else {
        $img_path = 'view/image/';
    }
}
?>

<!-- ========================================================
     1. BANNER TRƯỢT TOÀN MÀN HÌNH (CAROUSEL FULL-WIDTH)
     Hiển thị banner iPhone 16, Samsung S24 Ultra, Xiaomi 14 Ultra
     ======================================================== -->
<div id="heroCarousel" class="carousel slide carousel-fullwidth" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <!-- Banner 1: iPhone 16 Pro Max -->
        <div class="carousel-item active">
            <a href="index.php?act=chitiet&id=7">
                <img src="<?=$img_path?>banner_iphone16.svg" class="d-block w-100" alt="iPhone 16 Pro Max Mới">
            </a>
        </div>
        <!-- Banner 2: Samsung Galaxy S24 Ultra -->
        <div class="carousel-item">
            <a href="index.php?act=chitiet&id=2">
                <img src="<?=$img_path?>banner_s24.svg" class="d-block w-100" alt="Samsung Galaxy S24 Ultra AI">
            </a>
        </div>
        <!-- Banner 3: Xiaomi 14 Ultra Leica -->
        <div class="carousel-item">
            <a href="index.php?act=chitiet&id=3">
                <img src="<?=$img_path?>banner_xiaomi.svg" class="d-block w-100" alt="Xiaomi 14 Ultra Leica">
            </a>
        </div>
    </div>
    <!-- Nút điều hướng Carousel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true"></span>
        <span class="visually-hidden">Trước</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-50 rounded-circle" aria-hidden="true"></span>
        <span class="visually-hidden">Sau</span>
    </button>
</div>

<!-- ========================================================
     KHU VỰC CHÍNH (CONTAINER)
     ======================================================== -->
<div class="container mb-5">

    <!-- THANH BỘ LỌC NHANH & SẮP XẾP SẢN PHẨM [17/6] -->
    <div class="bg-white p-3 rounded-4 shadow-sm mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Lọc theo danh mục thương hiệu -->
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="fw-bold small text-muted"><i class="fas fa-filter text-primary me-1"></i> Thương hiệu:</span>
            <a href="index.php?act=trangchu" class="btn btn-outline-primary btn-sm rounded-pill px-3 active">Tất cả</a>
            <a href="#block-apple" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fab fa-apple me-1"></i> Apple</a>
            <a href="#block-samsung" class="btn btn-outline-primary btn-sm rounded-pill px-3">Samsung</a>
            <a href="#block-xiaomi" class="btn btn-outline-primary btn-sm rounded-pill px-3">Xiaomi</a>
            <a href="#block-khuyenmai" class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="fas fa-bolt me-1"></i> Khuyến mãi HOT</a>
        </div>

        <!-- Bộ lọc sắp xếp: Mới -> Cũ [17/6] -->
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold small text-muted"><i class="fas fa-sort-amount-down me-1"></i> Sắp xếp:</span>
            <select class="form-select form-select-sm rounded-pill" style="width: auto;" onchange="location.href='index.php?act=trangchu&sort='+this.value">
                <option value="moi_cu" selected>Mới nhất → Cũ nhất [17/6]</option>
                <option value="gia_tang">Giá thấp → cao</option>
                <option value="gia_giam">Giá cao → thấp</option>
                <option value="ban_chay">Bán chạy nhất</option>
            </select>
        </div>
    </div>

    <!-- ========================================================
         KHỐI NỔI BẬT 1: 🔥 SẢN PHẨM KHUYẾN MÃI HOT [17/6]
         (Làm nổi bật viền xanh và hiệu ứng thu hút)
         ======================================================== -->
    <section id="block-khuyenmai" class="highlight-section mb-5 p-4 border-blue">
        <div class="section-title-wrap">
            <h2 class="section-title text-danger">
                <span>🔥 SẢN PHẨM KHUYẾN MÃI HOT</span>
                <span class="badge bg-danger fs-6 text-white text-uppercase py-1 px-2 ms-2">Giảm Đến 30%</span>
            </h2>
            <a href="index.php?act=trangchu&loai=khuyenmai" class="btn btn-outline-danger btn-sm rounded-pill px-3">Xem tất cả KM <i class="fas fa-chevron-right ms-1"></i></a>
        </div>

        <!-- Lưới 4 sản phẩm trên 1 hàng (PC) -->
        <div class="row g-4">
            
            <!-- SP 1: iPhone 15 Pro Max -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale"><i class="fas fa-bolt me-1"></i> -20%</span>
                    <a href="index.php?act=chitiet&id=1" class="product-img-wrapper">
                        <img src="<?=$img_path?>iphone 15 pro max.jpeg" alt="iPhone 15 Pro Max 256GB">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=1" class="product-title">iPhone 15 Pro Max 256GB Titan Tự Nhiên</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(48)</small></span>
                            <span>Đã bán: <strong>215</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">15</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">34.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">29.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=1&tensp=iPhone+15+Pro+Max+256GB&dongia=29990000&hinh=iphone+15+pro+max.jpeg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="1" data-name="iPhone 15 Pro Max 256GB" data-price="29990000" data-img="iphone 15 pro max.jpeg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP 2: Samsung Galaxy S24 Ultra -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale"><i class="fas fa-fire me-1"></i> -15%</span>
                    <a href="index.php?act=chitiet&id=2" class="product-img-wrapper">
                        <img src="<?=$img_path?>Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung Galaxy S24 Ultra">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=2" class="product-title">Samsung Galaxy S24 Ultra 5G (Galaxy AI)</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(72)</small></span>
                            <span>Đã bán: <strong>148</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">8</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">33.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">28.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=2&tensp=Samsung+Galaxy+S24+Ultra+5G&dongia=28990000&hinh=Samsung+Galaxy+S24+Ultra+5G.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="2" data-name="Samsung Galaxy S24 Ultra 5G" data-price="28990000" data-img="Samsung Galaxy S24 Ultra 5G.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP 3: Xiaomi 14 5G -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-10%</span>
                    <a href="index.php?act=chitiet&id=3" class="product-img-wrapper">
                        <img src="<?=$img_path?>Xiaomi 14 5G 256GB.jpg" alt="Xiaomi 14 5G">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=3" class="product-title">Xiaomi 14 5G 256GB Ống Kính Leica</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐ <small class="text-secondary">(35)</small></span>
                            <span>Đã bán: <strong>68</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">20</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">22.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">20.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=3&tensp=Xiaomi+14+5G+256GB&dongia=20990000&hinh=Xiaomi+14+5G+256GB.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="3" data-name="Xiaomi 14 5G 256GB" data-price="20990000" data-img="Xiaomi 14 5G 256GB.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP 4: iPhone 15 Plus -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-6%</span>
                    <a href="index.php?act=chitiet&id=6" class="product-img-wrapper">
                        <img src="<?=$img_path?>iphone 15 plus.png" alt="iPhone 15 Plus">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=6" class="product-title">iPhone 15 Plus 128GB Chính Hãng VN/A</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(52)</small></span>
                            <span>Đã bán: <strong>110</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">12</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">25.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">24.590.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=6&tensp=iPhone+15+Plus+128GB&dongia=24590000&hinh=iphone+15+plus.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="6" data-name="iPhone 15 Plus 128GB" data-price="24590000" data-img="iphone 15 plus.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================
         KHỐI NỔI BẬT 2: ✨ SẢN PHẨM MỚI RA MẮT & BÁN CHẠY [17/6]
         ======================================================== -->
    <section class="highlight-section mb-5 p-4 border-blue">
        <div class="section-title-wrap">
            <h2 class="section-title">
                <span>✨ SẢN PHẨM MỚI RA MẮT</span>
                <span class="badge bg-primary fs-6 text-white text-uppercase py-1 px-2 ms-2">Mới Về Hàng</span>
            </h2>
            <div class="d-flex gap-2">
                <span class="badge bg-warning text-dark py-2 px-3 fw-bold"><i class="fas fa-crown me-1"></i> TOP Bán Chạy</span>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- SP Mới 1: iPhone 16 256GB -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Mới 2024</span>
                    <a href="index.php?act=chitiet&id=7" class="product-img-wrapper">
                        <img src="<?=$img_path?>iPhone 16 256GB.png" alt="iPhone 16 256GB">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=7" class="product-title">iPhone 16 256GB Apple Intelligence</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(19)</small></span>
                            <span>Đã bán: <strong>55</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">30</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">28.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=7&tensp=iPhone+16+256GB&dongia=28990000&hinh=iPhone+16+256GB.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="7" data-name="iPhone 16 256GB" data-price="28990000" data-img="iPhone 16 256GB.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP Mới 2: OPPO Reno11 F 5G -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Mới</span>
                    <a href="index.php?act=chitiet&id=4" class="product-img-wrapper">
                        <img src="<?=$img_path?>OPPO Reno11 F 5G.png" alt="OPPO Reno11 F 5G">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=4" class="product-title">OPPO Reno11 F 5G Chuyên Gia Chân Dung</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(27)</small></span>
                            <span>Đã bán: <strong>92</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">50</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">8.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=4&tensp=OPPO+Reno11+F+5G&dongia=8990000&hinh=OPPO+Reno11+F+5G.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="4" data-name="OPPO Reno11 F 5G" data-price="8990000" data-img="OPPO Reno11 F 5G.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP Bán Chạy 3: iPhone 13 128GB -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-hot"><i class="fas fa-fire me-1"></i> Bán Chạy #1</span>
                    <a href="index.php?act=chitiet&id=5" class="product-img-wrapper">
                        <img src="<?=$img_path?>iPhone 13 128GB.png" alt="iPhone 13 128GB">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=5" class="product-title">iPhone 13 128GB Quốc Dân Giá Cực Rẻ</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ <small class="text-secondary">(315)</small></span>
                            <span>Đã bán: <strong>1.450</strong></span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">45</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">13.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=5&tensp=iPhone+13+128GB&dongia=13990000&hinh=iPhone+13+128GB.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="5" data-name="iPhone 13 128GB" data-price="13990000" data-img="iPhone 13 128GB.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- SP 4 (Xử lý Tồn Kho = 0): iPhone 14 128GB HẾT HÀNG [17/6] -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm out-of-stock">
                    <!-- Badge Hết Hàng theo yêu cầu -->
                    <span class="badge product-badge badge-tag-stock"><i class="fas fa-ban me-1"></i> Hết hàng</span>
                    <div class="product-img-wrapper">
                        <img src="<?=$img_path?>iPhone 14 128GB.png" alt="iPhone 14 128GB">
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="#" class="product-title">iPhone 14 128GB (Đã Tạm Hết Hàng)</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐ <small class="text-secondary">(120)</small></span>
                            <span>Đã bán: <strong>890</strong></span>
                        </div>
                        <!-- Tồn kho = 0 cảnh báo đỏ [17/6] -->
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-danger">0 (Hết hàng)</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted fw-bold fs-5">18.990.000đ</div>
                        </div>
                    </div>
                    <!-- Vô hiệu hóa nút Mua theo yêu cầu [17/6] -->
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <button class="btn btn-secondary w-100 fw-bold rounded-3 py-2 disabled" style="cursor: not-allowed;" title="Sản phẩm tạm hết hàng">
                            <i class="fas fa-times-circle me-1"></i> Tạm hết hàng
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================================
         KHỐI THEO THƯƠNG HIỆU: 🍎 ĐIỆN THOẠI APPLE
         ======================================================== -->
    <section id="block-apple" class="mb-5 bg-white p-4 rounded-4 shadow-sm">
        <div class="section-title-wrap">
            <h2 class="section-title">
                <i class="fab fa-apple fs-3 text-dark"></i> Điện thoại Apple
            </h2>
            <a href="index.php?act=trangchu&brand=apple" class="btn btn-outline-primary btn-sm rounded-pill px-3">Xem tất cả Apple</a>
        </div>

        <div class="row g-4">
            <!-- Apple 1 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Mới</span>
                    <a href="index.php?act=chitiet&id=7" class="product-img-wrapper">
                        <img src="<?=$img_path?>iPhone 16 256GB.png" alt="iPhone 16">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=7" class="product-title">iPhone 16 256GB Chính Hãng VN/A</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (19)</span>
                            <span>Đã bán: 55</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">30</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">28.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=7&tensp=iPhone+16+256GB&dongia=28990000&hinh=iPhone+16+256GB.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="7" data-name="iPhone 16 256GB" data-price="28990000" data-img="iPhone 16 256GB.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Apple 2 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-20%</span>
                    <a href="index.php?act=chitiet&id=1" class="product-img-wrapper">
                        <img src="<?=$img_path?>iphone 15 pro max.jpeg" alt="iPhone 15 Pro Max">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=1" class="product-title">iPhone 15 Pro Max 256GB Titan</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (48)</span>
                            <span>Đã bán: 215</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">15</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">34.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">29.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=1&tensp=iPhone+15+Pro+Max+256GB&dongia=29990000&hinh=iphone+15+pro+max.jpeg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="1" data-name="iPhone 15 Pro Max 256GB" data-price="29990000" data-img="iphone 15 pro max.jpeg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Apple 3 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-6%</span>
                    <a href="index.php?act=chitiet&id=6" class="product-img-wrapper">
                        <img src="<?=$img_path?>iphone 15 plus.png" alt="iPhone 15 Plus">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=6" class="product-title">iPhone 15 Plus 128GB Màn Lớn</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (52)</span>
                            <span>Đã bán: 110</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">12</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">25.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">24.590.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=6&tensp=iPhone+15+Plus+128GB&dongia=24590000&hinh=iphone+15+plus.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="6" data-name="iPhone 15 Plus 128GB" data-price="24590000" data-img="iphone 15 plus.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Apple 4 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-hot">Hot</span>
                    <a href="index.php?act=chitiet&id=5" class="product-img-wrapper">
                        <img src="<?=$img_path?>iPhone 13 128GB.png" alt="iPhone 13">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=5" class="product-title">iPhone 13 128GB Sang Trọng</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (315)</span>
                            <span>Đã bán: 1450</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">45</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">13.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=5&tensp=iPhone+13+128GB&dongia=13990000&hinh=iPhone+13+128GB.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="5" data-name="iPhone 13 128GB" data-price="13990000" data-img="iPhone 13 128GB.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút "Xem thêm" tải thêm sản phẩm [17/6] -->
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold" onclick="alert('Đã tải toàn bộ sản phẩm Apple!')">
                <i class="fas fa-chevron-circle-down me-1"></i> Xem thêm sản phẩm Apple [17/6]
            </button>
        </div>
    </section>

    <!-- ========================================================
         KHỐI THEO THƯƠNG HIỆU: 📱 ĐIỆN THOẠI SAMSUNG
         ======================================================== -->
    <section id="block-samsung" class="mb-5 bg-white p-4 rounded-4 shadow-sm">
        <div class="section-title-wrap">
            <h2 class="section-title">
                <i class="fas fa-mobile text-primary"></i> Điện thoại Samsung
            </h2>
            <a href="index.php?act=trangchu&brand=samsung" class="btn btn-outline-primary btn-sm rounded-pill px-3">Xem tất cả Samsung</a>
        </div>

        <div class="row g-4">
            <!-- Samsung 1 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-15%</span>
                    <a href="index.php?act=chitiet&id=2" class="product-img-wrapper">
                        <img src="<?=$img_path?>Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung Galaxy S24 Ultra">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=2" class="product-title">Samsung Galaxy S24 Ultra 5G 256GB</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (72)</span>
                            <span>Đã bán: 148</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">8</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">33.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">28.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=2&tensp=Samsung+Galaxy+S24+Ultra+5G&dongia=28990000&hinh=Samsung+Galaxy+S24+Ultra+5G.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="2" data-name="Samsung Galaxy S24 Ultra 5G" data-price="28990000" data-img="Samsung Galaxy S24 Ultra 5G.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Samsung 2 (Demo SP thêm cùng danh mục) -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-12%</span>
                    <a href="index.php?act=chitiet&id=2" class="product-img-wrapper">
                        <img src="<?=$img_path?>Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung Galaxy S24 Plus">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=2" class="product-title">Samsung Galaxy S24 Plus 5G AI Phone</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (45)</span>
                            <span>Đã bán: 89</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">14</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">26.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">23.490.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=2&tensp=Samsung+Galaxy+S24+Plus&dongia=23490000&hinh=Samsung+Galaxy+S24+Ultra+5G.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="2" data-name="Samsung Galaxy S24 Plus" data-price="23490000" data-img="Samsung Galaxy S24 Ultra 5G.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Samsung 3 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Mới</span>
                    <a href="index.php?act=chitiet&id=2" class="product-img-wrapper">
                        <img src="<?=$img_path?>Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung Galaxy S24 TiTan">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=2" class="product-title">Samsung Galaxy S24 TiTan Vàng Tinh Tú</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (33)</span>
                            <span>Đã bán: 62</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">18</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">21.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=2&tensp=Samsung+Galaxy+S24+Titan&dongia=21990000&hinh=Samsung+Galaxy+S24+Ultra+5G.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="2" data-name="Samsung Galaxy S24 Titan" data-price="21990000" data-img="Samsung Galaxy S24 Ultra 5G.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Samsung 4 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-hot">Trả góp 0%</span>
                    <a href="index.php?act=chitiet&id=2" class="product-img-wrapper">
                        <img src="<?=$img_path?>Samsung Galaxy S24 Ultra 5G.jpg" alt="Samsung Galaxy A55">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=2" class="product-title">Samsung Galaxy A55 5G (Viền Kim Loại)</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (88)</span>
                            <span>Đã bán: 420</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">25</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">9.690.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=2&tensp=Samsung+Galaxy+A55+5G&dongia=9690000&hinh=Samsung+Galaxy+S24+Ultra+5G.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="2" data-name="Samsung Galaxy A55 5G" data-price="9690000" data-img="Samsung Galaxy S24 Ultra 5G.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút Xem thêm -->
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold" onclick="alert('Đã tải toàn bộ sản phẩm Samsung!')">
                <i class="fas fa-chevron-circle-down me-1"></i> Xem thêm sản phẩm Samsung [17/6]
            </button>
        </div>
    </section>

    <!-- ========================================================
         KHỐI THEO THƯƠNG HIỆU: 🌟 ĐIỆN THOẠI XIAOMI & KHÁC
         ======================================================== -->
    <section id="block-xiaomi" class="mb-5 bg-white p-4 rounded-4 shadow-sm">
        <div class="section-title-wrap">
            <h2 class="section-title">
                <i class="fas fa-bolt text-warning"></i> Điện thoại Xiaomi & Android Nổi Bật
            </h2>
            <a href="index.php?act=trangchu&brand=xiaomi" class="btn btn-outline-primary btn-sm rounded-pill px-3">Xem tất cả Android</a>
        </div>

        <div class="row g-4">
            <!-- Xiaomi 1 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-sale">-10%</span>
                    <a href="index.php?act=chitiet&id=3" class="product-img-wrapper">
                        <img src="<?=$img_path?>Xiaomi 14 5G 256GB.jpg" alt="Xiaomi 14">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=3" class="product-title">Xiaomi 14 5G 256GB Leica Master</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐ (35)</span>
                            <span>Đã bán: 68</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">20</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">22.990.000đ</div>
                            <div class="text-danger fw-bold fs-5">20.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=3&tensp=Xiaomi+14+5G+256GB&dongia=20990000&hinh=Xiaomi+14+5G+256GB.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="3" data-name="Xiaomi 14 5G 256GB" data-price="20990000" data-img="Xiaomi 14 5G 256GB.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Xiaomi 2 / OPPO -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Mới</span>
                    <a href="index.php?act=chitiet&id=4" class="product-img-wrapper">
                        <img src="<?=$img_path?>OPPO Reno11 F 5G.png" alt="OPPO Reno11 F">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=4" class="product-title">OPPO Reno11 F 5G (Bảo Hành 24T)</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (27)</span>
                            <span>Đã bán: 92</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">50</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">8.990.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=4&tensp=OPPO+Reno11+F+5G&dongia=8990000&hinh=OPPO+Reno11+F+5G.png" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="4" data-name="OPPO Reno11 F 5G" data-price="8990000" data-img="OPPO Reno11 F 5G.png">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Xiaomi 3 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-hot">Bán Chạy</span>
                    <a href="index.php?act=chitiet&id=3" class="product-img-wrapper">
                        <img src="<?=$img_path?>Xiaomi 14 5G 256GB.jpg" alt="Redmi Note 13 Pro">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=3" class="product-title">Xiaomi Redmi Note 13 Pro 4G 128GB</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐ (110)</span>
                            <span>Đã bán: 512</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">35</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-muted text-decoration-line-through small">7.290.000đ</div>
                            <div class="text-danger fw-bold fs-5">6.490.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=3&tensp=Redmi+Note+13+Pro&dongia=6490000&hinh=Xiaomi+14+5G+256GB.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="3" data-name="Redmi Note 13 Pro" data-price="6490000" data-img="Xiaomi 14 5G 256GB.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>

            <!-- Xiaomi 4 -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card shadow-sm">
                    <span class="badge product-badge badge-tag-new">Pin 5000mAh</span>
                    <a href="index.php?act=chitiet&id=3" class="product-img-wrapper">
                        <img src="<?=$img_path?>Xiaomi 14 5G 256GB.jpg" alt="Xiaomi Poco X6 Pro">
                    </a>
                    <div class="card-body p-3 d-flex flex-column">
                        <a href="index.php?act=chitiet&id=3" class="product-title">POCO X6 Pro 5G Dimensity 8300 Ultra</a>
                        <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                            <span class="text-warning">⭐⭐⭐⭐⭐ (64)</span>
                            <span>Đã bán: 280</span>
                        </div>
                        <p class="mb-2 small text-secondary">Tồn kho: <span class="fw-bold text-success">19</span></p>
                        <div class="mt-auto pt-2">
                            <div class="text-danger fw-bold fs-5">9.490.000đ</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="index.php?act=themgiohang&id=3&tensp=POCO+X6+Pro+5G&dongia=9490000&hinh=Xiaomi+14+5G+256GB.jpg" 
                           class="btn-add-cart text-decoration-none" 
                           data-id="3" data-name="POCO X6 Pro 5G" data-price="9490000" data-img="Xiaomi 14 5G 256GB.jpg">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút Xem thêm -->
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold" onclick="alert('Đã tải toàn bộ sản phẩm Android!')">
                <i class="fas fa-chevron-circle-down me-1"></i> Xem thêm sản phẩm Android [17/6]
            </button>
        </div>
    </section>

</div>