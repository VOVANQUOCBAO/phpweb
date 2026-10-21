<?php
$h = static fn(mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$items = is_array($giohang['items'] ?? null) ? $giohang['items'] : [];
$shipping = in_array($user['hang'] ?? 'Silver', ['Gold', 'Diamond'], true) ? 0 : 30000;
?>
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Thanh toán</h1>
        <a href="index.php?act=giohang" class="btn btn-outline-secondary">Quay lại giỏ hàng</a>
    </div>
    <?php if ($loi !== null): ?><div class="alert alert-danger"><?=$h($loi)?></div><?php endif; ?>
    <?php if ($ok ?? false): ?>
        <section class="card p-4 text-center">
            <h2 class="h4 text-success">Đặt hàng thành công</h2>
            <p>Mã đơn: <strong>#<?=$h($id_don)?></strong></p>
            <p>Tổng thanh toán: <strong><?=number_format((float)($donhang['tong_tien'] ?? 0), 0, ',', '.')?>đ</strong></p>
            <?php if (!empty($email_result['smtp']['ok'])): ?><p class="text-success">Email xác nhận đã gửi.</p>
            <?php elseif (!empty($email_result['ok'])): ?><p class="text-muted">Đơn đã lưu; email xác nhận đã được ghi vào hộp thư trong ứng dụng. SMTP có thể chưa cấu hình.</p>
            <?php else: ?><p class="text-muted">Đơn đã lưu nhưng chưa gửi được email xác nhận. Bạn có thể kiểm tra đơn trong lịch sử mua hàng.</p><?php endif; ?>
            <div class="d-flex justify-content-center gap-2">
                <a class="btn btn-primary" href="index.php?act=theodoidonhang&amp;id=<?=$h($id_don)?>">Theo dõi đơn hàng</a>
                <a class="btn btn-outline-primary" href="index.php?act=trangchu">Tiếp tục mua sắm</a>
            </div>
        </section>
    <?php elseif ($items === []): ?>
        <div class="alert alert-info">Giỏ hàng đang trống. <a href="index.php?act=trangchu">Quay lại cửa hàng</a>.</div>
    <?php else: ?>
        <div class="row g-4">
            <div class="col-lg-7">
                <section class="card"><div class="card-header fw-bold">Thông tin nhận hàng</div><div class="card-body">
                    <p class="mb-3">Khách hàng: <strong><?=$h($user['ho_ten'] ?? $user['hoten'] ?? '')?></strong> · <?=$h($user['email'] ?? '')?></p>
                    <form action="index.php?act=thanhtoan" method="post">
                        <div class="mb-3"><label class="form-label" for="shippingAddress">Địa chỉ giao hàng</label><textarea id="shippingAddress" class="form-control" name="dia_chi" rows="3" maxlength="1000" required></textarea></div>
                        <div class="mb-3"><label class="form-label" for="shippingPhone">Số điện thoại</label><input id="shippingPhone" class="form-control" type="tel" name="sdt" pattern="\+?[0-9][0-9 .()\-]{7,18}" required></div>
                        <div class="mb-3"><label class="form-label" for="voucherCode">Mã voucher (không bắt buộc)</label><input id="voucherCode" class="form-control text-uppercase" name="ma_voucher" maxlength="50"></div>
                        <button class="btn btn-primary w-100">Đặt hàng</button>
                    </form>
                </div></section>
            </div>
            <div class="col-lg-5">
                <section class="card"><div class="card-header fw-bold">Đơn hàng của bạn</div><ul class="list-group list-group-flush">
                    <?php foreach ($items as $item): ?><li class="list-group-item d-flex justify-content-between gap-2"><span><?=$h($item['ten_sp'])?> × <?=$h($item['so_luong'])?></span><strong><?=number_format((float)$item['thanh_tien'], 0, ',', '.')?>đ</strong></li><?php endforeach; ?>
                </ul><div class="card-body">
                    <div class="d-flex justify-content-between"><span>Tạm tính</span><span><?=number_format((float)($giohang['tong'] ?? 0), 0, ',', '.')?>đ</span></div>
                    <div class="d-flex justify-content-between"><span>Phí giao hàng dự kiến</span><span><?=number_format((float)$shipping, 0, ',', '.')?>đ</span></div>
                    <small class="text-muted">Voucher được kiểm tra và tính tại máy chủ khi đặt hàng.</small>
                </div></section>
            </div>
        </div>
    <?php endif; ?>
</main>
