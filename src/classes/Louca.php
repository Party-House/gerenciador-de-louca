<?php
namespace classes;

use classes\auxiliares\Data;
use classes\pessoa\Pessoa;
class Louca {
    private $pessoa;
    private $data;
    private $id;
    
    public function __construct(Pessoa $pessoa, Data $data, int $id = null) {
        $this->pessoa = $pessoa;
        $this->data = $data;
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getPessoa(): Pessoa {
        return $this->pessoa;
    }

    public function getData(): Data {
        return $this->data;
    }

    public function setPessoa(Pessoa $pessoa) {
        $this->pessoa = $pessoa;
    }

    public function setData(Data $data) {
        $this->data = $data;
    }
}
