<?php
include __DIR__ . '/header_admin.php';
$admin_url = 'index.php?khu=admin';
?>
<div class="container-fluid">
    <h3 class="mb-4">Quản lý nhân viên</h3>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$e($loi)?></div><?php endif; ?>
    <?php if ($thongBao !== null): ?><div class="alert alert-success"><?=$e($thongBao)?></div><?php endif; ?>
    <section class="card mb-4"><div class="card-header fw-bold">Thêm nhân viên</div><div class="card-body">
        <form action="<?=$admin_url?>&amp;act=themnhanvien" method="post" class="row g-3">
            <div class="col-md-3"><label class="form-label">Họ tên</label><input class="form-control" name="ho_ten" required></div>
            <div class="col-md-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div>
            <div class="col-md-3"><label class="form-label">Mật khẩu</label><input class="form-control" type="password" name="mat_khau" required></div>
            <div class="col-md-2"><label class="form-label">Vai trò</label><select class="form-select" name="vai_tro"><option>NhanVien</option><option>Admin</option></select></div>
            <div class="col-md-1 d-flex align-items-end"><button class="btn btn-primary">Thêm</button></div>
        </form>
    </div></section>
    <section class="card"><div class="card-header fw-bold">Nhân viên (<?=count($ds_nhanvien)?>)</div><div class="table-responsive">
        <table class="table table-hover mb-0"><thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Trạng thái</th><th></th></tr></thead>
            <tbody><?php foreach ($ds_nhanvien as $nv): ?><tr>
                <td><?=$e($nv['id'])?></td><td><?=$e($nv['ho_ten'])?></td><td><?=$e($nv['email'])?></td><td><?=$e($nv['vai_tro'])?></td>
                <td><?=$nv['trang_thai'] ? 'Đang hoạt động' : 'Đã khóa'?></td>
                <td><?php if ($nv['email'] !== 'admin@local.test'): ?><form action="<?=$admin_url?>&amp;act=khoanhanvien" method="post">
                    <input type="hidden" name="id" value="<?=$e($nv['id'])?>"><input type="hidden" name="trang_thai" value="<?=$nv['trang_thai'] ? '0' : '1'?>">
                    <button class="btn btn-sm <?=$nv['trang_thai'] ? 'btn-outline-danger' : 'btn-outline-success'?>"><?=$nv['trang_thai'] ? 'Khóa' : 'Mở khóa'?></button>
                </form><?php endif; ?></td>
            </tr><?php endforeach; ?></tbody>
        </table></div>
        <?php if ($ds_nhanvien === []): ?><p class="text-muted p-3 mb-0">Chưa có nhân viên.</p><?php endif; ?>
    </section>
</div>
