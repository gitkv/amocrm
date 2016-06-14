<?php

namespace AmoCRM;

/**
 * Контакт
 * Одна из основных сущностей системы. Состоит из предустановленного набора полей и дополнительных, создаваемых
 * администратором аккаунта. Каждый контакт может участвовать в одной и более сделке или может быть вообще не связан
 * ни с одной. Каждый контакт может быть прикреплен к одной компании.
 * E-mail контакта и телефон используются как уникальные идентификаторы в связке с другими системами.
 * К примеру, именно в события контакта попадает информация о совершенных звонках, о e-mail-переписке.
 * Каждому контакту может быть задан ответственный для разграничения прав доступа между сотрудниками аккаунта.
 *
 * Class Contact
 * @package AmoCRM
 */
class Contact extends Entity {

    /**
     * Contact constructor.
     */
	public function __construct(){
        $this->method = ''; //метод запроса
        $this->url = ''; //url запроса
        $this->type = ''; //тип запроса
        $this->name = 'contacts'; //имя объекта запроса
        $this->data = []; //данные запроса
	}

    /**
     * Метод позволяет добавлять контакты по одному или пакетно, а также обновлять данные по уже существующим контактам.
     */
    public function set(){
        $this->method = 'POST';
        $this->url = '/private/api/v2/json/contacts/set';
        $this->type = 'add';
    }

    /**
     * 	Метод для получения списка контактов с возможностью фильтрации и постраничной выборки.
     */
    public function getList(){
        $this->method = 'GET';
        $this->url = '/private/api/v2/json/contacts/list';
        $this->type = 'list';
    }

    /**
     * Метод для получения списка связей между сделками и контактами.
     */
    public function getLinks(){
        $this->method = 'GET';
        $this->url = '/private/api/v2/json/contacts/links';
        $this->type = 'links';
    }


    /**
     * Установка параметров запроса
     */

	public function setName($value)
	{
		$this->data['name'] = $value;

		return $this;
	}

	public function setCompanyName($value)
	{
		$this->data['company_name'] = $value;

		return $this;
	}

	public function setResponsibleUserId($value)
	{
		$this->data['responsible_user_id'] = $value;

		return $this;
	}

	public function setLinkedLeadsId($value)
	{
		if (!is_array($value)) {
			$value = [$value];
		}

		$this->data['linked_leads_id'] = array_merge($this->linked_leads_id, $value);

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
