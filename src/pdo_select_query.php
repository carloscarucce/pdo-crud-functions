<?php

if (!function_exists('pdo_select_query')) {
    /**
     * Retrieve data from the database
     *
     * @param PDO $pdo Connection object
     * @param string $queryString SELECT query string
     * @param array|null $params The query parameters set in query string (named or anonymous)
     * @param callable|null $fetchFn This will be called for each row retrieved by the query, when informed. Row data will be passed as the first callable argument.
     * @param bool $fetchAll Fetch all rows at once (true) or one by one (false). Default: false. Only takes effect when $fetchFn is provided
     * @param mixed $fetchMode Controls how the next row will be returned to the caller. This value must be one of the PDO::FETCH_* constants. Default: PDO::FETCH_ASSOC. Only takes effect when $fetchFn is provided
     *
     * @return PDOStatement|null
     */
    function pdo_select_query(PDO $pdo, string $queryString, array $params = null, callable $fetchFn = null, bool $fetchAll = false, $fetchMode = PDO::FETCH_ASSOC): ?PDOStatement
    {
        $stmt = $pdo->prepare($queryString);
        $executed = $stmt->execute($params);

        if ($executed && $fetchFn) {
            if ($fetchAll) {
                foreach($stmt->fetchAll($fetchMode) as $row) {
                    $fetchFn($row);
                }
            } else {
                while($row = $stmt->fetch($fetchMode)) {
                    $fetchFn($row);
                }
            }
        }

        return $executed ? $stmt : null;
    }
}
