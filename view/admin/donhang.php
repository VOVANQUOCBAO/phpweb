<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
$nextStates = [
    donhang::CHO_XAC_NHAN => [donhang::XAC_NHAN, donhang::DA_HUY],
    donhang::XAC_NHAN => [donhang::DANG_GIAO],
    donhang::DANG_GIAO => [donhang::DA_GIAO, donhang::BOM_HANG, donhang::TRA_HANG],
    donhang::DA_GIAO => [donhang::THANH_CONG],
];
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý đơn hàng</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <?php if (isset($chitiet) && $chitiet !== null): ?>
        <section class="card mb-4"><div class="card-header fw-bold">Chi tiết đơn #<?=$e($chitiet['id'])?></div>
            <div class="card-body">
                <p>Khách hàng #<?=$e($chitiet['id_khachhang'])?> · Trạng thái: <?=$e($chitiet['trang_thai'])?></p>
                <p>Địa chỉ: <?=$e($chitiet['dia_chi'])?> · Điện thoại: <?=$e($chitiet['sdt'])?></p>
                <p>Tổng: <?=number_format((float)$chitiet['tong_tien'], 0, ',', '.')?>đ · Phí ship: <?=number_format((float)$chitiet['phi_ship'], 0, ',', '.')?>đ</p>
                <div class="table-responsive"><table class="table table-sm"><thead><tr><th>Mã SP</th><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th></tr></thead>
                    <tbody><?php foreach ($chitiet['chitiet'] as $item): ?><tr><td><?=$e($item['ma_sp'])?></td><td><?=$e($item['ten_sp'])?></td><td><?=$e($item['so_luong'])?></td><td><?=number_format((float)$item['don_gia'], 0, ',', '.')?>đ</td></tr><?php endforeach; ?></tbody>
                </table></div>
                <a class="btn btn-outline-secondary btn-sm" href="<?=$admin_url?>&amp;act=donhang">Quay lại danh sách</a>
            </div>
        </section>
    <?php endif; ?>
    <section class="card"><div class="card-header fw-bold">Đơn hàng (<?=count($ds_donhang)?>)</div><div class="table-responsive">
        <table class="table table-hover align-middle mb-0"><thead><tr><th>ID / Ngày</th><th>Khách hàng</th><th>Liên hệ</th><th>Tổng</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
            <tbody><?php foreach ($ds_donhang as $dh): ?><tr>
                <td><a href="<?=$admin_url?>&amp;act=chitietdonhang&amp;id=<?=$e($dh['id'])?>">#<?=$e($dh['id'])?></a><br><small><?=$e($dh['ngay_dat'])?></small></td>
                <td><?=$e($dh['ho_ten'])?><br><small><?=$e($dh['email'])?></small></td>
                <td><?=$e($dh['sdt'])?><br><?=$e($dh['dia_chi'])?></td>
                <td><?=number_format((float)$dh['tong_tien'], 0, ',', '.')?>đ</td><td><?=$e($dh['trang_thai'])?></td>
                <td><?php $options = $nextStates[$dh['trang_thai']] ?? []; if ($options !== []): ?>
                    <form action="<?=$admin_url?>&amp;act=capnhattrangthai" method="post" class="d-flex flex-wrap gap-1">
                        <input type="hidden" name="id" value="<?=$e($dh['id'])?>">
                        <select class="form-select form-select-sm" name="trang_thai"><?php foreach ($options as $state): ?><option value="<?=$e($state)?>"><?=$e($state)?></option><?php endforeach; ?></select>
                        <input class="form-control form-control-sm" name="ly_do" placeholder="Lý do (nếu hủy/bom/trả)">
                        <button class="btn btn-sm btn-primary">Cập nhật</button>
                    </form><?php else: ?><span class="text-muted">Đã kết thúc</span><?php endif; ?>
                </td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_donhang === []): ?><p class="text-muted p-3 mb-0">Chưa có đơn hàng.</p><?php endif; ?>
    </section>
</div>
