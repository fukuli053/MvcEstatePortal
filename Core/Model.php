<?php

namespace Core;

class Model
{
    protected $_db, $_table, $_modelName, $_softDelete = false, $_validates = true, $_validationErrors = [];
    public $id;

    public function __construct($table)
    {
        $this->_db = DB::getInstance();
        $this->_table = $table;
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
    }

    public function get_columns()
    {
        return $this->_db->getColumns($this->_table);
    }

    public function find($params = [])
    {
        $params = $this->_softDeleteParams($params);
        $resultsQuery = $this->_db->find($this->_table, $params, get_class($this));
        if(!$resultsQuery) return [];
        return $resultsQuery;
    }

    public function findFirst($params = [])
    {
        $params = $this->_softDeleteParams($params);
        $resultsQuery = $this->_db->findFirst($this->_table, $params, get_class($this));
        return $resultsQuery;
    }

    public function findById($id)
    {
        return $this->findFirst([
            'conditions' => 'id = ?',
            'bind'       => [$id]
        ]);
    }

    protected function _softDeleteParams($params){
        if($this->_softDelete){
            if(array_key_exists("conditions", $params)){
                if(is_array($params['conditions'])){
                    $params['conditions'][] = "deleted != 1";
                }else{
                    $params['conditions'] .= "AND deleted != 1"; 
                }
            }else{
                $params["conditions"] = "deleted != 1";
            }
        }
        return $params;
    }

    public function save()
    {
        $this->validator();
        if($this->_validates){
            $this->beforeSave();
            $fields = Helpers::getObjectProperties($this);
            //determinate whether to isnert or update
            if (property_exists($this, 'id') && $this->id != '') {
                $save = $this->update($this->id, $fields);
                $this->afterSave();
                return $save;
            } else {
                $save = $this->insert($fields);
                $this->afterSave();
                return $save;
            }
        }
        return false;
    }

    public function insert($fields)
    {
        if (empty($fields)) {
            return false;
        }
        return $this->_db->insert($this->_table, $fields);
    }

    public function update($id, $fields)
    {
        if (empty($id) || empty($fields)) {
            return false;
        }
        return $this->_db->update($this->_table, $id, $fields);
    }

    public function delete($id = '')
    {
        if ($id == '' && $this->id == '') {
            return false;
        }
        $id = ($id == '') ? $this->id : $id;
        if ($this->_softDelete) {
            return $this->update($id, ['deleted' => 1]);
        }
        return $this->_db->delete($this->_table, $id);
    }

    public function query($sql, $bind = [])
    {
        return $this->_db->query($sql, $bind);
    }

    public function data()
    {
        $data = new stdClass();
        foreach (Helpers::getObjectProperties($this) as $column) {
            $data->column =  $value;
        }
        return $data;
    }

    public function assign($params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (property_exists($this,$key)) {
                    $this->$key = $value;
                }
            }
            return true;
        }
        return false;
    }

    protected function populateObjData($result)
    {
        foreach ($result as $key => $val) {
            $this->$key = $val;
        }
    }

    public function validator(){}

    public function runValidation($validator)
    {
        $key = $validator->field;
        if (!$validator->success) {
            $this->_validates = false;
            $this->_validationErrors[$key] = $validator->message; 
        }
    }

    public function getErrorMessages()
    {
        return $this->_validationErrors;
    }

    public function validationPasses()
    {
        return $this->_validates;
    }

    public function addErrorMessage($field, $message)
    {
        $this->_validates = false;
        $this->_validationErrors[$field] = $message;
    }

    public function beforeSave()
    {
        
    }

    public function afterSave()
    {
        
    }

}
