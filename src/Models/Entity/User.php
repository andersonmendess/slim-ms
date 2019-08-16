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
        if (!$name && !is_string($name) || empty($name)) {
            throw new \Exception("Name is required", 400);
        }

        $this->name = $name;
        return $this;
    }

    public function setEmail($email){
        if (!$email && !is_string($email) || empty($email)) {
            throw new \Exception("Email is required", 404);
        }

        $this->email = $email;
    }

    public function setPassword($password){
        if (!$password && !is_string($password) || empty($password)) {
            throw new \Exception("Password is required", 404);
        }

        $this->password = $password;
    }

    public function fromArr($arr) {
        $this->setName($arr['name']);
        $this->setEmail($arr['email']);
        $this->setPassword($arr['password']);
    }
}