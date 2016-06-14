<?php

namespace AmoCRM;

class Request
{
    const AUTH = 1;
    const INFO = 2;
    const GET = 3;
    const SET = 4;

    public $post;
    public $url;
    public $type;
    public $action;
    public $params;

    private $if_modified_since;
    private $object;

    public function __construct($request_type = null, $params = null, $object = null)
    {
        $this->post = false;
        $this->params = $params;
        $this->object = $object;

        switch ($request_type) {
            case Request::AUTH:
                $this->createAuthRequest();
                break;
            case Request::INFO:
                $this->createInfoRequest();
                break;
            case Request::GET:
                $this->createGetRequest();
                break;
            case Request::SET:
                $this->createPostRequest();
                break;
        }
    }

    public function setIfModifiedSince($if_modified_since)
    {
        $this->if_modified_since = $if_modified_since;
    }

    public function getIfModifiedSince()
    {
        return empty($this->if_modified_since) ? false : $this->if_modified_since;
    }

    private function createAuthRequest()
    {
        $this->post = true;
        $this->url = 'v2/json/private/api/auth.php?type=json';

        $this->params = [
            'USER_LOGIN' => $this->params->user,
            'USER_HASH' => $this->params->key
        ];
    }

    private function createInfoRequest()
    {
        $this->url = 'v2/json/accounts/current';
    }

    private function createGetRequest()
    {
        $this->url = 'v2/json/' . $this->object[0] . '/' . $this->object[1];
        $this->url .= (count($this->params) ? '?' . http_build_query($this->params) : '');
    }

    private function createPostRequest()
    {
        if (!is_array($this->params)) {
            $this->params = [$this->params];
        }

        $object_name = $this->params[0]->object_name;
        $url_method_name = $this->params[0]->url_method_name;
        $id = $this->params[0]->id;

        $action = (isset($id)) ? 'update' : 'add';
        $params = [];
        $params['request'][$object_name][$action] = $this->params;

        $this->post = true;
        $this->type = $object_name;
        $this->action = $action;
        $this->url = $url_method_name;
        $this->params = $params;
    }
}
