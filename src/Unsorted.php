<?php

namespace AmoCRM;

class Unsorted extends Entity
{
	public $source; //Название источника заявки
	public $source_uid; //Уникальный идентификатор заявки
	public $date_create; //Дата заявки
    public $source_data; //Данные заявки (зависят от категории)

	private $tags_array;

	public function __construct()
	{
		$this->key_name = 'unsorted';
		$this->url_name = $this->key_name;
//		$this->custom_fields = [];
//		$this->tags_array = [];
	}

    /**
     * @param mixed $source
     */
    public function setSource($source) {
        $this->source = $source;

        return $this;
    }

    /**
     * @param mixed $source_uid
     */
    public function setSourceUid($source_uid) {
        $this->source_uid = $source_uid;

        return $this;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create) {
        $this->date_create = $date_create;

        return $this;
    }

    /**
     * @param array $source_data
     */
    public function setSourceData($source_data) {
        $this->source_data = $source_data;

        return $this;


        /*$this->source_data = [
            'form_id'=>NULL,
            'form_type'=>1,
            'from'=>NULL,
            'form_name'=>'',
            'date'=>'',
            'origin'=>[
                'ip'=>'',
                'datetime'=>'',
                'referer'=>'',
            ],
            'data'=>'',
        ];*/
    }
}
