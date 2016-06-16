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
 * Class Lead
 * @package AmoCRM
 */
class Lead extends Entity
{
    private $tags_array;

    /**
     * Lead constructor.
     */
    public function __construct()
    {
        $this->method = ''; //метод запроса
        $this->url = ''; //url запроса
        $this->name = 'leads'; //имя объекта запроса
        $this->data = []; //данные запроса
        $this->tags_array = []; //теги
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

    public function setName($value)
    {
        $this->data['name'] = $value;

        return $this;
    }

    public function setResponsibleUserId($value)
    {
        $this->data['responsible_user_id'] = $value;

        return $this;
    }

    public function setStatusId($value)
    {
        $this->data['status_id'] = $value;

        return $this;
    }

    public function setPrice($value)
    {
        $this->data['price'] = $value;

        return $this;
    }

    public function setTags($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->tags_array = array_merge($this->tags_array, $value);
        $this->data['tags'] = implode(',', $this->tags_array);

        return $this;
    }

    public function setCustomField($name, $value, $enum = false)
    {
        $field = [
            'id' => $name,
            'values' => []
        ];

        $field_value = [];
        $field_value['value'] = $value;

        if ($enum) {
            $field_value['enum'] = $enum;
        }

        $field['values'][] = $field_value;

        $this->data['custom_fields'][] = $field;

        return $this;
    }
}
