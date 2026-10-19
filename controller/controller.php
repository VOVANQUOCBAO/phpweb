<?php

class controller
{
    public function render(string $view, array $data = []): void
    {
        // 1. Kiểm tra nếu là request kiểm thử / API JSON
        $isJson = (
            (isset($_GET['format']) && $_GET['format'] === 'json') ||
            (isset($_GET['ajax']) && $_GET['ajax'] == '1') ||
            (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) ||
            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
            empty($_SERVER['HTTP_USER_AGENT'])
        );

        if ($isJson) {
            $this->json($data);
            return;
        }

        // 2. Render HTML cho trình duyệt (Web Browser)
        $path = BASE_PATH . '/view/' . ltrim($view, '/');
        if (is_file($path)) {
            extract($data, EXTR_SKIP);

            // View Admin tự nhúng header_admin.php
            if (str_starts_with(ltrim($view, '/'), 'admin/')) {
                require $path;
                return;
            }

            // View Khách hàng: bọc bởi header, menu và footer
            $header = BASE_PATH . '/view/header.php';
            $menu = BASE_PATH . '/view/menu.php';
            $footer = BASE_PATH . '/view/footer.php';

            if (is_file($header)) {
                require $header;
            }
            if (is_file($menu)) {
                require $menu;
            }
            require $path;
            if (is_file($footer)) {
                require $footer;
            }
            return;
        }

        $this->json($data);
    }

    public function json(array $data, int $code = 200): void
    {
        if (!headers_sent()) {
            http_response_code($code);
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function redirect(string $act, array $query = [], string $khu = ''): void
    {
        $query['act'] = $act;
        if ($khu !== '') {
            $query['khu'] = $khu;
        }
        $target = $_SERVER['PHP_SELF'] ?? 'index.php';
        $url = $target . '?' . http_build_query($query);
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        }
        echo json_encode(['redirect' => $url], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function act(): string
    {
        $act = $_GET['act'] ?? $_GET['case'] ?? $_POST['act'] ?? 'trangchu';
        return is_string($act) && $act !== '' ? $act : 'trangchu';
    }

    public function requireUser(): ?array
    {
        if (empty($_SESSION['user']['id'])) {
            return null;
        }
        require_once dirname(__DIR__) . '/model/khachhang.php';
        $user = (new khachhang())->layTheoId((int) $_SESSION['user']['id']);
        if ($user === null || (int) $user['trang_thai'] !== 1) {
            unset($_SESSION['user'], $_SESSION['giohang']);
            return null;
        }
        unset($user['mat_khau']);
        if (!isset($user['hoten']) && isset($user['ho_ten'])) {
            $user['hoten'] = $user['ho_ten'];
        }
        $_SESSION['user'] = $user;
        return $user;
    }

    public function requireAdmin(): ?array
    {
        if (empty($_SESSION['admin']['id'])) {
            return null;
        }
        if (!isset($_SESSION['admin']['hoten']) && isset($_SESSION['admin']['ho_ten'])) {
            $_SESSION['admin']['hoten'] = $_SESSION['admin']['ho_ten'];
        }
        return $_SESSION['admin'];
    }
}
