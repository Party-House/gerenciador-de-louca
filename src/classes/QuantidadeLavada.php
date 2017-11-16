<?php
namespace classes;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuantidadeLavada
 *
 * @author wagner
 */
class QuantidadeLavada {
    private $quantidade;
    private $pessoa;
    
    public function __construct($quantidade, $pessoa) {
        $this->quantidade = $quantidade;
        $this->pessoa = $pessoa;
    }
    
    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getPessoa() {
        return $this->pessoa;
    }

    public function incrementaQuantidade() {
        $this->quantidade++;
    }
}
