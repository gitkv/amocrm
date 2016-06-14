<?php

namespace AmoCRM;

class ApiAmoCrm
{
    private $domain;
    private $debug;
    private $errors;

    public $login;
    public $key;
    public $config;
    public $result;
    public $last_insert_id;

    public function __construct($debug = false)
    {
        $this->debug = $debug;

        $config_dir = __DIR__ . '/../config/';
        $file_config = $config_dir . 'config.php';

        if (!is_readable($config_dir) || !is_writable($config_dir)) {
            throw new \Exception('Директория "config" должна быть доступна для чтения и записи');
        }

        if (!file_exists($file_config)) {
            throw new \Exception('Отсутсвует файл с конфигурацией');
        }

        $config = trim(file_get_contents($file_config));

        if (empty($config)) {
            throw new \Exception('Файл с конфигурацией пуст');
        }

        if ($this->debug) {
            $this->errors = @json_decode(trim(file_get_contents($config_dir . 'errors.json')));
        }
        
        $this->config = include $file_config;


        if (empty($this->config['Domain'])) {
            throw new \Exception('Не указан домен');
        }

        if (empty($this->config['Login'])) {
            throw new \Exception('Не указан логин');
        }
        
        if (empty($this->config['Key'])) {
            throw new \Exception('Не указан ключ');
        }
        
        $this->domain = $this->config['Domain'];
        $this->login = $this->config['Login'];
        $this->key = $this->config['Key'];


        $auth = new Auth();
        $auth->login($this->login, $this->key, $this);


        //$this->request(new Request('AUTH', $this));
    }

    public function request(Request $request)
    {
        $url = 'https://' . $this->domain . '.amocrm.ru' . $request->url;

//        print '<pre>';
//        print_r($request);
//        die();

        $headers = ['Content-Type: application/json'];
        if ($date = $request->getIfModifiedSince()) {
            $headers[] = 'IF-MODIFIED-SINCE: ' . $date;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/../config/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/../config/cookie.txt');

        if ($request->method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->params));
        }

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception($error);
        }

        $this->result = json_decode($result);

        if (floor($info['http_code'] / 100) >= 3) {
            if (!$this->debug) {
                $message = $this->result->response->error;
            }
            else {
                $error = (isset($this->result->response->error)) ? $this->result->response->error : '';

                $error_code = (isset($this->result->response->error_code)) ? $this->result->response->error_code : '';

                $description = ($error && $error_code && isset($this->errors->{$error_code})) ? $this->errors->{$error_code} : '';

                $response = (isset($this->result->response->error)) ? $this->result->response->error : '';

                $message = json_encode([
                    'http_code' => $info['http_code'],
                    'response' => $response,
                    'description' => $description
                ], JSON_UNESCAPED_UNICODE);
            }

            throw new \Exception($message);
        }

        $this->result = isset($this->result->response) ? $this->result->response : false;
        $this->last_insert_id = ($request->method == 'POST' && isset($this->result->{$request->type}->{$request->action}[0]->id))
            ? $this->result->{$request->type}->{$request->action}[0]->id
            : false;

        return $this;
    }
}
