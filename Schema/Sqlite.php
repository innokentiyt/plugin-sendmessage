<?php

namespace Kanboard\Plugin\Sendmessage\Schema;

const VERSION = 1;

function version_1($pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS sendmessage_messages (
        message TEXT NOT NULL,
        user_id INT NOT NULL,
		obtained INT NOT NULL
    )');
}
