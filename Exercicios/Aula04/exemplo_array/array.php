<?php
    //criar função que gere e retorne um array com 10 numeros aleatòrios.

    function gera_aleatorio(){
        //criação de um vetor vazio 
        $vetor = array();
        //laço for 10x
        for ($i=0; $i <= 9; $i++) {
        //adicionar 10 numeros aleatórios
        $vetor[$i] = rand (0,1000);
        }

        //retornar vetor

        return $vetor;

    }

    //$recebe_vetor = gera_aleatorio();

    print_r($recebe_vetor);

?>