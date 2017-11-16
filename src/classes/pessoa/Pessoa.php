<?php
namespace classes\pessoa;
class Pessoa {
    private $id;
    private $nome;
    
    public function __construct(int $id, string $nome) {
        $this->id = $id;
        $this->nome = $nome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function ehIgual(Pessoa $pessoa) {
        return $this->getId() === $pessoa->getId();
    }
    
}
