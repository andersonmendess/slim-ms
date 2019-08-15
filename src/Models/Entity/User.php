<?php
namespace App\Models\Entity;

/**
 * @Entity @Table(name="users")
 **/
class User {

    /**
    * @var int
    * @Id @Column(type="integer") 
    * @GeneratedValue
    */
    public $id;

    /**
    * @var string
    * @Column(type="string") 
    */
    public $name;

    /**
    * @var string
    * @Column(type="string") 
    */
    public $email;

    /**
    * @var string
    * @Column(type="string") 
    */
    public $password;


    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function fromArr($arr) {
        $this->name = $arr['name'];
        $this->email = $arr['email'];
        $this->password = $arr['password'];
    }
}