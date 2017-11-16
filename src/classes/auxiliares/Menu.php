<?php

namespace classes\auxiliares;

class Menu {
  private $itens;

  public function adicionaItem(string $alias, string $nome, string $link, string $template) {
    $item = [
      'nome' => $nome,
      'link' => $link,
      'template' => $template,
      'ativo' => false
    ];

    $this->itens[$alias] = $item;
  }

  public function setAtivo(string $alias) {
    $this->itens[$alias]['ativo'] = true;
  }

  public function getItens(): array {
    return $this->itens;
  }

  public function getTemplate(string $alias): string {
    return $this->itens[$alias]['template'];
  }
}
