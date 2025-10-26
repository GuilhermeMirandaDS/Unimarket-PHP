<?php

if (!function_exists('get_config')) {
    function get_config()
    {
        static $config = null;

        if ($config === null) {
            $configPath = APPPATH . 'Config/settings.json';
            
            if (file_exists($configPath)) {
                $config = json_decode(file_get_contents($configPath), true);
            } else {
                $config = [];
            }
        }

        return $config;
    }
}

if (!function_exists('getCategoryId')) {
    function getCategoryId($showcaseId)
    {
        $configPath = APPPATH . 'Config/settings.json';
        $config = json_decode(file_get_contents($configPath), true);

        // Retorna o ID da categoria para um determinado showcase
        return $config['showcase_' . $showcaseId . '_category'] ?? null;
    }
}

?>