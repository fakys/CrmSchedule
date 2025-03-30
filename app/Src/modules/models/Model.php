<?php
namespace App\Src\modules\models;

class Model{
    protected $data;
    protected $fields;
    protected $validate_rules;
    public function __construct($data = [])
    {
     $this->data = $data;
     $this->fields = $this->fields();
     $this->validate_rules = $this->rules();
    }
    protected function getValidateRules(){
        return $this->validate_rules;
    }

    protected function checkBool()
    {
        $bool_field = $this->boolean();
        $data = $this->getData();
        foreach ($bool_field as $field){
            if(isset($data[$field]) && $data[$field] === 'true'){
                $this->data[$field] = true;
            }else{
                $this->data[$field] = false;
            }
        }
    }

    public function getData()
    {
        $new_date = [];
        foreach($this->data as $key => $value) {
            if (in_array($key, $this->fields)) {
                $new_date[$key] = $value;
            }
        }
        return $new_date;
    }
    public function __get($name){
        if(isset($this->data[$name])){
            return $this->data[$name];
        }
        return null;
    }

    public function __set($name, $data){
        $this->data[$name] = $data;
    }

    public function load($data)
    {
        $this->data = $data;
        $this->checkBool();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
