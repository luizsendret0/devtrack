<?php

try {
    $pdo = require __DIR__ . '/app/config/database.php';

    echo "Conexão com MySQL realizada com sucesso!";
} catch (PDOException $e) {
    echo "Falha na conexão. Verifique o MySQL, a porta e as credenciais.";
}
