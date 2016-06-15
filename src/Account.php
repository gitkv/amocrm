<?php

namespace AmoCRM;

/**
 * Аккаунт
 * Через API вы можете получить необходимую информацию по аккаунту: название, оплаченный период, пользователи аккаунта
 * и их права, справочники дополнительных полей контактов и сделок, справочник статусов сделок, справочник типов
 * событий, справочник типов задач и другие параметры аккаунта.
 * 
 * Class Account
 * @package AmoCRM
 */
class Account extends Entity
{

    /**
     * Account constructor.
     * @param $api
     */
    public function __construct() {
        $this->method = 'GET'; //метод запроса
        $this->url = '/private/api/v2/json/accounts/current'; //url запроса
        $this->type = 'accounts'; //тип запроса
        $this->name = 'current'; //имя объекта запроса
        $this->data = []; //данные запроса
    }

    /**
     * Получение информации по аккаунту в котором произведена авторизация.
     * @param $api
     * @return mixed
     */
    public function getInfo($api){
        return $api->request(new Request($this));
    }

}
