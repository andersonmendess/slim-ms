<?php

namespace App\Models\Entity;

/**
 * @Entity @Table(name="books")
 **/
class Book {

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
    public $author;


    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

}