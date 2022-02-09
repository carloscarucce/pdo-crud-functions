<?php

if (!function_exists('pdo_delete_row')) {
    /**
     * Delete a row from given table.
     *
     * @param PDO $pdo Connection object
     * @param string $table The table name
     * @param mixed $primaryKeyValue Primary key column value
     * @param string $primaryKeyColumn Primary key column name (default: 'id')
     *
     * @return bool
     */
    function pdo_delete_row(PDO $pdo, string $table, $primaryKeyValue, string $primaryKeyColumn = 'id'): ?int
    {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE $primaryKeyColumn = ?");
        $executed = $stmt->execute([$primaryKeyValue]);

        return $executed ? $stmt->rowCount() : null;
    }
}
