<?php
include "header_admin.php";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-boxes text-primary me-2"></i> [A1] Quản Lý Sản Phẩm & Danh Mục
            </h3>
            <p class="text-muted small mb-0">Thiết kế chuẩn theo bài mẫu của thầy (Form nhập phía trên, Bảng dữ liệu phía dưới)</p>
        </div>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalDanhMuc">
            <i class="fas fa-folder-plus me-1"></i> Quản Lý Danh Mục
        </button>
    </div>

    <!-- Thông báo kết quả nghiệp vụ -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'block_delete'): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-ban me-1"></i> <strong>CHẶN XÓA THÀNH CÔNG! [12/5] [9/6]</strong> Sản phẩm này đã phát sinh giao dịch trong chi tiết đơn hàng nên không được phép xóa để đảm bảo toàn vẹn dữ liệu.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 small" role="alert">
            <i class="fas fa-check-circle me-1"></i> Cập nhật dữ liệu sản phẩm thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ========================================================
         PHẦN 1: FORM NHẬP THÔNG TIN SẢN PHẨM Ở TRÊN (THEO BÀI MẪU)
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white py-3 px-4 rounded-top-4">
            <h5 class="card-title mb-0 fw-bold">
                <i class="fas fa-edit me-2"></i> Form Nhập / Chỉnh Sửa Thông Tin Sản Phẩm
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="index.php?act=themsanpham" method="POST" enctype="multipart/form-data" id="spForm">
                <input type="hidden" name="id_sp" id="form_id_sp" value="">

                <div class="row g-3">
                    <!-- Bắt buộc nhập Mã sản phẩm [12/5] -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-bold">Mã Sản Phẩm <span class="text-danger">* [12/5]</span></label>
                        <input type="text" name="ma_sp" id="form_ma_sp" class="form-control" placeholder="SP001" required>
                    </div>

                    <!-- Tên sản phẩm -->
                    <div class="col-12 col-md-5">
                        <label class="form-label small fw-bold">Tên Điện Thoại <span class="text-danger">*</span></label>
                        <input type="text" name="tensp" id="form_tensp" class="form-control" placeholder="Ví dụ: iPhone 16 Pro Max 256GB" required>
                    </div>

                    <!-- Danh mục -->
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold">Danh Mục Thương Hiệu <span class="text-danger">*</span></label>
                        <select name="id_danhmuc" id="form_danhmuc" class="form-select" required>
                            <option value="1">Apple (iPhone)</option>
                            <option value="2">Samsung Galaxy</option>
                            <option value="3">Xiaomi</option>
                            <option value="4">OPPO</option>
                        </select>
                    </div>

                    <!-- Giá gốc -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-bold">Giá Gốc (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="dongia" id="form_dongia" class="form-control" placeholder="34990000" required>
                    </div>

                    <!-- Giá khuyến mãi -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-bold">Giá Khuyến Mãi (Nếu có)</label>
                        <input type="number" name="giakhuyenmai" id="form_giakm" class="form-control" placeholder="29990000">
                    </div>

                    <!-- Số lượng tạo ban đầu (so_luong_goc) [12/5] -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-bold">Số Lượng Gốc <span class="text-danger">* [12/5]</span></label>
                        <input type="number" name="so_luong_goc" id="form_sl_goc" class="form-control" placeholder="100" min="1" required>
                    </div>

                    <!-- Số lượng tồn kho hiện tại (so_luong_ton) [19/5] -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-bold">Tồn Kho Hiện Tại <span class="text-danger">* [19/5]</span></label>
                        <input type="number" name="so_luong_ton" id="form_sl_ton" class="form-control" placeholder="15" min="0" required>
                        <small class="text-muted" style="font-size: 0.72rem;">Không được âm và không vượt SL gốc.</small>
                    </div>

                    <!-- Chọn ảnh sản phẩm -->
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold">Ảnh Sản Phẩm (File hình ảnh theo Lab 3)</label>
                        <input type="file" name="image" id="form_image" class="form-control">
                    </div>

                    <!-- Nhãn dán Badge -->
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold">Nhãn Dán (Badge hiển thị trên thẻ)</label>
                        <select name="badge" id="form_badge" class="form-select">
                            <option value="">Không có</option>
                            <option value="Mới">Mới</option>
                            <option value="-20%">Giảm 20%</option>
                            <option value="-15%">Giảm 15%</option>
                            <option value="Bán Chạy">Bán Chạy</option>
                            <option value="Trả góp 0%">Trả góp 0%</option>
                        </select>
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="col-12">
                        <label class="form-label small fw-bold">Mô Tả & Thông Số Kỹ Thuật</label>
                        <textarea name="mota" id="form_mota" class="form-control" rows="2" placeholder="Nhập tóm tắt mô tả sản phẩm..."></textarea>
                    </div>
                </div>

                <!-- Các nút tác vụ -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" name="btn_them" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-plus-circle me-1"></i> Thêm Sản Phẩm Mới
                    </button>
                    <button type="button" class="btn btn-warning px-4 fw-bold text-dark" onclick="resetSPForm()">
                        <i class="fas fa-redo me-1"></i> Làm Mới Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================
         PHẦN 2: BẢNG XEM DANH SÁCH SẢN PHẨM Ở DƯỚI (THEO BÀI MẪU)
         Kèm Hệ Thống Cảnh Báo: Đỏ (Tồn <= 5), Vàng (Hàng ế) [12/5]
         ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list-alt text-primary me-2"></i> Danh Sách Sản Phẩm Trong Kho
            </h5>
            <div class="d-flex gap-2">
                <span class="badge bg-danger p-2"><i class="fas fa-exclamation-triangle"></i> Đỏ: Tồn kho &le; 5 [12/5]</span>
                <span class="badge bg-warning text-dark p-2"><i class="fas fa-clock"></i> Vàng: Hàng ế / Bán chậm [12/5]</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small fw-bold text-uppercase">
                    <tr>
                        <th>STT</th>
                        <th>Mã SP [12/5]</th>
                        <th>Hình</th>
                        <th class="text-start">Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th>Đơn Giá</th>
                        <th>SL Gốc</th>
                        <th>Tồn Kho [19/5]</th>
                        <th>Đã Bán</th>
                        <th>Cảnh Báo [12/5]</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="small">
                    
                    <!-- Dòng SP 1: Tồn kho 15 (Bình thường) -->
                    <tr>
                        <td class="fw-bold">1</td>
                        <td><code>IP15PM</code></td>
                        <td><img src="../../view/image/iphone 15 pro max.jpeg" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1"></td>
                        <td class="text-start fw-bold">iPhone 15 Pro Max 256GB</td>
                        <td><span class="badge bg-dark">Apple</span></td>
                        <td><span class="text-danger fw-bold">29.990.000đ</span></td>
                        <td>100</td>
                        <td><span class="fw-bold text-success">15</span></td>
                        <td>85</td>
                        <td><span class="badge bg-success-subtle text-success">Ổn định</span></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-2 py-0" onclick="editSP(1, 'IP15PM', 'iPhone 15 Pro Max 256GB', 1, 34990000, 29990000, 100, 15)">Sửa</button>
                            <!-- Chặn xóa vì đã có đơn [12/5] [9/6] -->
                            <a href="index.php?act=xoasanpham&id=1&daban=85" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Sản phẩm đã bán 85 chiếc. Hệ thống sẽ kiểm tra chặn xóa!')">Xóa</a>
                        </td>
                    </tr>

                    <!-- Dòng SP 2: CẢNH BÁO ĐỎ: Tồn Kho <= 5 [12/5] -->
                    <tr class="table-danger-subtle">
                        <td class="fw-bold">2</td>
                        <td><code>S24U</code></td>
                        <td><img src="../../view/image/Samsung Galaxy S24 Ultra 5G.jpg" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1"></td>
                        <td class="text-start fw-bold">Samsung Galaxy S24 Ultra 5G</td>
                        <td><span class="badge bg-primary">Samsung</span></td>
                        <td><span class="text-danger fw-bold">28.990.000đ</span></td>
                        <td>50</td>
                        <!-- Tồn kho = 3 (<= 5) -->
                        <td><span class="badge badge-alert-red fs-6">3 (Sắp hết)</span></td>
                        <td>47</td>
                        <!-- Cảnh báo đỏ -->
                        <td><span class="badge bg-danger p-1"><i class="fas fa-exclamation-circle"></i> Gần hết hàng [12/5]</span></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-2 py-0" onclick="editSP(2, 'S24U', 'Samsung Galaxy S24 Ultra 5G', 2, 33990000, 28990000, 50, 3)">Sửa</button>
                            <a href="index.php?act=xoasanpham&id=2&daban=47" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0" onclick="return confirm('Sản phẩm đã bán 47 chiếc. Hệ thống sẽ chặn xóa!')">Xóa</a>
                        </td>
                    </tr>

                    <!-- Dòng SP 3: CẢNH BÁO VÀNG: Hàng Bán Không Được (Hàng Ế) [12/5] -->
                    <tr class="table-warning-subtle">
                        <td class="fw-bold">3</td>
                        <td><code>XM14</code></td>
                        <td><img src="../../view/image/Xiaomi 14 5G 256GB.jpg" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1"></td>
                        <td class="text-start fw-bold">Xiaomi 14 5G 256GB</td>
                        <td><span class="badge bg-warning text-dark">Xiaomi</span></td>
                        <td><span class="text-danger fw-bold">20.990.000đ</span></td>
                        <td>80</td>
                        <td><span class="fw-bold text-dark">78</span></td>
                        <!-- Đã bán chỉ 2 chiếc sau 60 ngày -->
                        <td><strong class="text-muted">2</strong></td>
                        <!-- Cảnh báo vàng hàng ế -->
                        <td>
                            <span class="badge badge-alert-yellow p-1"><i class="fas fa-hourglass-half"></i> Hàng ế / Bán chậm [12/5]</span>
                            <a href="index.php?act=khuyenmai&add_id=3" class="btn btn-danger btn-sm py-0 px-2 mt-1 d-block" style="font-size: 0.7rem;">+ Đưa vào KM</a>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-2 py-0" onclick="editSP(3, 'XM14', 'Xiaomi 14 5G 256GB', 3, 22990000, 20990000, 80, 78)">Sửa</button>
                            <a href="index.php?act=xoasanpham&id=3&daban=2" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0">Xóa</a>
                        </td>
                    </tr>

                    <!-- Dòng SP 4: Hết hàng hoàn toàn (Tồn = 0) -->
                    <tr>
                        <td class="fw-bold">4</td>
                        <td><code>IP14-128</code></td>
                        <td><img src="../../view/image/iPhone 14 128GB.png" style="width: 45px; height: 45px; object-fit: contain;" class="rounded border p-1 opacity-50"></td>
                        <td class="text-start fw-bold text-muted">iPhone 14 128GB</td>
                        <td><span class="badge bg-dark">Apple</span></td>
                        <td><span class="text-dark">18.990.000đ</span></td>
                        <td>30</td>
                        <td><span class="badge bg-secondary">0 (Hết hàng)</span></td>
                        <td>30</td>
                        <td><span class="badge bg-secondary">Cháy hàng</span></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-2 py-0" onclick="editSP(4, 'IP14-128', 'iPhone 14 128GB', 1, 18990000, 18990000, 30, 0)">Sửa</button>
                            <a href="index.php?act=xoasanpham&id=4&daban=30" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-0">Xóa</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL QUẢN LÝ DANH MỤC -->
<div class="modal fade" id="modalDanhMuc" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-folder me-2"></i> Quản Lý Danh Mục Thương Hiệu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?act=themdanhmuc" method="POST" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="tendanhmuc" class="form-control" placeholder="Tên danh mục mới (ví dụ: Google Pixel, Vivo...)" required>
                        <button type="submit" class="btn btn-primary fw-bold">Thêm Danh Mục</button>
                    </div>
                </form>

                <h6 class="fw-bold mb-2">Danh mục hiện có:</h6>
                <ul class="list-group list-group-flush border rounded-3 small">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>1. Apple (iPhone)</span>
                        <span class="badge bg-primary">4 sản phẩm</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>2. Samsung Galaxy</span>
                        <span class="badge bg-primary">4 sản phẩm</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>3. Xiaomi</span>
                        <span class="badge bg-primary">4 sản phẩm</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>4. OPPO</span>
                        <span class="badge bg-primary">2 sản phẩm</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function editSP(id, ma, ten, dm, gia, giakm, slgoc, slton) {
    document.getElementById('form_id_sp').value = id;
    document.getElementById('form_ma_sp').value = ma;
    document.getElementById('form_tensp').value = ten;
    document.getElementById('form_danhmuc').value = dm;
    document.getElementById('form_dongia').value = gia;
    document.getElementById('form_giakm').value = giakm;
    document.getElementById('form_sl_goc').value = slgoc;
    document.getElementById('form_sl_ton').value = slton;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetSPForm() {
    document.getElementById('spForm').reset();
    document.getElementById('form_id_sp').value = '';
}
</script>

        </div>
    </main>
</body>
</html>

