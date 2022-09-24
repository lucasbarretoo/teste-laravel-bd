<?php


if(!function_exists('validaCPF')) {
    function validaCPF($cpf = null) : Bool{

        // Verifica se um número foi informado

        if (empty($cpf)) {

            return false;
        }

        // Elimina a mascara

        $cpf = preg_replace("/[^0-9]/", "", $cpf);

        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        $repeticoes = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999');

        // Verifica se nenhuma das sequências invalidas abaixo foi digitada. Caso afirmativo, retorna falso

        if (in_array($cpf, $repeticoes)) {

            return false;
        } else {

            // Calcula os digitos verificadores para verificar se o CPF é válido

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {

                    $d += $cpf[$c] * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf[$c] != $d) {

                    return false;
                }
            }

            return true;
        }
    }
}
