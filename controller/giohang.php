<?php
// File controller/giohang.php theo đúng chuẩn bài mẫu của thầy (Lab 3.1)
function kiemtra($id): int {
    if (!isset($_SESSION['giohang']) || !is_array($_SESSION['giohang'])) {
        return -1;
    }
    for ($i = 0; $i < sizeof($_SESSION['giohang']); $i++) {
        if (isset($_SESSION['giohang'][$i][0]) && $_SESSION['giohang'][$i][0] == $id[0]) {
            return $i;
        }
    }
    return -1;
}
?>

