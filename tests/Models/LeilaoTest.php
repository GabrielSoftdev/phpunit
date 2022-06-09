<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\{Lance, Leilao, Usuario};
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $leilao = new Leilao('Variante');
        $ana = new Usuario('Ana');


        $leilao->recebeLance(new Lance($ana, 100));
        $leilao->recebeLance(new Lance($ana, 400));

        static::assertCount(1,$leilao->getLances());
        static::assertEquals(100, $leilao->getLances()[0]->getValor());
    }
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveRecebeLances(int $quantidadeLances, Leilao $leilao, array $valores)
    {
        $this->assertCount($quantidadeLances, $leilao->getLances());

        foreach ($valores as $i => $valorEsperado)
            static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
    }

    public function geraLances()
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $carlos = new Usuario('Carlos');


        $leilaoCom2Lances = new Leilao('Fiat UNO');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 100));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 200));


        $leilaoCom1Lance = new Leilao('Fusca 1972');
        $leilaoCom1Lance->recebeLance(new Lance($carlos, 100));

        return [
            '2 Lances' => [2, $leilaoCom2Lances, [$leilaoCom2Lances->getLances()[0]->getValor(), $leilaoCom2Lances->getLances()[1]->getValor()]],
            '1 Lance' => [1, $leilaoCom1Lance, [$leilaoCom1Lance->getLances()[0]->getValor()]],
        ];
    }
}
