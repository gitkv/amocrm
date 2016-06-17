<?php

namespace AmoCRM;

class Entity
{
    public $method; //метод запроса (POST, GET...)
    public $url; //url запроса
    public $type = 'request'; //тип запроса (request || auth)
    public $name; //имя объекта запроса
    
    public $id; //id последнего запроса
    public $last_modified; //дата последнего запроса
    public $category; //категория запроса (для неразобранного) (forms | mail | sip)
    
    public $data; //данные запроса

    /**
     * @param $id
     * @param $last_modified
     * @return $this
     */
    public function setUpdate($id, $last_modified)
    {
        $this->data['id'] = $id;
        $this->data['last_modified'] = $last_modified;

        return $this;
    }
}
