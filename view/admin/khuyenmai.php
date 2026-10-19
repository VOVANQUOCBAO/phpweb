<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý chương trình khuyến mãi</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <section class="card mb-4"><div class="card-header fw-bold">Tạo khuyến mãi</div><div class="card-body">
        <?php if ($ds_sanpham === [] && $ds_danhmuc === []): ?><p class="text-muted">Thêm sản phẩm và danh mục trước khi tạo khuyến mãi.</p><?php else: ?>
        <form action="<?=$admin_url?>&amp;act=themkhuyenmai" method="post" class="row g-3">
            <div class="col-md-4"><label class="form-label">Tên chương trình</label><input class="form-control" name="ten_km" required></div>
            <div class="col-md-2"><label class="form-label">Áp dụng cho</label><select class="form-select" name="loai"><option value="sanpham">Sản phẩm</option><option value="danhmuc">Danh mục</option></select></div>
            <div class="col-md-3"><label class="form-label">Sản phẩm</label><select class="form-select" name="id_sanpham"><?php foreach ($ds_sanpham as $sp): ?><option value="<?=$e($sp['id'])?>"><?=$e($sp['ma_sp'])?> — <?=$e($sp['ten_sp'])?></option><?php endforeach; ?></select></div>
            <div class="col-md-3"><label class="form-label">Danh mục</label><select class="form-select" name="id_danhmuc"><?php foreach ($ds_danhmuc as $dm): ?><option value="<?=$e($dm['id'])?>"><?=$e($dm['ten_danhmuc'])?></option><?php endforeach; ?></select></div>
            <div class="col-md-2"><label class="form-label">Giảm (%)</label><input class="form-control" type="number" min="0" max="100" step="0.01" name="phan_tram" required></div>
            <div class="col-md-3"><label class="form-label">Ngày bắt đầu</label><input class="form-control" type="date" name="ngay_bd" value="<?=date('Y-m-d')?>" required></div>
            <div class="col-md-3"><label class="form-label">Ngày kết thúc</label><input class="form-control" type="date" name="ngay_kt" value="<?=date('Y-m-d', strtotime('+7 days'))?>" required></div>
            <div class="col-md-4"><label class="form-label">Ghi chú</label><input class="form-control" name="ghi_chu"></div>
            <div class="col-12"><button class="btn btn-primary">Tạo khuyến mãi</button></div>
        </form><?php endif; ?>
    </div></section>
    <section class="card mb-4"><div class="card-header fw-bold">Khuyến mãi (<?=count($ds_khuyenmai)?>)</div><div class="table-responsive">
        <table class="table table-hover mb-0"><thead><tr><th>Tên</th><th>Loại</th><th>Đối tượng ID</th><th>Mức giảm</th><th>Thời hạn</th><th>Ghi chú</th></tr></thead>
            <tbody><?php foreach ($ds_khuyenmai as $km): ?><tr>
                <td><?=$e($km['ten_km'])?></td><td><?=$e($km['loai'])?></td><td><?=$e($km['id_sanpham'] ?? $km['id_danhmuc'])?></td>
                <td><?=$e($km['phan_tram'])?>%</td><td><?=$e($km['ngay_bd'])?> – <?=$e($km['ngay_kt'])?></td><td><?=$e($km['ghi_chu'] ?? '')?></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_khuyenmai === []): ?><p class="text-muted p-3 mb-0">Chưa có khuyến mãi.</p><?php endif; ?>
    </section>
    <div class="row g-3"><div class="col-md-6"><section class="card"><div class="card-header">Hàng bán chậm</div><ul class="list-group list-group-flush"><?php foreach ($goi_y_e as $sp): ?><li class="list-group-item"><?=$e($sp['ma_sp'])?> — <?=$e($sp['ten_sp'])?> (đã bán <?=$e($sp['da_ban'])?>)</li><?php endforeach; ?></ul><?php if ($goi_y_e === []): ?><p class="text-muted p-3 mb-0">Không có dữ liệu.</p><?php endif; ?></section></div>
    <div class="col-md-6"><section class="card"><div class="card-header">Sắp hết hạn</div><ul class="list-group list-group-flush"><?php foreach ($goi_y_can_han as $sp): ?><li class="list-group-item"><?=$e($sp['ma_sp'])?> — <?=$e($sp['ten_sp'])?> (<?=$e($sp['han_su_dung'])?>)</li><?php endforeach; ?></ul><?php if ($goi_y_can_han === []): ?><p class="text-muted p-3 mb-0">Không có dữ liệu.</p><?php endif; ?></section></div></div>
</div>
