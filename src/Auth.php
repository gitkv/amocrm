<?php

namespace AmoCRM;

/**
 * Авторизация
 * Для доступа к данными системы, как через интерфейсы, так и через API, необходима авторизация под пользователем 
 * аккаунта. Вся работа через API также происходит с учетом прав доступа авторизованного пользователя в аккаунте. 
 * Все методы могут быть использованы только после авторизации.
 * 
 * Class Auth
 * @package AmoCRM
 */
class Auth extends Entity
{

    /**
     * Auth constructor.
     */
    public function __construct() {
        $this->method = 'POST'; //метод запроса
        $this->url = '/private/api/auth.php?type=json'; //url запроса
        $this->type = 'auth'; //тип запроса
        $this->name = 'auth'; //имя объекта запроса
        $this->data = []; //данные запроса
    }

    /**
     * Производит авторизацию пользователя в системе.
     * @param null $login
     * @param null $key
     * @param null $api object
     * @return mixed
     */
    public function login($login=null, $key=null, $api=null){
        $this->data['USER_LOGIN'] = $login;
        $this->data['USER_HASH'] = $key;
        return $api->request(new Request($this));
    }

}
