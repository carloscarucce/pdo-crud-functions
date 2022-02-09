<?php

if (!function_exists('pdo_update_row')) {
    /**
     * Updates existing row in given table.
     *
     * @param PDO $pdo Connection object
     * @param string $table The table name
     * @param array $data Associative array where indexes are the respective table columns
     * @param mixed $primaryKeyValue Primary key column value
     * @param string $primaryKeyColumn Primary key column name (default: 'id')
     *
     * @return int|null The number of affected rows. NULL when there was an error
     */
    function pdo_update_row(PDO $pdo, string $table, array $data, $primaryKeyValue, string $primaryKeyColumn = 'id'): ?int
    {
        $placeholders = implode('=?,', array_keys($data)) . '=?';

        $stmt = $pdo->prepare("UPDATE $table SET $placeholders WHERE $primaryKeyColumn=?");
        $params = array_values($data);
        $params[] = $primaryKeyValue;
        $executed = $stmt->execute($params);

        return $executed ? $stmt->rowCount() : null;
    }
}
