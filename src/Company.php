<?php

namespace AmoCRM;

/**
 * Компания
 * Полностью аналогична сущности "контакт". Состоит из предустановленного набора полей и дополнительных, создаваемых
 * администратором аккаунта. Каждая компания может участвовать в одной и более сделке или может быть вообще не
 * связана ни с одной.
 * E-mail и телефон используются как идентификаторы в связке с другими системами
 * Каждой компании может быть задан ответственный для разграничения прав доступа между сотрудниками аккаунта.
 *
 * Class Company
 * @package AmoCRM
 */
class Company extends Entity
{
	public function __construct()
	{
        $this->method = ''; //метод запроса
        $this->url = ''; //url запроса
        $this->type = ''; //тип запроса
        $this->name = 'contacts'; //имя объекта запроса
        $this->data = []; //данные запроса
	}

    /**
     * Метод позволяет добавлять компании по одной или пакетно, а также обновлять данные по уже существующим компаниям.
     */
    public function set(){
        $this->method = 'POST';
        $this->url = '/private/api/v2/json/company/set';
        $this->type = 'add';
    }

    /**
     * 	Метод для получения списка контактов с возможностью фильтрации и постраничной выборки.
     */
    public function getList(){
        $this->method = 'GET';
        $this->url = '/private/api/v2/json/company/list';
        $this->type = 'list';
    }

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

		$this->data['tags'] = implode(',', $this->tags_array);

		return $this;
	}

    public function setCustomField($id, $value, $enum = false)
    {
        $field = [
            'id' => $id,
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

	/*public function setCustomField($id, $value, $enum = false)
	{
		$field = [
			'id' => $id,
			'values' => $value
		];

		$this->data['custom_fields'][] = $field;

		return $this;




        $a = [
            "values"=>  [
                     {
                         "id"=>  "13023407",
                        "value":  "info@magicweb.com",
                        "enum":  "WORK",
                        "last_modified":  1364369762
                     }
                  ]
        ];
	}*/
}
