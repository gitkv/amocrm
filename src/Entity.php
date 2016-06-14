<?php

namespace AmoCRM;

class Entity
{
    public $id;
    public $last_modified;
    public $key_name;
    public $url_method_name = 'v2/json/private/api/'; //базовый url

    public function setUpdate($id, $last_modified)
    {
        $this->id = $id;
        $this->last_modified = $last_modified;

        return $this;
    }

    /**
     * возвращает дефолтный url методов
     * @return string
     */
    public function getMethodBaseUrl(){
        return 'v2/json/private/api/';
    }

    /**
     * сбрасывает url методов на дефолтный
     */
    protected function resetMethodBaseUrl(){
        $this->url_method_name = $this->getMethodBaseUrl();
    }
}
