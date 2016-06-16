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

    public function setIfModifiedSince($if_modified_since) {
        $this->if_modified_since = $if_modified_since;
    }

    public function getIfModifiedSince() {
        return empty($this->if_modified_since) ? false : $this->if_modified_since;
    }

    /**
     * генератор GET запроса
     */
    private function createGetRequest() {
        $this->url .= (count($this->object) ? '?' . http_build_query($this->object) : '');
    }

    /**
     * генератор POST запроса
     */
    private function createPostRequest() {
        
        switch ($this->type){
            case 'auth':

                $this->params = $this->object;
                break;

            case 'request':

                if (!is_array($this->object)) {
                    $this->object = [$this->object];
                }

                $action = (isset($this->object['id'])) ? 'update' : 'add';
                $params = [];
                $params['request'][$this->name][$action][] = $this->object;

                $this->action = $action;
                $this->params = $params;
                break;

        }
    }
}
