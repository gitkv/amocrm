<?php

namespace AmoCRM;

/**
 * Неразобранное
 * Новая сущность системы. В состояние Неразобранное попадают все обращения из интеграций: почты, телефонии,
 * форм для сайта, которые ещё не были обработаны пользователем (создана сделка или контакт). Пользователь может
 * принять неразобранное - в данном случае будет создана сделка, а так же, при возможности, контакт и компания,
 * если соответствующая информация есть в заявке, либо отклонить его.
 *
 * Class Unsorted
 * @package AmoCRM
 */
class Unsorted extends Entity
{

    /**
     * Unsorted constructor.
     * @param $login
     * @param $key
     */
    public function __construct($login, $key) {
        $this->login = $login; //логин
        $this->key = $key; //ключ
        $this->method = ''; //метод запроса
        $this->url = ''; //url запроса
        $this->name = 'unsorted'; //имя объекта запроса
        $this->data = []; //данные запроса
    }

    /**
     * 	Метод для получения списка неразобранного с возможностью фильтрации и постраничной выборки.
     */
    public function getList(){
        $this->method = 'GET';
        $this->url = '/api/unsorted/list/?login='.$this->login.'&api_key='.$this->key;
    }

    /**
     * Метод для получения аггрегированной информации о принятых и отклонённых заявках.
     */
    public function getAllSummary(){
        $this->method = 'GET';
        $this->url = '/api/unsorted/get_all_summary/?login='.$this->login.'&api_key='.$this->key;
    }

    /**
     * Метод позволяет переводить из неразобранного в принятые заявки по одной или пакетно.
     */
    public function accept(){
        $this->method = 'POST';
        $this->url = '/api/unsorted/accept/?login='.$this->login.'&api_key='.$this->key;
    }

    /**
     * Метод позволяет переводить из неразобранного в отклонённые заявки по одной или пакетно.
     */
    public function decline(){
        $this->method = 'POST';
        $this->url = '/api/unsorted/decline/?login='.$this->login.'&api_key='.$this->key;
    }

    /**
     * Метод позволяет добавлять неразобранное по одному или пакетно.
     */
    public function add(){
        $this->method = 'POST';
        $this->url = '/api/unsorted/add/?login='.$this->login.'&api_key='.$this->key;
    }


    /**
     * Установка параметров запроса
     */

    public function setSource($source) {
        $this->data['source'] = $source;

        return $this;
    }

    public function setSourceUid($source_uid) {
        $this->data['source_uid'] = $source_uid;

        return $this;
    }

    public function setDateCreate($date_create) {
        $this->data['date_create'] = $date_create;

        return $this;
    }

    public function setSourceData($source_data) {
        $this->data['source_data'] = $source_data;

        return $this;
    }
}
