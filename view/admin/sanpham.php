<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý sản phẩm và danh mục</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>

    <section class="card mb-4">
        <div class="card-header fw-bold">Thêm sản phẩm</div>
        <div class="card-body">
            <?php if ($ds_danhmuc === []): ?>
                <p class="text-muted">Hãy tạo danh mục trước khi thêm sản phẩm.</p>
            <?php else: ?>
                <form action="<?=$admin_url?>&amp;act=themsanpham" method="post" class="row g-3">
                    <div class="col-md-3"><label class="form-label">Mã sản phẩm</label><input class="form-control" name="ma_sp" maxlength="50" required></div>
                    <div class="col-md-5"><label class="form-label">Tên sản phẩm</label><input class="form-control" name="ten_sp" required></div>
                    <div class="col-md-4"><label class="form-label">Danh mục</label><select class="form-select" name="id_danhmuc" required><?php foreach ($ds_danhmuc as $dm): ?><option value="<?=$e($dm['id'])?>"><?=$e($dm['ten_danhmuc'])?></option><?php endforeach; ?></select></div>
                    <div class="col-md-3"><label class="form-label">Giá</label><input class="form-control" type="number" min="0" step="0.01" name="gia" required></div>
                    <div class="col-md-3"><label class="form-label">Số lượng gốc</label><input class="form-control" type="number" min="0" name="so_luong_goc" required></div>
                    <div class="col-md-3"><label class="form-label">Tồn kho</label><input class="form-control" type="number" min="0" name="so_luong_ton" required></div>
                    <div class="col-md-3"><label class="form-label">Hạn sử dụng</label><input class="form-control" type="date" name="han_su_dung"></div>
                    <div class="col-md-6"><label class="form-label">Đường dẫn hình ảnh</label><input class="form-control" name="hinh" maxlength="255"></div>
                    <div class="col-md-6"><label class="form-label">Mô tả</label><input class="form-control" name="mo_ta"></div>
                    <div class="col-12"><button class="btn btn-primary">Thêm sản phẩm</button></div>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <section class="card mb-4">
        <div class="card-header fw-bold">Danh mục</div>
        <div class="card-body">
            <form action="<?=$admin_url?>&amp;act=danhmuc" method="post" class="row g-2 mb-3">
                <input type="hidden" name="hanh_dong" value="them">
                <div class="col-md-5"><input class="form-control" name="ten_danhmuc" placeholder="Tên danh mục" required></div>
                <div class="col-md-5"><input class="form-control" name="mo_ta" placeholder="Mô tả (không bắt buộc)"></div>
                <div class="col-md-2"><button class="btn btn-outline-primary w-100">Thêm danh mục</button></div>
            </form>
            <div class="table-responsive"><table class="table table-sm align-middle">
                <thead><tr><th>ID</th><th>Tên danh mục</th><th>Mô tả</th><th></th></tr></thead>
                <tbody><?php foreach ($ds_danhmuc as $dm): ?><tr>
                    <td><?=$e($dm['id'])?></td>
                    <td><?=$e($dm['ten_danhmuc'])?></td>
                    <td><?=$e($dm['mo_ta'] ?? '')?></td>
                    <td class="text-end">
                        <form action="<?=$admin_url?>&amp;act=danhmuc" method="post" class="d-inline-flex gap-1">
                            <input type="hidden" name="hanh_dong" value="sua"><input type="hidden" name="id" value="<?=$e($dm['id'])?>">
                            <input class="form-control form-control-sm" name="ten_danhmuc" value="<?=$e($dm['ten_danhmuc'])?>" required>
                            <button class="btn btn-sm btn-outline-secondary">Sửa</button>
                        </form>
                        <form action="<?=$admin_url?>&amp;act=danhmuc" method="post" class="d-inline" onsubmit="return confirm('Xóa danh mục này?')">
                            <input type="hidden" name="hanh_dong" value="xoa"><input type="hidden" name="id" value="<?=$e($dm['id'])?>">
                            <button class="btn btn-sm btn-outline-danger">Xóa</button>
                        </form>
                    </td>
                </tr><?php endforeach; ?></tbody>
            </table></div>
        </div>
    </section>

    <section class="card">
        <div class="card-header fw-bold">Sản phẩm trong cơ sở dữ liệu (<?=count($ds_sanpham)?>)</div>
        <div class="table-responsive"><table class="table table-hover align-middle mb-0">
            <thead><tr><th>Mã</th><th>Tên</th><th>Danh mục</th><th>Giá</th><th>Tồn / gốc</th><th>Cập nhật</th></tr></thead>
            <tbody><?php foreach ($ds_sanpham as $sp): ?><tr>
                <td><?=$e($sp['ma_sp'])?></td><td><?=$e($sp['ten_sp'])?></td>
                <td><?php foreach ($ds_danhmuc as $dm) { if ((int)$dm['id'] === (int)$sp['id_danhmuc']) { echo $e($dm['ten_danhmuc']); break; } } ?></td>
                <td><?=number_format((float)$sp['gia'], 0, ',', '.')?>đ</td>
                <td><?=$e($sp['so_luong_ton'])?> / <?=$e($sp['so_luong_goc'])?></td>
                <td>
                    <form action="<?=$admin_url?>&amp;act=suasanpham" method="post" class="d-flex flex-wrap gap-1">
                        <input type="hidden" name="id" value="<?=$e($sp['id'])?>">
                        <input class="form-control form-control-sm" name="ten_sp" value="<?=$e($sp['ten_sp'])?>" aria-label="Tên sản phẩm">
                        <select class="form-select form-select-sm" name="id_danhmuc" aria-label="Danh mục"><?php foreach ($ds_danhmuc as $dm): ?><option value="<?=$e($dm['id'])?>" <?=((int)$dm['id'] === (int)$sp['id_danhmuc']) ? 'selected' : ''?>><?=$e($dm['ten_danhmuc'])?></option><?php endforeach; ?></select>
                        <input class="form-control form-control-sm" type="number" min="0" step="0.01" name="gia" value="<?=$e($sp['gia'])?>" aria-label="Giá">
                        <input class="form-control form-control-sm" type="number" min="0" max="<?=$e($sp['so_luong_goc'])?>" name="so_luong_ton" value="<?=$e($sp['so_luong_ton'])?>" aria-label="Tồn kho">
                        <button class="btn btn-sm btn-outline-primary">Lưu</button>
                    </form>
                    <form action="<?=$admin_url?>&amp;act=xoasanpham" method="post" class="mt-1" onsubmit="return confirm('Xóa sản phẩm này?')">
                        <input type="hidden" name="id" value="<?=$e($sp['id'])?>"><button class="btn btn-sm btn-outline-danger">Xóa</button>
                    </form>
                </td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_sanpham === []): ?><p class="text-muted p-3 mb-0">Chưa có sản phẩm.</p><?php endif; ?>
    </section>
</div>
