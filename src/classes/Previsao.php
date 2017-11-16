<?php
namespace classes;

use classes\auxiliares\Data;
use classes\pessoa\Pessoa;
use classes\pessoa\PessoaDAO;
class Previsao {
    private $indisponibilidades;
    private $indisponibilidadesSemanais;
    private $quantidadesLavadas;
    private $pessoas;
    private $ultimaDataDoHistorico;
    
    public function __construct() {
        $indisponibilidadeDAO = new IndisponibilidadeDAO();
        $indisponibilidadeSemanalDAO = new IndisponibilidadeSemanalDAO();
        $quantidadeLavadaDAO = new QuantidadeLavadaDAO();
        $pessoaDAO = new PessoaDAO();
        $loucaDAO = new LoucaDAO();
        $this->indisponibilidades = $indisponibilidadeDAO->selecionaIndisponibilidades();
        $this->indisponibilidadesSemanais = $indisponibilidadeSemanalDAO->selecionaIndisponibilidadesSemanais();
        $this->quantidadesLavadas = $quantidadeLavadaDAO->selecionaQuantidadesLavadas();
        $this->pessoas = $pessoaDAO->selecionaPessoas();
        $this->ultimaDataDoHistorico = $loucaDAO->selecionaUltimaData();
    }

    
    /** @return Indisponibilidade[] */
    private function getIndisponibilidades() {
        return $this->indisponibilidades;
    }
    
    /** @return IndisponibilidadeSemanal[] */
    private function getIndisponibilidadesSemanais() {
        return $this->indisponibilidadesSemanais;
    }
    
    private function getQuantidadeLavada(Pessoa $pessoa): QuantidadeLavada {
        $quantidadesLavadas = $this->quantidadesLavadas;
        foreach ($quantidadesLavadas as $quantidadeLavada) {
            if ($pessoa->ehIgual($quantidadeLavada->getPessoa())) {
                return $quantidadeLavada;
            }
        }
        return new QuantidadeLavada(0, $pessoa);
    }
    
    /** @return QuantidadeLavada[] */
    private function filtraQuantidadesLavadasDasPessoas(array $quantidadesLavadas, array $pessoas) {
        $retorno = [];
        foreach ($pessoas as $pessoa) {
            $retorno[] = $this->getQuantidadeLavada($pessoa);
        }
        return $retorno;
    }
    
    /** @return QuantidadeLavada[] */
    private function getQuantidadesLavadas() {
        return $this->quantidadesLavadas;
    }

               
    private function estaDisponivel(Pessoa $pessoa, Data $data): bool {
        $diaDaSemana = $data->getDiaDaSemana();
        $indisponibilidades = $this->getIndisponibilidades();
        foreach ($indisponibilidades as $indisponibilidade) {
            if ($data != $indisponibilidade->getData()) {
                continue;
            }
            if ($pessoa->ehIgual($indisponibilidade->getPessoa())) {
                return false;
            }
        }
        
        $indisponibilidadesSemanais = $this->getIndisponibilidadesSemanais();
        foreach ($indisponibilidadesSemanais as $_indisponibilidade) {
            $diasDaSemana = $_indisponibilidade->getDiasDaSemana();
            if (!in_array($diaDaSemana, $diasDaSemana)) {
                continue;
            }
            if ($pessoa->ehIgual($_indisponibilidade->getPessoa())) {
                return false;
            }
        }
        return true;
    }
    
    public function getLoucaDoDia(Data $data): Louca {
        $pessoas = $this->pessoas;
        $pessoas = $this->filtraDisponiveis($pessoas, $data);
        $pessoas = $this->filtraPessoasComMenosLavagens($pessoas);
        usort(
            $pessoas, 
            function($a, $b) {return strcmp($a->getNome(), $b->getNome());}
        );
        $pessoaQueVaiLavar = current($pessoas);
        if ($pessoaQueVaiLavar == false) {
            $pessoaQueVaiLavar = new Pessoa("0", "Ninguém pode");
        }
        return new Louca($pessoaQueVaiLavar, $data);
    }
    
    
    private function incrementaQuantidadeLavada(Pessoa $pessoa) {
        $quantidadeLavada = $this->getQuantidadeLavada($pessoa);
        $quantidadeLavada->incrementaQuantidade();
    }
    
    public function getProximasLoucas(int $quantidade) {
        $proximasLoucas = [];
        $ontem = Data::criaOntem();
        $ultimaDataDoHistorico = $this->ultimaDataDoHistorico;
        $ultimaData = max([$ontem, $ultimaDataDoHistorico]);
        for ($i = 0; $i < $quantidade; $i++) {
            $data = Data::criaDiaSeguinte($ultimaData);
            $ultimaData = $data;
            $proximaLouca = $this->getLoucaDoDia($data);
            $this->incrementaQuantidadeLavada($proximaLouca->getPessoa());
            $proximasLoucas[] = $proximaLouca;
        }
        return $proximasLoucas;
    }
    
    /**
     * 
     * @param array $pessoas
     * @return Pessoa[]
     */
    private function filtraPessoasComMenosLavagens(array $pessoas): array {
        $quantidadesLavadas = $this->getQuantidadesLavadas();
        $quantidadesLavadas = $this->filtraQuantidadesLavadasDasPessoas($quantidadesLavadas, $pessoas);
        $algumaQuantidade = current($quantidadesLavadas);
        if ($algumaQuantidade == false) {
            return [];
        }
        $algumMinimo = array_reduce($quantidadesLavadas, function($a, $b){
            return $a->getQuantidade() < $b->getQuantidade() ? $a : $b;
        }, $algumaQuantidade);
        $valorMinimo = $algumMinimo->getQuantidade();
        $minimos = [];
        foreach ($quantidadesLavadas as $quantidadeLavada) {
            if ($quantidadeLavada->getQuantidade() == $valorMinimo) {
                $minimos[] = $quantidadeLavada->getPessoa();
            }
        }
        return $minimos;
    }
    
    /**
     * 
     * @param type $pessoas
     * @param type $data
     * @return Pessoa[]
     */
    private function filtraDisponiveis(array $pessoas, Data $data): array {
        $disponiveis = [];
        foreach ($pessoas as $pessoa) {
            if ($this->estaDisponivel($pessoa, $data)) {
                $disponiveis[] = $pessoa;
            }
        }
        return $disponiveis;
    }
}
