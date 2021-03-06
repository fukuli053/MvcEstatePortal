<?php 

namespace App\Models;
use Core\Model;
use Core\Validators\RequiredValidator;

class Contacts extends Model {

    public $id, $user_id, $fname, $lname, $email, $telephone;
    public $deleted = 0;

    public function __construct() {
        $table = 'contacts';
        parent::__construct($table);
        $this->_softDelete = false;
    }

    public function validator()
    {
        $this->runValidation(new RequiredValidator($this, ['field' => 'fname', "message" => "Lütfen ad alanını boş bırakmayınız."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'lname', "message" => "Lütfen soyad alanını boş bırakmayınız."]));
        $this->runValidation(new RequiredValidator($this, ['field' => 'email', "message" => "Lütfen E-Posta alanını boş bırakmayınız."]));
    }

    public function findAllByUserId($user_id, $params = [])
    {
        $conditions = [
            'conditions' => 'user_id = ?',
            'bind' => [$user_id]
        ];

        $conditions = array_merge($conditions, $params);
        return $this->find($conditions);
    }

    public function FullName()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function findByIdAndUserId($contact_id, $user_id, $params=[])
    {
        $conditions = [
            'conditions' => 'id = ? AND user_id = ?',
            'bind' => [$contact_id, $user_id]
        ];
        $conditions = array_merge($conditions,$params);
        return $this->findFirst($conditions);
    }

}