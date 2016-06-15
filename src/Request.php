<?php

namespace AmoCRM;

/**
 * Class Request
 * @package AmoCRM
 */
class Request
{

    public $method;
    public $url;
    public $type;
    public $name;
    public $action;
    public $params;

    private $if_modified_since;
    private $object;

    /**
     * Request constructor.
     * @param null $object
     */
    public function __construct($object = null) {
        $this->method = $object->method;
        $this->url = $object->url;
        $this->type = $object->type;
        $this->name = $object->name;
        $this->id = $object->id;
        $this->object = $object->data;
        
        switch ($object->method) {
            case 'GET':
                $this->createGetRequest();
                break;
            case 'POST':
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

    private function createInfoRequest()
    {
        $this->url = 'v2/json/accounts/current';
    }

    /**
     * генератор GET запроса
     */
    private function createGetRequest() {
        $this->url = 'v2/json/' . $this->object[0] . '/' . $this->object[1];
        $this->url .= (count($this->params) ? '?' . http_build_query($this->params) : '');
    }

    /**
     * генератор POST запроса
     */
    private function createPostRequest() {
        if($this->type == 'auth'){
            $this->params = $this->object;
        }
        else {
            if (!is_array($this->object)) {
                $this->object = [$this->object];
            }

            $object_name = $this->name;
            $url_method_name = $this->url;
            $id = $this->id;

            $action = (isset($id)) ? 'update' : 'add';
            $params = [];
            $params['request'][$object_name][$action] = $this->object;

            $this->action = $action;
            $this->url = $url_method_name;
            $this->params = $params;
        }
    }
}
