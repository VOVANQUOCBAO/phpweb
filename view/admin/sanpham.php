<?php
include __DIR__ . '/header_admin.php';

$h = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$dsSanPham = $ds_sanpham ?? [];
$dsDanhMuc = $ds_danhmuc ?? [];
$formatTien = static fn($value): string => number_format((float) $value, 0, ',', '.') . ' đ';
?>

<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="fas fa-boxes text-primary me-2"></i><?=$isSuperAdmin ? 'Quản lý sản phẩm và danh mục' : 'Danh sách sản phẩm'?></h3>
            <p class="text-muted small mb-0">Dữ liệu được đọc và lưu trực tiếp trên cơ sở dữ liệu.</p>
        </div>
        <?php if ($isSuperAdmin): ?>
        <button class="btn btn-outline-primary btn-sm rounded-pill px-3" type="button"
                data-bs-toggle="modal" data-bs-target="#modalDanhMuc">
            <i class="fas fa-folder-open me-1"></i> Quản lý danh mục
        </button>
        <?php endif; ?>
    </div>

    <?php if (!empty($thongBao)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $h($thongBao) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    <?php endif; ?>
    <?php if (!empty($loi)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $h($loi) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
    <?php endif; ?>

    <?php if ($isSuperAdmin): ?>
    <div class="card border-0 shadow-sm rounded-4 mb-4" id="product-form-card">
        <div class="card-header bg-primary text-white py-3 px-4 rounded-top-4">
            <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i><span id="form-title">Thêm sản phẩm</span></h5>
        </div>
        <div class="card-body p-4">
            <form action="index.php?act=themsanpham" method="POST" id="spForm">
                <input type="hidden" name="_csrf" value="<?= $h($csrfToken) ?>">
                <input type="hidden" name="id" id="form_id" disabled>
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <label for="form_ma_sp" class="form-label small fw-bold">Mã sản phẩm *</label>
                        <input type="text" name="ma_sp" id="form_ma_sp" class="form-control" maxlength="50" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label for="form_ten_sp" class="form-label small fw-bold">Tên sản phẩm *</label>
                        <input type="text" name="ten_sp" id="form_ten_sp" class="form-control" maxlength="255" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="form_danhmuc" class="form-label small fw-bold">Danh mục *</label>
                        <select name="id_danhmuc" id="form_danhmuc" class="form-select" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($dsDanhMuc as $dm): ?>
                                <option value="<?= (int) $dm['id'] ?>"><?= $h($dm['ten_danhmuc']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($dsDanhMuc === []): ?>
                            <small class="text-danger">Hãy tạo danh mục trước khi thêm sản phẩm.</small>
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="form_gia" class="form-label small fw-bold">Giá bán (VNĐ) *</label>
                        <input type="number" name="gia" id="form_gia" class="form-control" min="0" step="0.01" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="form_sl_goc" class="form-label small fw-bold">Số lượng tạo ban đầu *</label>
                        <input type="number" name="so_luong_goc" id="form_sl_goc" class="form-control" min="0" step="1" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="form_sl_ton" class="form-label small fw-bold">Tồn kho hiện tại *</label>
                        <input type="number" name="so_luong_ton" id="form_sl_ton" class="form-control" min="0" step="1" required>
                        <small class="text-muted">Không âm và không vượt số lượng tạo ban đầu.</small>
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="form_han_su_dung" class="form-label small fw-bold">Hạn sử dụng</label>
                        <input type="date" name="han_su_dung" id="form_han_su_dung" class="form-control">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="form_hinh" class="form-label small fw-bold">Tên tệp ảnh (tùy chọn)</label>
                        <input type="text" name="hinh" id="form_hinh" class="form-control" maxlength="255"
                               placeholder="Ví dụ: ai-phone-elegance.svg">
                    </div>
                    <div class="col-12">
                        <label for="form_mo_ta" class="form-label small fw-bold">Mô tả sản phẩm</label>
                        <textarea name="mo_ta" id="form_mo_ta" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4 fw-bold" id="form-submit">
                        <i class="fas fa-plus-circle me-1"></i> Thêm sản phẩm
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-4" onclick="resetSPForm()">Làm mới</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 px-4">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list text-primary me-2"></i>Danh sách sản phẩm (<?= count($dsSanPham) ?>)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light small text-uppercase">
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th class="text-start">Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>SL gốc</th>
                        <th>Tồn kho</th>
                        <th>Đã bán</th>
                        <?php if ($isSuperAdmin): ?><th>Thao tác</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($dsSanPham === []): ?>
                        <tr><td colspan="<?=$isSuperAdmin ? 8 : 7?>" class="text-muted py-4">Chưa có sản phẩm.<?=$isSuperAdmin ? ' Dùng biểu mẫu phía trên để thêm mới.' : ''?></td></tr>
                    <?php endif; ?>
                    <?php foreach ($dsSanPham as $sp): ?>
                        <?php
                        $json = json_encode([
                            'id' => (int) $sp['id'],
                            'ma_sp' => $sp['ma_sp'],
                            'ten_sp' => $sp['ten_sp'],
                            'id_danhmuc' => (int) $sp['id_danhmuc'],
                            'gia' => $sp['gia'],
                            'so_luong_goc' => (int) $sp['so_luong_goc'],
                            'so_luong_ton' => (int) $sp['so_luong_ton'],
                            'han_su_dung' => $sp['han_su_dung'],
                            'hinh' => $sp['hinh'],
                            'mo_ta' => $sp['mo_ta'],
                        ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP);
                        $ton = (int) $sp['so_luong_ton'];
                        ?>
                        <tr>
                            <td><code><?= $h($sp['ma_sp']) ?></code></td>
                            <td class="text-start fw-semibold"><?= $h($sp['ten_sp']) ?></td>
                            <td><?= $h($sp['ten_danhmuc']) ?></td>
                            <td><?= $h($formatTien($sp['gia'])) ?></td>
                            <td><?= (int) $sp['so_luong_goc'] ?></td>
                            <td><span class="badge <?= $ton <= 5 ? 'bg-danger' : 'bg-success' ?>"><?= $ton ?></span></td>
                            <td><?= (int) $sp['da_ban'] ?></td>
                            <?php if ($isSuperAdmin): ?><td>
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-product="<?= $h($json) ?>" onclick="editSP(this)">Sửa</button>
                                    <form action="index.php?act=xoasanpham" method="POST"
                                          onsubmit="return confirm('Chỉ xóa được sản phẩm chưa xuất hiện trong chi tiết đơn hàng. Tiếp tục?')">
                                        <input type="hidden" name="_csrf" value="<?= $h($csrfToken) ?>">
                                        <input type="hidden" name="id" value="<?= (int) $sp['id'] ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Xóa</button>
                                    </form>
                                </div>
                            </td><?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($isSuperAdmin): ?>
<div class="modal fade" id="modalDanhMuc" tabindex="-1" aria-labelledby="modalDanhMucLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalDanhMucLabel">
                    <i class="fas fa-folder me-2"></i>Quản lý danh mục
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body p-4">
                <form action="index.php?act=danhmuc" method="POST" class="border rounded-3 p-3 mb-4">
                    <input type="hidden" name="_csrf" value="<?= $h($csrfToken) ?>">
                    <input type="hidden" name="hanh_dong" value="them">
                    <h6 class="fw-bold">Thêm danh mục</h6>
                    <div class="mb-2">
                        <label class="form-label small">Tên danh mục *</label>
                        <input type="text" name="ten_danhmuc" class="form-control" maxlength="150" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Mô tả</label>
                        <textarea name="mo_ta" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Thêm</button>
                </form>

                <h6 class="fw-bold">Danh mục hiện có</h6>
                <?php if ($dsDanhMuc === []): ?>
                    <p class="text-muted">Chưa có danh mục.</p>
                <?php endif; ?>
                <?php foreach ($dsDanhMuc as $dm): ?>
                    <div class="border rounded-3 p-3 mb-3">
                        <form action="index.php?act=danhmuc" method="POST">
                            <input type="hidden" name="_csrf" value="<?= $h($csrfToken) ?>">
                            <input type="hidden" name="hanh_dong" value="sua">
                            <input type="hidden" name="id" value="<?= (int) $dm['id'] ?>">
                            <div class="row g-2 align-items-end">
                                <div class="col-12 col-md-5">
                                    <label class="form-label small">Tên danh mục *</label>
                                    <input type="text" name="ten_danhmuc" class="form-control"
                                           maxlength="150" value="<?= $h($dm['ten_danhmuc']) ?>" required>
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label small">Mô tả</label>
                                    <input type="text" name="mo_ta" class="form-control"
                                           value="<?= $h($dm['mo_ta']) ?>">
                                </div>
                                <div class="col-12 col-md-2 d-grid">
                                    <button type="submit" class="btn btn-outline-primary btn-sm">Lưu sửa</button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Đang có <?= (int) $dm['so_san_pham'] ?> sản phẩm.</small>
                        </form>
                        <form action="index.php?act=danhmuc" method="POST" class="mt-2"
                              onsubmit="return confirm('Xóa danh mục này? Chỉ xóa được khi không còn sản phẩm hoặc khuyến mãi liên quan.')">
                            <input type="hidden" name="_csrf" value="<?= $h($csrfToken) ?>">
                            <input type="hidden" name="hanh_dong" value="xoa">
                            <input type="hidden" name="id" value="<?= (int) $dm['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Xóa danh mục</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editSP(button) {
    const product = JSON.parse(button.dataset.product);
    document.getElementById('form_id').value = product.id;
    document.getElementById('form_id').disabled = false;
    document.getElementById('form_ma_sp').value = product.ma_sp;
    document.getElementById('form_ten_sp').value = product.ten_sp;
    document.getElementById('form_danhmuc').value = product.id_danhmuc;
    document.getElementById('form_gia').value = product.gia;
    document.getElementById('form_sl_goc').value = product.so_luong_goc;
    document.getElementById('form_sl_goc').readOnly = true;
    document.getElementById('form_sl_ton').value = product.so_luong_ton;
    document.getElementById('form_sl_ton').max = product.so_luong_goc;
    document.getElementById('form_han_su_dung').value = product.han_su_dung || '';
    document.getElementById('form_hinh').value = product.hinh || '';
    document.getElementById('form_mo_ta').value = product.mo_ta || '';
    document.getElementById('spForm').action = 'index.php?act=suasanpham';
    document.getElementById('form-title').textContent = 'Chỉnh sửa sản phẩm';
    document.getElementById('form-submit').innerHTML = '<i class="fas fa-save me-1"></i> Lưu thay đổi';
    document.getElementById('product-form-card').scrollIntoView({ behavior: 'smooth' });
}

function resetSPForm() {
    const form = document.getElementById('spForm');
    form.reset();
    form.action = 'index.php?act=themsanpham';
    document.getElementById('form_id').value = '';
    document.getElementById('form_id').disabled = true;
    document.getElementById('form_sl_goc').readOnly = false;
    document.getElementById('form_sl_ton').removeAttribute('max');
    document.getElementById('form-title').textContent = 'Thêm sản phẩm';
    document.getElementById('form-submit').innerHTML = '<i class="fas fa-plus-circle me-1"></i> Thêm sản phẩm';
}
</script>

        </div>
    </main>
</body>
</html>
