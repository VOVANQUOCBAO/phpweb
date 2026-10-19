<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý voucher</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <section class="card mb-4"><div class="card-header fw-bold">Tạo voucher</div><div class="card-body">
        <form action="<?=$admin_url?>&amp;act=themvoucher" method="post" class="row g-3">
            <div class="col-md-3"><label class="form-label">Mã</label><input class="form-control" name="ma_code" maxlength="50" required></div>
            <div class="col-md-2"><label class="form-label">Loại</label><select class="form-select" name="loai"><option value="tien">Giảm tiền</option><option value="phantram">Phần trăm</option><option value="mienship">Miễn ship</option></select></div>
            <div class="col-md-2"><label class="form-label">Giá trị</label><input class="form-control" type="number" min="0" step="0.01" name="gia_tri" value="0" required></div>
            <div class="col-md-2"><label class="form-label">Lượt dùng</label><input class="form-control" type="number" min="0" name="so_luong" required></div>
            <div class="col-md-3"><label class="form-label">Hạng áp dụng</label><select class="form-select" name="hang_ap_dung"><option value="">Mọi hạng</option><option>Silver</option><option>Gold</option><option>Diamond</option></select></div>
            <div class="col-md-3"><label class="form-label">Ngày bắt đầu</label><input class="form-control" type="date" name="ngay_bd" value="<?=date('Y-m-d')?>" required></div>
            <div class="col-md-3"><label class="form-label">Ngày kết thúc</label><input class="form-control" type="date" name="ngay_kt" value="<?=date('Y-m-d', strtotime('+30 days'))?>" required></div>
            <div class="col-12"><button class="btn btn-primary">Tạo voucher</button></div>
        </form>
    </div></section>
    <section class="card"><div class="card-header fw-bold">Voucher (<?=count($ds_voucher)?>)</div><div class="table-responsive">
        <table class="table table-hover mb-0"><thead><tr><th>Mã</th><th>Loại</th><th>Giá trị</th><th>Còn lượt</th><th>Thời hạn</th><th>Hạng</th><th></th></tr></thead>
            <tbody><?php foreach ($ds_voucher as $vc): ?><tr>
                <td><?=$e($vc['ma_code'])?></td><td><?=$e($vc['loai'])?></td><td><?=$e($vc['gia_tri'])?></td><td><?=$e($vc['so_luong'])?></td>
                <td><?=$e($vc['ngay_bd'])?> – <?=$e($vc['ngay_kt'])?></td><td><?=$e($vc['hang_ap_dung'] ?? 'Mọi hạng')?></td>
                <td><form action="<?=$admin_url?>&amp;act=xoavoucher" method="post" onsubmit="return confirm('Xóa voucher này?')"><input type="hidden" name="id" value="<?=$e($vc['id'])?>"><button class="btn btn-sm btn-outline-danger">Xóa</button></form></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_voucher === []): ?><p class="text-muted p-3 mb-0">Chưa có voucher.</p><?php endif; ?>
    </section>
</div>
