<?php

namespace AmoCRM;

/**
 * Сделка
 * Одна из основных сущностей системы. Состоит из предустановленного набора полей и дополнительных, создаваемых
 * администратором аккаунта. Каждая сделка может быть прикреплена к одному и более контакту или не прикреплена
 * ни к одному.
 * Каждой сделке может быть задан ответственный для разграничения прав доступа между сотрудниками аккаунта.
 * Сделка обладает статусом, который обозначает положение сделки в жизненном цикле (бизнес-процесс). Он должен
 * быть обязательно присвоен сделке. Список статусов может быть изменен в рамках аккаунта, кроме двух системных
 * конечных статусов.
 *
 * Class Task
 * @package AmoCRM
 */
class Task extends Entity
{
    //TODO
    const CALL = 1;
    const MEETING = 2;
    const LETTER = 3;

    const TYPE_CONTACT = 1; // Првязка к контакту
    const TYPE_LEAD = 2; // Привязка к сделке

    /**
     * Task constructor.
     */
    public function __construct() {
        $this->method = ''; //метод запроса
        $this->url = ''; //url запроса
        $this->name = 'leads'; //имя объекта запроса
        $this->data = []; //данные запроса
    }

    /**
     * Метод позволяет создавать новые сделки, а также обновлять информацию по уже существующим
     */
    public function set(){
        $this->method = 'POST';
        $this->url = '/private/api/v2/json/leads/set';
    }

    /**
     * Метод для получения списка сделок с возможностью фильтрации и постраничной выборки. Ограничение по возвращаемым на одной странице (offset) данным - 500 сделок.
     */
    public function getList(){
        $this->method = 'GET';
        $this->url = '/private/api/v2/json/leads/list';
    }

    /**
     * Метод для получения списка связей между сделками и контактами.
     */
    public function getLinks(){
        $this->method = 'GET';
        $this->url = '/private/api/v2/json/contacts/links';
    }


    /**
     * Установка параметров запроса
     */

    public function setElementId($value)
    {
        $this->data['element_id'] = $value;

        return $this;
    }

    public function setElementType($value)
    {
        $this->data['element_type'] = $value;

        return $this;
    }

    public function setTaskType($value)
    {
        $this->data['task_type'] = $value;

        return $this;
    }

    public function setResponsibleUserId($value)
    {
        $this->data['responsible_user_id'] = $value;

        return $this;
    }

    public function setCompleteTill($value)
    {
        $this->data['complete_till'] = $value;

        return $this;
    }

    public function setText($value)
    {
        $this->data['text'] = $value;

        return $this;
    }
}
