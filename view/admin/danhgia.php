<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý đánh giá</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <section class="card"><div class="card-header fw-bold">Đánh giá từ khách hàng (<?=count($ds_danhgia)?>)</div><div class="table-responsive">
        <table class="table table-hover align-middle mb-0"><thead><tr><th>Ngày</th><th>Khách hàng</th><th>Sản phẩm</th><th>Sao</th><th>Nội dung</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody><?php foreach ($ds_danhgia as $dg): ?><tr>
                <td><?=$e($dg['ngay_tao'])?></td><td><?=$e($dg['ho_ten'])?><br><small><?=$e($dg['email'])?></small></td>
                <td><?=$e($dg['ten_sp'])?></td><td><?=$e($dg['so_sao'])?>/5</td><td><?=$e($dg['noi_dung'])?></td>
                <td><?=$dg['trang_thai'] ? 'Hiển thị' : 'Đã ẩn'?></td><td>
                    <?php if ($dg['trang_thai']): ?>
                        <form action="<?=$admin_url?>&amp;act=khoadanhgia" method="post" class="d-flex gap-1">
                            <input type="hidden" name="_csrf" value="<?=$e($csrfToken)?>">
                            <input type="hidden" name="id" value="<?=$e($dg['id'])?>"><button class="btn btn-sm btn-outline-secondary">Ẩn</button>
                        </form>
                        <?php if ((int)$dg['so_sao'] <= 2): ?><form action="<?=$admin_url?>&amp;act=khoadanhgia" method="post" class="mt-1">
                            <input type="hidden" name="_csrf" value="<?=$e($csrfToken)?>">
                            <input type="hidden" name="id" value="<?=$e($dg['id'])?>"><input type="hidden" name="khoa_khach" value="<?=$e($dg['id_khachhang'])?>">
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Ẩn đánh giá và khóa khách hàng?')">Ẩn & khóa khách</button>
                        </form><?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_danhgia === []): ?><p class="text-muted p-3 mb-0">Chưa có đánh giá.</p><?php endif; ?>
    </section>
</div>
