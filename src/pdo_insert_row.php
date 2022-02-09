<?php

if (!function_exists('pdo_insert_row')) {
    /**
     * Inserts a new in given table.
     *
     * @param PDO $pdo Connection object
     * @param string $table The table name
     * @param array $data Associative array where indexes are the respective table columns
     *
     * @return string|null The new row identifier, or NULL in case it has not been created
     */
    function pdo_insert_row(PDO $pdo, string $table, array $data): ?string
    {
        $fields = implode(',', array_keys($data));
        $placeholders = rtrim(str_repeat('?,', count($data)), ',');

        $stmt = $pdo->prepare("INSERT INTO $table ($fields) VALUES ($placeholders)");
        $executed = $stmt->execute(array_values($data));

        return $executed ? (string) $pdo->lastInsertId() : null;
    }
}
