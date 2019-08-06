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

        if (!$name && !is_string($name)) {
            throw new \InvalidArgumentException("Book name is required", 400);
        }

        $this->name = $name;
        return $this;
    }

    public function setAuthor($author) {

        if (!$author && !is_string($author)) {
            throw new \InvalidArgumentException("Author is required", 400);
        }

        $this->author = $author;
        return $this;
    }

    public function getValues() {
        return get_object_vars($this);
    }

}