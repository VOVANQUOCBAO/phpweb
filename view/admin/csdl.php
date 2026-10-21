<?php
require_once __DIR__ . '/header_admin.php';
$h = static fn(mixed $value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>
<div class="container-fluid px-0">
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1"><i class="fas fa-database text-success me-2"></i>Dữ liệu CSDL trực tiếp</h4>
        <p class="text-muted small mb-0">Chỉ quản trị viên mới xem được. Các thay đổi do khách hàng và admin thực hiện sẽ xuất hiện tại đây sau khi tải lại trang.</p>
    </div>

    <?php if (!empty($loi)): ?><div class="alert alert-danger"><?=$h($loi)?></div><?php endif; ?>

    <div class="row g-3 mb-4">
        <?php foreach ($tables as $name => $label): ?>
            <div class="col-6 col-md-4 col-xl-3">
                <a class="card h-100 text-decoration-none shadow-sm <?=$table === $name ? 'border-primary border-2' : 'border-0'?>"
                   href="index.php?khu=admin&amp;act=csdl&amp;bang=<?=$h($name)?>">
                    <div class="card-body py-3">
                        <div class="small text-muted"><?=$h($label)?></div>
                        <div class="fs-4 fw-bold text-dark"><?=$h($tableCounts[$name])?></div>
                        <div class="small text-muted">bản ghi</div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <section class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
            <div>
                <h5 class="mb-1 fw-bold"><?=$h($tables[$table])?> <code class="small"><?=$h($table)?></code></h5>
                <span class="small text-muted">Tổng <?=$h($totalRows)?> bản ghi · Trang <?=$h($page)?>/<?=$h($totalPages)?></span>
            </div>
            <span class="badge text-bg-info">Chỉ xem · tối đa <?=$h($pageSize)?> dòng mỗi trang</span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm align-middle mb-0">
                <thead class="table-light"><tr>
                    <?php foreach ($visibleColumns as $column): ?><th scope="col" class="text-nowrap"><?=$h($column)?></th><?php endforeach; ?>
                </tr></thead>
                <tbody>
                    <?php if ($rows === []): ?>
                        <tr><td colspan="<?=max(1, count($visibleColumns))?>" class="text-center text-muted py-4">Bảng này chưa có bản ghi.</td></tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?><tr>
                            <?php foreach ($visibleColumns as $column): ?>
                                <?php $value = $row[$column] ?? null; ?>
                                <td class="text-break" style="min-width:100px;max-width:360px">
                                    <?php if ($value === null): ?><span class="text-muted fst-italic">NULL</span>
                                    <?php else: ?><span class="d-inline-block text-truncate" style="max-width:340px" title="<?=$h($value)?>"><?=$h($value)?></span><?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr><?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($totalPages > 1): ?>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <?php if ($page > 1): ?><a class="btn btn-outline-primary btn-sm" href="index.php?khu=admin&amp;act=csdl&amp;bang=<?=$h($table)?>&amp;trang=<?=$page - 1?>">Trang trước</a><?php else: ?><span></span><?php endif; ?>
                <?php if ($page < $totalPages): ?><a class="btn btn-outline-primary btn-sm" href="index.php?khu=admin&amp;act=csdl&amp;bang=<?=$h($table)?>&amp;trang=<?=$page + 1?>">Trang sau</a><?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="card-footer small text-muted">
            Cột mật khẩu, token, secret và OTP không hiển thị. Dùng các trang quản trị nghiệp vụ để thêm hoặc cập nhật dữ liệu.
        </div>
    </section>
</div>
