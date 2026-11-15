<?php
class ProfileController
{
    public function uploadAvatar(): never
    {
        if (!csrf_valid()) {
            http_response_code(403);
            exit('Requisição inválida.');
        }

        $file = $_FILES['avatar'] ?? null;
        if (!is_array($file) || is_array($file['name'] ?? null)
            || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $this->feedback('error', 'Não foi possível receber a imagem.');
        }
        $size = (int) ($file['size'] ?? 0);
        $tmp = (string) ($file['tmp_name'] ?? '');
        if ($size <= 0 || $size > 2 * 1024 * 1024 || !is_uploaded_file($tmp)) {
            $this->feedback('error', 'Envie uma imagem de até 2 MB.');
        }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
        $extMap = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $dimensions = @getimagesize($tmp);
        if (!isset($extMap[$mime]) || !is_array($dimensions)
            || $dimensions[0] < 1 || $dimensions[1] < 1
            || $dimensions[0] > 6000 || $dimensions[1] > 6000) {
            $this->feedback('error', 'Use uma imagem JPG, PNG ou WebP válida.');
        }

        $folder = __DIR__ . '/../../public/uploads/avatars';
        if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
            $this->feedback('error', 'Não foi possível criar a pasta de fotos.');
        }

        $name = bin2hex(random_bytes(16)) . '.' . $extMap[$mime];
        $path = $folder . '/' . $name;
        if (!move_uploaded_file($tmp, $path)) {
            $this->feedback('error', 'Não foi possível salvar o arquivo.');
        }

        try {
            $pdo = require __DIR__ . '/../config/database.php';
            $stmt = $pdo->prepare('SELECT avatar_path FROM users WHERE id = :id LIMIT 1');
            $stmt->execute(['id' => (int) $_SESSION['user_id']]);
            $old = $stmt->fetchColumn();

            $relative = 'uploads/avatars/' . $name;
            $update = $pdo->prepare('UPDATE users SET avatar_path = :avatar WHERE id = :id');
            $update->execute([
                'avatar' => $relative,
                'id' => (int) $_SESSION['user_id'],
            ]);
            if ($update->rowCount() < 1) {
                throw new RuntimeException('Conta não encontrada.');
            }

            if (is_string($old) && preg_match('~^uploads/avatars/[a-f0-9]{32}\.(?:jpg|png|webp)$~', $old)) {
                $oldPath = __DIR__ . '/../../public/' . $old;
                if (is_file($oldPath)) @unlink($oldPath);
            }
            $this->feedback('success', 'Foto atualizada com sucesso!');
        } catch (Throwable $error) {
            @unlink($path);
            error_log('[DevTrack profile/upload] ' . $error->getMessage());
            $this->feedback('error', 'Não foi possível atualizar a foto.');
        }
    }

    private function feedback(string $type, string $text): never
    {
        $_SESSION['profile_flash'] = ['type' => $type, 'text' => $text];
        redirect_to('dashboard');
    }
}
