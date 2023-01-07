<?php

class No
{
  private $quadradoMagico;
  private $pontuacao;
  private $pai;

  public function __construct($quadradoMagico, $pontuacao, $pai)
  {
    $this->quadradoMagico = $quadradoMagico;
    $this->pontuacao = $pontuacao;
    $this->pai = $pai;
  }

  public function getQuadradoMagico()
  {
    return $this->quadradoMagico;
  }

  public function getPontuacao()
  {
    return $this->pontuacao;
  }

  public function getPai()
  {
    return $this->pai;
  }


  function quadrado_magico_soma_quinze()
  {
    // Verificamos se as linhas, colunas e diagonais somam 15
    if (
      $this->quadradoMagico[0][0] + $this->quadradoMagico[0][1] + $this->quadradoMagico[0][2] == 15 &&
      $this->quadradoMagico[1][0] + $this->quadradoMagico[1][1] + $this->quadradoMagico[1][2] == 15 &&
      $this->quadradoMagico[2][0] + $this->quadradoMagico[2][1] + $this->quadradoMagico[2][2] == 15 &&
      $this->quadradoMagico[0][0] + $this->quadradoMagico[1][0] + $this->quadradoMagico[2][0] == 15 &&
      $this->quadradoMagico[0][1] + $this->quadradoMagico[1][1] + $this->quadradoMagico[2][1] == 15 &&
      $this->quadradoMagico[0][2] + $this->quadradoMagico[1][2] + $this->quadradoMagico[2][2] == 15 &&
      $this->quadradoMagico[0][0] + $this->quadradoMagico[1][1] + $this->quadradoMagico[2][2] == 15 &&
      $this->quadradoMagico[0][2] + $this->quadradoMagico[1][1] + $this->quadradoMagico[2][0] == 15
    ) {
      return true;
    } else {
      return false;
    }
  }

}
