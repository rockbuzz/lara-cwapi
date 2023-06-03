<?php

if (!function_exists('stringEnvToArray')) {
    function stringEnvToArray(string $data): array {
        return array_map(function ($item) {
            return trim($item);
        }, explode(',', $data));
    }
}