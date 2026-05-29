<?php

use Config\Database;

if (! function_exists('filter_table_columns')) {
    /**
     * Hanya kembalikan key yang benar-benar ada sebagai kolom di tabel.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    function filter_table_columns(string $table, array $data): array
    {
        try {
            $db = Database::connect();
        } catch (\Throwable) {
            return $data;
        }

        $result = [];

        foreach ($data as $column => $value) {
            if ($db->fieldExists($column, $table)) {
                $result[$column] = $value;
            }
        }

        return $result;
    }
}

if (! function_exists('table_has_column')) {
    function table_has_column(string $table, string $column): bool
    {
        try {
            return Database::connect()->fieldExists($column, $table);
        } catch (\Throwable) {
            return false;
        }
    }
}
