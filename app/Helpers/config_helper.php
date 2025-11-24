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

use CodeIgniter\I18n\Time;

/**
 * Converte uma data ISO (YYYY-MM-DD) para o formato brasileiro (DD/MM/YYYY).
 *
 * @param string|null $dateString Data no formato ISO (ou nulo).
 * @return string Data formatada ou string vazia se a entrada for nula.
 */
function format_date_br(?string $dateString): string
{
    if (empty($dateString)) {
        return '';
    }

    try {
        // Cria um objeto Time a partir da string de data
        $time = Time::parse($dateString);
        
        // Formata para o padrão brasileiro
        return $time->format('d/m/Y');
        
    } catch (\Exception $e) {
        // Retorna a string original ou uma mensagem de erro em caso de falha no parse
        return $dateString; 
    }
}

/**
 * Formata uma string de data/hora para o formato de hora desejado.
 *
 * @param string $timeString Data/hora completa (ex: '2026-03-23 14:30:00').
 * @param string $format Formato de saída (padrão 'H:i' para 24h).
 * @return string Hora formatada.
 */
function format_time(?string $timeString, string $format = 'H:i'): string
{
    if (empty($timeString)) {
        return '';
    }

    try {
        $time = Time::parse($timeString);
        return $time->format($format);
        
    } catch (\Exception $e) {
        return ''; 
    }
}

function is_less_than_15_days(string $futureDateString): bool
{
    // 1. Cria um objeto Time para a data futura
    try {
        $futureDate = Time::parse($futureDateString);
    } catch (\Exception $e) {
        // Se a data for inválida, retorna false
        return false; 
    }

    // 2. Cria um objeto Time para a data atual (hoje)
    $today = Time::now();

    // 3. Verifica se a data futura já passou
    if ($futureDate->isBefore($today)) {
        return false;
    }

    // 4. Calcula a diferença entre as duas datas
    // O método diff() retorna um objeto DateInterval
    $interval = $today->diff($futureDate);

    // 5. Obtém a diferença em dias
    $daysDifference = $interval->days;

    // 6. Cria a condição: se a diferença for menor ou igual a 15 dias
    if ($daysDifference <= 15) {
        return true;
    }

    return false;
}

?>