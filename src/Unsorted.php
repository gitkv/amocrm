<?php

namespace AmoCRM;

class Unsorted extends Entity
{
	public $source; //Название источника заявки
	public $source_uid; //Уникальный идентификатор заявки
	public $date_create; //Дата заявки
    public $source_data; //Данные заявки (зависят от категории)

	public function __construct()
	{
		$this->object_name = 'unsorted';
		$this->resetMethodUrl();
	}

    /**
     * так как в api url отличается от остальных методов, то переопределяем
     * @return string
     */
    public function getMethodBaseUrl(){
        return 'api/';
    }
    
    public function setSource($source) {
        $this->source = $source;

        return $this;
    }
    
    public function setSourceUid($source_uid) {
        $this->source_uid = $source_uid;

        return $this;
    }
    
    public function setDateCreate($date_create) {
        $this->date_create = $date_create;

        return $this;
    }
    
    public function setSourceData($source_data) {
        $this->source_data = $source_data;

        return $this;
    }
}
