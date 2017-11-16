<?php

namespace classes\auxiliares;

class TwigLouca {
  private $twig;
  public $menu;

  public function __construct() {
    $loader = new \Twig_Loader_Filesystem('templates');
    $this->twig = new \Twig_Environment($loader, ['debug' => true]);
    $this->twig->addExtension(new \Twig_Extension_Debug());

    $this->menu = new Menu();
    $this->menu->adicionaItem('principal', 'Próximos Dias', 'index.php', 'index.twig');
    $this->menu->adicionaItem('disponibilidades', 'Disponibilidade', 'disponibilidades.php', 'disponibilidades.twig');
  }

  public function render($pagina, $variaveis = array()) {
    $this->menu->setAtivo($pagina);

    $variaveis['menu'] = $this->menu->getItens();

    echo($this->twig->render($this->menu->getTemplate($pagina), $variaveis));
  }
}
