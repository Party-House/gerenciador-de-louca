<?php
namespace classes;

use classes\auxiliares\Data;
use classes\pessoa\Pessoa;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Indisponibilidade
 *
 * @author wagner
 */
class Indisponibilidade {
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

    public function setPessoa($pessoa) {
        $this->pessoa = $pessoa;
    }

    public function setData($data) {
        $this->data = $data;
    }

}
