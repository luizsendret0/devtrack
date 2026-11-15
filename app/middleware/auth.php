<?php
// A sessão deve ter sido iniciada no public/index.php.
if (empty($_SESSION['user_id']) || !is_int($_SESSION['user_id'])) {
    redirect_to('login');
}
header('Cache-Control: private, no-store, max-age=0');
