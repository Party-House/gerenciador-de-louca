<?php
namespace classes;
class IndisponibilidadeSemanal {
    private $pessoa;
    private $diasDaSemana;
    private $id;
    
    public function __construct($pessoa, $diasDaSemana, $id = null) {
        $this->pessoa = $pessoa;
        $this->diasDaSemana = $diasDaSemana;
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getPessoa() {
        return $this->pessoa;
    }

    public function getDiasDaSemana() {
        return $this->diasDaSemana;
    }

    public function setPessoa($pessoa) {
        $this->pessoa = $pessoa;
    }

    public function setDiasDaSemana($diasDaSemana) {
        $this->diasDaSemana = $diasDaSemana;
    }
}
