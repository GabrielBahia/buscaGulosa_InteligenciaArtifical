<?php
require 'No.php';

// Função que constrói o caminho até o estado final a partir de um nó da árvore de busca
function constroi_caminho($no)
{
    // Inicializamos o caminho com o estado do nó atual
    $caminho = array($no->getQuadradoMagico());

    // Enquanto o nó atual tiver um nó pai, adicionamos o estado do nó pai ao início do caminho
    while ($no->getPai()) {
        $no = $no->getPai();
        array_unshift($caminho, $no->getQuadradoMagico());
    }

    return $caminho;
}

function obtem_valor_correto($i, $j)
{
    // Verificamos a posição da linha e da coluna da posição atual
    // e retornamos o algarismo que deveria estar na posição de acordo com a regra de soma 15
    if ($i == 0) {
        if ($j == 0) {
            return 4;
        } elseif ($j == 1) {
            return 3;
        } elseif ($j == 2) {
            return 8;
        }
    } elseif ($i == 1) {
        if ($j == 0) {
            return 9;
        } elseif ($j == 1) {
            return 5;
        } elseif ($j == 2) {
            return 1;
        }
    } elseif ($i == 2) {
        if ($j == 0) {
            return 2;
        } elseif ($j == 1) {
            return 7;
        } elseif ($j == 2) {
            return 6;
        }
    }
}

// Função da Heuristica
// Heurística = Pontuar os estados que estão com seu algarismo no local correto
function calcula_pontuacao($quad)
{
    $pontuacao = 0;

    // Para cada posição do quadrado mágico
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            // Se a posição atual do array quad existe e o algarismo na posição atual estiver correto, adicionamos 1 ponto à pontuação
            if ($quad[$i][$j] == obtem_valor_correto($i, $j)) {
                $pontuacao++;
            }
        }
    }

    return $pontuacao;
}

function obtem_proxima_posicao($quad)
{
    // Percorremos o quadrado mágico procurando a próxima posição vazia
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if (empty($quad[$i][$j])) {
                return array($i, $j);
            }
        }
    }
    // Se não houver mais posições vazias, retornamos null
    return null;
}

function expande(No $no)
{
    $filhos = array();

    // Verificamos em qual posição do quadrado mágico o próximo algarismo deve ser inserido
    $proxima_posicao = obtem_proxima_posicao($no->getQuadradoMagico());
    $i = $proxima_posicao[0];
    $j = $proxima_posicao[1];

    // Geramos os filhos inserindo cada um dos algarismos possíveis na posição atual do quadrado mágico
    for ($k = 1; $k <= 9; $k++) {
        // Criamos um novo quadrado mágico copiando o quadrado mágico do nó atual
        $quad_filho = $no->getQuadradoMagico();

        // Inserimos o algarismo k na posição atual do quadrado mágico
        $quad_filho[$i][$j] = $k;

        // Calculamos a pontuação do quadrado mágico com o algarismo inserido
        $pontuacao = calcula_pontuacao($quad_filho);

        // Criamos um novo nó com o quadrado mágico atualizado, com a pontuação calculada e com seu pai
        $filho = new No($quad_filho, $pontuacao, $no);

        // Adicionamos o novo nó à lista de filhos
        $filhos[] = $filho;
    }
    return $filhos;
}

function busca_gulosa($quadradoMagico_inicial)
{
    // Criamos o nó raiz da árvore de busca
    $raiz = new No($quadradoMagico_inicial, 0, 0);

    // Inicializamos as listas de nós abertos, fechados a fila de regras
    $abertos = array($raiz);
    $fechados = array();

    // Enquanto o quadrado magico não estiver com todos os algarismos preenchidos
    while (true) {
        // Selecionamos o nó com a maior pontuação da lista de nós abertos
        usort($abertos, function ($n1, $n2) {
            if ($n1->getPontuacao() > $n2->getPontuacao()) {
                return -1;
            } else if ($n1->getPontuacao() < $n2->getPontuacao()) {
                return 1;
            } else {
                return 0;
            }
        });
        // Pega o primeiro elemento do array ordenado em ordem decrescente
        $no_atual = array_shift($abertos);

        // Verificamos se o estado atual é o estado final (quadrado mágico completo)
        if ($no_atual->quadrado_magico_soma_quinze()) {
            // Se for, retornamos o caminho até o estado final
            return constroi_caminho($no_atual);
        }

        // Adicionamos o nó atual à lista de nós fechados
        array_push($fechados, $no_atual);

        // Expandimos o nó atual, gerando seus sucessores
        $sucessores = expande($no_atual);

        foreach ($sucessores as $sucessor) {
            // Verificamos se o sucessor já está na lista de nós abertos ou fechados
            if (!in_array($sucessor, $abertos) && !in_array($sucessor, $fechados)) {
                // Se não estiver, adicionamos à lista de nós abertos
                array_push($abertos, $sucessor);
            }
        }
    }

    // Se a lista de nós abertos estiver vazia, significa que não foi encontrado um caminho até o estado final
    return null;
}

function exibe_estado($estado) {
    for ($i = 0; $i < 3; $i++) {
      for ($j = 0; $j < 3; $j++) {
        echo $estado[$i][$j] . " ";
      }
      echo "\n";
    }
    echo "\n";
    echo "|" . "\n";
    echo "V" . "\n";
    echo "\n";
  }


$quadradoMagico_inicial = array(
    array(0, 0, 0),
    array(0, 0, 0),
    array(0, 0, 0)
);

$caminho = busca_gulosa($quadradoMagico_inicial);

if ($caminho) {
    // Se foi encontrado um caminho até o estado final, exibimos o caminho
    echo "Caminho encontrado:\n";
    foreach ($caminho as $estado) {
        exibe_estado($estado);
    }
} else {
    // Se não foi encontrado um caminho até o estado final, exibimos uma mensagem de erro
    echo "Não foi possível encontrar um caminho até o estado final.\n";
}
