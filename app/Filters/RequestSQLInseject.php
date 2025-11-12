<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RequestSQLInseject implements FilterInterface
{
    private $excludedRoutes = [
        
    ];

    private $sqlInjectionPatterns = [
        // Comandos SQL básicos
        '/(\bunion\b.*\bselect\b)/i',
        '/(\bselect\b.*\bfrom\b)/i',
        '/(\binsert\b.*\binto\b)/i',
        '/(\bupdate\b.*\bset\b)/i',
        '/(\bdelete\b.*\bfrom\b)/i',
        '/(\bdrop\b.*\btable\b)/i',
        '/(\bcreate\b.*\btable\b)/i',
        '/(\balter\b.*\btable\b)/i',
        '/(\btruncate\b.*\btable\b)/i',
        
        // Comentários SQL
        '/(\-\-|\#|\/\*|\*\/)/i',
        
        // Caracteres especiais perigosos
        '/(\'\s*or\s*\'\s*=\s*\')/i',
        '/(\'\s*or\s*1\s*=\s*1)/i',
        '/(\'\s*or\s*\'\s*1\s*\')/i',
        '/(\bor\s+1\s*=\s*1)/i',
        '/(\band\s+1\s*=\s*1)/i',
        '/(\'\s*;)/i',
        
        // Funções SQL perigosas
        '/(\bexec\b|\bexecute\b|\bsp_\b)/i',
        '/(\bxp_\b|\bsp_executesql\b)/i',
        '/(\bload_file\b|\binto\s+outfile\b)/i',
        '/(\bconcat\b.*\bselect\b)/i',
        '/(\bgroup_concat\b)/i',
        '/(\binformation_schema\b)/i',
        '/(\bsystem\b|\bshell\b)/i',
        
        // Tentativas de bypass
        '/(\bscript\b|\balert\b|\bjavascript\b)/i',
        '/(\bvbscript\b|\bonload\b|\bonerror\b)/i',
        '/(\beval\b|\bsetTimeout\b|\bsetInterval\b)/i',
        
        // Caracteres hexadecimais suspeitos
        '/(0x[0-9a-f]+)/i',
        
        // Tentativas de escape
        '/(\\\x00|\\\n|\\\r|\\\x1a|\\\x22|\\\x27|\\\x5c)/i',
        
        // Comandos de sistema
        '/(\bwaitfor\b|\bdelay\b|\bsleep\b)/i',
        '/(\bbenchmark\b|\bpg_sleep\b)/i',
    ];

    private $dangerousChars = [
        '\'' => '&#39;',
        '"' => '&quot;',
        '<' => '&lt;',
        '>' => '&gt;',
        '&' => '&amp;',
        ';' => '&#59;',
        '(' => '&#40;',
        ')' => '&#41;',
        '{' => '&#123;',
        '}' => '&#125;',
        '[' => '&#91;',
        ']' => '&#93;',
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof \CodeIgniter\HTTP\IncomingRequest) {
            return $request;
        }

        log_message('debug', 'SQL Injection Filter: Starting check for URI: ' . $request->getUri()->getPath());

        $currentRoute = $request->getUri()->getPath();
        $currentRoute = ltrim($currentRoute, '/');
        
        foreach ($this->excludedRoutes as $excludedRoute) {
            if (strpos($currentRoute, $excludedRoute) === 0) {
                log_message('debug', 'SQL Injection Filter: Route excluded: ' . $currentRoute);
                return $request;
            }
        }
        
        $getData = $request->getGet();
        if ($getData) {
            log_message('debug', 'SQL Injection Filter: Checking GET data: ' . json_encode($getData));
            if ($this->checkForSQLInjection($getData)) {
                log_message('info', 'SQL Injection Filter: GET data blocked');
                return $this->handleSQLInjectionAttempt($request, 'GET');
            }
        }

        $postData = $request->getPost();
        if ($postData) {
            log_message('debug', 'SQL Injection Filter: Checking POST data: ' . json_encode($postData));
            if ($this->checkForSQLInjection($postData)) {
                log_message('info', 'SQL Injection Filter: POST data blocked');
                return $this->handleSQLInjectionAttempt($request, 'POST');
            }
        }

        try {
            $contentType = $request->getHeaderLine('Content-Type');
            if (strpos($contentType, 'application/json') !== false) {
                $json = $request->getJSON(true);
                if ($json) {
                    log_message('debug', 'SQL Injection Filter: Checking JSON data: ' . json_encode($json));
                    if ($this->checkForSQLInjection($json)) {
                        log_message('info', 'SQL Injection Filter: JSON data blocked');
                        return $this->handleSQLInjectionAttempt($request, 'JSON');
                    }
                }
            }
        } catch (\CodeIgniter\HTTP\Exceptions\HTTPException $e) {
           
            $rawInput = $request->getRawInput();
            if ($rawInput) {
                log_message('debug', 'SQL Injection Filter: Checking raw input: ' . substr((string)$rawInput, 0, 200));
                if ($this->checkForSQLInjection(['raw_input' => $rawInput])) {
                    log_message('info', 'SQL Injection Filter: Raw input blocked');
                    return $this->handleSQLInjectionAttempt($request, 'RAW_INPUT');
                }
            }
        } catch (\Exception $e) {
            log_message('debug', 'SQL Injection Filter: JSON parsing error - ' . $e->getMessage());
        }

        $headers = $request->headers();
        if ($headers) {
            $ignoredHeaders = [
                'user-agent',
                'accept',
                'accept-encoding',
                'accept-language',
                'cache-control',
                'connection',
                'content-type',
                'content-length',
                'host',
                'origin',
                'referer',
                'sec-fetch-dest',
                'sec-fetch-mode',
                'sec-fetch-site',
                'sec-ch-ua',
                'sec-ch-ua-mobile',
                'sec-ch-ua-platform',
                'cookie'
            ];
            
            foreach ($headers as $name => $header) {
                if (in_array(strtolower($name), $ignoredHeaders)) {
                    continue;
                }
                
                $headerValue = is_object($header) ? $header->getValue() : $header;
                if ($this->checkForSQLInjection([$name => $headerValue])) {
                    log_message('info', 'SQL Injection Filter: Header blocked - ' . $name);
                    return $this->handleSQLInjectionAttempt($request, 'HEADER');
                }
            }
        }

        $uri = $request->getUri();
        if ($this->checkForSQLInjection(['uri' => $uri->getPath()])) {
            log_message('info', 'SQL Injection Filter: URI blocked');
            return $this->handleSQLInjectionAttempt($request, 'URI');
        }

        $cookies = $_COOKIE ?? [];
        if ($cookies) {
            log_message('debug', 'SQL Injection Filter: Checking cookies: ' . json_encode($cookies));
            if ($this->checkForSQLInjection($cookies)) {
                log_message('info', 'SQL Injection Filter: Cookies blocked');
                return $this->handleSQLInjectionAttempt($request, 'COOKIE');
            }
        }

        log_message('debug', 'SQL Injection Filter: All checks passed');
        return $request;
    }

    private function checkForSQLInjection($data)
    {
        if (empty($data)) {
            return false;
        }

        if (!is_array($data)) {
            $data = [$data];
        }
      
        foreach ($data as $key => $value) {
            log_message('debug', 'SQL Injection Filter: Checking key: ' . $key . ' = ' . (is_array($value) ? json_encode($value) : $value));
            
            if (is_array($value)) {
                if ($this->checkForSQLInjection($value)) {
                    return true;
                }
            } else {
                            
                if ($this->containsSQLInjection($value)) {
                    log_message('debug', 'SQL Injection Filter: Value blocked: ' . $value);
                    return true;
                }
            }
        }

        return false;
    }

    private function containsSQLInjection($input)
    {
        log_message('debug', 'SQL Injection Filter: containsSQLInjection called with: ' . (is_string($input) ? $input : gettype($input)));
        
        if (!is_string($input)) {
            log_message('debug', 'SQL Injection Filter: Not a string, returning false');
            return false;
        }

        if (is_numeric($input)) {
            log_message('debug', 'SQL Injection Filter: Numeric value detected, returning false: ' . $input);
            return false;
        }
       
        $decoded = urldecode($input);
        log_message('debug', 'SQL Injection Filter: After urldecode: ' . $decoded);
        
      
        $decoded = html_entity_decode($decoded, ENT_QUOTES, 'UTF-8');
        log_message('debug', 'SQL Injection Filter: After html_entity_decode: ' . $decoded);
        
       
        if (is_numeric($decoded)) {
            log_message('debug', 'SQL Injection Filter: Decoded value is numeric, returning false: ' . $decoded);
            return false;
        }
                
        foreach ($this->sqlInjectionPatterns as $index => $pattern) {
            if (preg_match($pattern, $decoded)) {
               
                log_message('debug', 'SQL Injection Filter: Pattern matched - Index: ' . $index . ' - Pattern: ' . $pattern . ' - Input: ' . $decoded);
                return true;
            }
        }

        if (strlen($decoded) > 1000) {
            log_message('debug', 'SQL Injection Filter: Input too long - Length: ' . strlen($decoded) . ' - Input: ' . substr($decoded, 0, 100) . '...');
            return true;
        }

        log_message('debug', 'SQL Injection Filter: No patterns matched, returning false');
        return false;
    }

    private function handleSQLInjectionAttempt($request, $source)
    {
        $this->logSQLInjectionAttempt($request, $source);

        $response = service('response');
        $response->setStatusCode(403, 'Forbidden');
        $response->setJSON([
            'error' => 'Acesso negado',
            'message' => 'Requisição bloqueada',
            'code' => 'USER_BLOCKED',
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        return $response;
    }

    private function logSQLInjectionAttempt($request, $source)
    {
        $logger = service('logger');
        
        $userAgent = ($request instanceof \CodeIgniter\HTTP\IncomingRequest) 
            ? $request->getUserAgent() 
            : $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        $logData = [
            'ip' => $request->getIPAddress(),
            'user_agent' => $userAgent,
            'source' => $source,
            'uri' => $request->getUri()->getPath(),
            'method' => $request->getMethod(),
            'timestamp' => date('Y-m-d H:i:s'),
            'get_data' => ($request instanceof \CodeIgniter\HTTP\IncomingRequest) ? $request->getGet() : $_GET,
            'post_data' => ($request instanceof \CodeIgniter\HTTP\IncomingRequest) ? $request->getPost() : $_POST,
            'raw_input' => ($request instanceof \CodeIgniter\HTTP\IncomingRequest) ? $request->getRawInput() : file_get_contents('php://input')
        ];

        $logger->critical('SQL Injection attempt detected', $logData);
        
        $this->saveSecurityLog($logData);
    }

    private function saveSecurityLog($data)
    {
        $logFile = WRITEPATH . 'logs/security_' . date('Y-m-d') . '.log';
        $logEntry = date('Y-m-d H:i:s') . ' - SQL Injection Attempt: ' . json_encode($data) . PHP_EOL;
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    public function sanitizeData($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeData'], $data);
        }
        
        if (!is_string($data)) {
            return $data;
        }

        $sanitized = str_replace(array_keys($this->dangerousChars), array_values($this->dangerousChars), $data);
        
        $sanitized = strip_tags($sanitized);
        
        $sanitized = htmlspecialchars($sanitized, ENT_QUOTES, 'UTF-8');
        
        return $sanitized;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-Frame-Options', 'DENY');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        
        return $response;
    }
}