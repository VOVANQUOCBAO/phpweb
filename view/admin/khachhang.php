<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4"><?=$isSuperAdmin ? 'Quản lý khách hàng' : 'Xem khách hàng'?></h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <?php if ($isSuperAdmin): ?><section class="card mb-4"><div class="card-header fw-bold">Gửi thư/quà tặng cho khách có ngày sinh phù hợp</div><div class="card-body">
        <form action="<?=$admin_url?>&amp;act=guiquatang" method="post" class="row g-3">
            <input type="hidden" name="_csrf" value="<?=$e($csrfToken)?>">
            <div class="col-md-2"><label class="form-label">Ngày</label><input class="form-control" type="number" min="1" max="31" name="ngay"></div>
            <div class="col-md-2"><label class="form-label">Tháng</label><input class="form-control" type="number" min="1" max="12" name="thang"></div>
            <div class="col-md-2"><label class="form-label">Năm</label><input class="form-control" type="number" min="1900" max="<?=date('Y')?>" name="nam"></div>
            <div class="col-md-6"><label class="form-label">Tiêu đề</label><input class="form-control" name="tieu_de" required></div>
            <div class="col-12"><label class="form-label">Nội dung</label><textarea class="form-control" name="noi_dung" rows="3" required></textarea></div>
            <div class="col-12"><button class="btn btn-primary">Gửi qua hộp thư (và SMTP nếu cấu hình)</button></div>
        </form>
    </div></section><?php endif; ?>
    <section class="card mb-4"><div class="card-header fw-bold">Khách hàng (<?=count($ds_khachhang)?>)</div><div class="table-responsive">
        <table class="table table-hover mb-0"><thead><tr><th>ID</th><th>Khách hàng</th><th>Ngày sinh</th><th>Hạng / điểm</th><th>Đơn / tổng tiền</th><th>Trạng thái</th><?php if ($isSuperAdmin): ?><th></th><?php endif; ?></tr></thead>
            <tbody><?php foreach ($ds_khachhang as $kh): ?><tr>
                <td><?=$e($kh['id'])?></td><td><?=$e($kh['ho_ten'])?><br><small><?=$e($kh['email'])?></small></td>
                <td><?=$e($kh['ngay_sinh'] ?? '—')?></td><td><?=$e($kh['hang'])?> / <?=$e($kh['diem'])?></td>
                <td><?=$e($kh['tong_don'])?> đơn<br><?=number_format((float)$kh['tong_tien'], 0, ',', '.')?>đ</td>
                <td><?=$kh['trang_thai'] ? 'Đang hoạt động' : 'Đã khóa'?></td>
                <?php if ($isSuperAdmin): ?><td><form action="<?=$admin_url?>&amp;act=khoakhachhang" method="post">
                    <input type="hidden" name="_csrf" value="<?=$e($csrfToken)?>">
                    <input type="hidden" name="id" value="<?=$e($kh['id'])?>"><input type="hidden" name="trang_thai" value="<?=$kh['trang_thai'] ? '0' : '1'?>">
                    <button class="btn btn-sm <?=$kh['trang_thai'] ? 'btn-outline-danger' : 'btn-outline-success'?>"><?=$kh['trang_thai'] ? 'Khóa' : 'Mở khóa'?></button>
                </form></td><?php endif; ?>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_khachhang === []): ?><p class="text-muted p-3 mb-0">Chưa có khách hàng.</p><?php endif; ?>
    </section>
    <section class="card"><div class="card-header fw-bold">Khách hàng có lần hủy/bom/trả hàng (<?=count($ds_bom_huy_tra)?>)</div><div class="table-responsive">
        <table class="table table-sm mb-0"><thead><tr><th>Khách hàng</th><th>Hủy</th><th>Bom</th><th>Trả</th></tr></thead>
            <tbody><?php foreach ($ds_bom_huy_tra as $kh): ?><tr><td><?=$e($kh['ho_ten'])?> (<?=$e($kh['email'])?>)</td><td><?=$e($kh['so_lan_huy'])?></td><td><?=$e($kh['so_lan_bom'])?></td><td><?=$e($kh['so_lan_tra'])?></td></tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_bom_huy_tra === []): ?><p class="text-muted p-3 mb-0">Chưa có vi phạm.</p><?php endif; ?>
    </section>
</div>
