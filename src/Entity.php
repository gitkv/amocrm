<?php

namespace AmoCRM;

class Entity
{
    public $method; //метод запроса (POST, GET...)
    public $url; //url запроса
    public $type; //тип запроса (add, list, set...)
    public $name; //имя объекта запроса
    
    public $id; //id последнего запроса
    public $last_modified; //дата последнего запроса
    
    public $data; //данные запроса

    /**
     * @param $id
     * @param $last_modified
     * @return $this
     */
    public function setUpdate($id, $last_modified)
    {
        $this->id = $id;
        $this->last_modified = $last_modified;

        return $this;
    }
}
