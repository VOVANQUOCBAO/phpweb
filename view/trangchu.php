<?php
$h = static fn(mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$imageUrl = static function (?string $source): string {
    $source = trim((string) $source);
    if ($source === '') {
        return '../view/image/Nen VHU.jpg';
    }
    if (str_starts_with($source, '/') || preg_match('~^(?:https?:)?//~i', $source)) {
        return $source;
    }
    return '../view/image/' . rawurlencode(basename(str_replace('\\', '/', $source)));
};
$renderProducts = static function (array $products) use ($h, $imageUrl): void {
    if ($products === []) {
        echo '<p class="text-muted">Chưa có sản phẩm phù hợp.</p>';
        return;
    }
    echo '<div class="row g-3">';
    foreach ($products as $sp) {
        $id = (int) $sp['id'];
        $name = $h($sp['ten_sp']);
        $price = (float) ($sp['gia_km'] ?? $sp['gia']);
        $original = (float) ($sp['gia_goc'] ?? $sp['gia']);
        $outOfStock = (int) ($sp['so_luong_ton'] ?? 0) <= 0;
        echo '<div class="col-12 col-sm-6 col-lg-3"><article class="card h-100 shadow-sm">';
        echo '<a href="index.php?act=chitiet&amp;id=' . $id . '"><img class="card-img-top p-3" style="height:210px;object-fit:contain" src="' . $h($imageUrl($sp['hinh'] ?? null)) . '" alt="' . $name . '"></a>';
        echo '<div class="card-body d-flex flex-column"><a class="h6 text-decoration-none" href="index.php?act=chitiet&amp;id=' . $id . '">' . $name . '</a>';
        echo '<p class="small text-muted mb-2">' . $h($sp['ma_sp']) . ' · Tồn: ' . (int) ($sp['so_luong_ton'] ?? 0) . '</p>';
        echo '<div class="mt-auto">';
        if ($price < $original) {
            echo '<div class="small text-muted text-decoration-line-through">' . number_format($original, 0, ',', '.') . 'đ</div>';
        }
        echo '<strong class="text-danger">' . number_format($price, 0, ',', '.') . 'đ</strong></div></div>';
        echo '<div class="card-footer bg-white d-flex gap-2"><a class="btn btn-outline-primary btn-sm flex-fill" href="index.php?act=chitiet&amp;id=' . $id . '">Chi tiết</a>';
        if ($outOfStock) {
            echo '<button class="btn btn-secondary btn-sm flex-fill" disabled>Hết hàng</button>';
        } else {
            echo '<a class="btn btn-primary btn-sm flex-fill" href="index.php?act=themgiohang&amp;id=' . $id . '">Thêm giỏ</a>';
        }
        echo '</div></article></div>';
    }
    echo '</div>';
};
?>
<main class="container py-4">
    <section class="p-4 p-md-5 mb-4 rounded-4 bg-primary text-white">
        <h1 class="display-6 fw-bold">Điện thoại chính hãng</h1>
        <p class="mb-0">Sản phẩm, giá và tình trạng tồn kho được lấy trực tiếp từ cơ sở dữ liệu.</p>
    </section>

    <form action="index.php" method="get" class="card card-body mb-4">
        <input type="hidden" name="act" value="trangchu">
        <div class="row g-2">
            <div class="col-md-5"><label class="visually-hidden" for="searchProducts">Tìm sản phẩm</label><input id="searchProducts" class="form-control" name="q" value="<?=$h($tuKhoa ?? '')?>" placeholder="Tên, mã sản phẩm"></div>
            <div class="col-md-3"><label class="visually-hidden" for="categoryFilter">Danh mục</label><select id="categoryFilter" class="form-select" name="id_danhmuc"><option value="">Tất cả danh mục</option><?php foreach ($ds_danhmuc as $dm): ?><option value="<?=$h($dm['id'])?>" <?=((int)($idDm ?? 0) === (int)$dm['id']) ? 'selected' : ''?>><?=$h($dm['ten_danhmuc'])?></option><?php endforeach; ?></select></div>
            <div class="col-md-2"><label class="visually-hidden" for="sortProducts">Sắp xếp</label><select id="sortProducts" class="form-select" name="sapxep"><option value="moi" <?=($sapXep ?? 'moi') === 'moi' ? 'selected' : ''?>>Mới nhất</option><option value="cu" <?=($sapXep ?? '') === 'cu' ? 'selected' : ''?>>Cũ nhất</option></select></div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Tìm kiếm</button></div>
        </div>
    </form>

    <?php if ($sp_km !== []): ?>
        <section class="mb-5">
            <h2 class="h4 mb-3">Khuyến mãi đang áp dụng</h2>
            <?php $renderProducts($sp_km); ?>
        </section>
    <?php endif; ?>

    <section class="mb-5">
        <h2 class="h4 mb-3">Sản phẩm mới</h2>
        <?php $renderProducts($sp_moi); ?>
    </section>

    <section class="mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h2 class="h4 mb-0"><?=!empty($tuKhoa) ? 'Kết quả tìm kiếm' : 'Tất cả sản phẩm'?></h2>
            <span class="text-muted small">Tổng <?=$h($tong_sanpham ?? count($ds_sanpham))?> sản phẩm</span>
        </div>
        <?php $renderProducts($ds_sanpham); ?>
        <?php if (!empty($con_tiep)): ?>
            <?php $nextQuery = ['act' => 'trangchu', 'q' => $tuKhoa ?? '', 'id_danhmuc' => $idDm ?? '', 'sapxep' => $sapXep ?? 'moi', 'trang' => (int)($trang ?? 1) + 1, 'moi_trang' => $moi_trang ?? 12]; ?>
            <div class="text-center mt-4"><a class="btn btn-outline-primary" href="index.php?<?=http_build_query($nextQuery)?>">Xem thêm</a></div>
        <?php endif; ?>
    </section>
</main>
