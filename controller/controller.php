<?php

class controller
{
    public function render(string $view, array $data = []): void
    {
        $path = BASE_PATH . '/view/' . ltrim($view, '/');
        if (is_file($path)) {
            extract($data, EXTR_SKIP);
            require $path;
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
        $_SESSION['user'] = $user;
        return $user;
    }

    public function requireAdmin(): ?array
    {
        if (empty($_SESSION['admin']['id'])) {
            return null;
        }
        return $_SESSION['admin'];
    }
}
