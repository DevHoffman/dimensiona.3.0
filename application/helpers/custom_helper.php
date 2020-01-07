<?php
function getStatusPedidos($stts = null)
{

    $rows = [
        0 => "Cotações abertas",
        1 => "Cotações em análise do comprador",
        2 => "Cotações concluídas"
    ];

    return (isset($stts)) ? $rows[$stts] : $rows;
}

if (!function_exists('dbDateFormat')) {
    function dbDateFormat($date = NULL)
    {
        $d = explode('/', $date);
        if (is_array($d) && count($d) === 3) {
            return implode('-', array_reverse($d));
        } else {
            return false;
        }
    }
}

if (!function_exists('statusPedidoRepresentante')) {
    function statusPedidoRepresentante($status = null)
    {
        $data = [1 => "Em aberto", "Enviado para faturamento", "Aprovado", "Faturado", "Cancelado"];

        return (isset($status)) ? $data[$status] : $data;
    }
}

if (!function_exists('status_regra_venda')) {
    function status_regra_venda($regra_venda = null)
    {
        $data = [
            0 => '<a data-toggle="tooltip" title="Todos os tipos"><i class="fas fa-keyboard">&nbsp;&nbsp;<i class="fas fa-robot">&nbsp;&nbsp;<i class="fas fa-network-wired"></i></a>',
            1 => '<a data-toggle="tooltip" title="Manual" ><i class="fas fa-keyboard"></i></a>',
            2 => '<a data-toggle="tooltip" title="Automático" ><i class="fas fa-robot"></i></a>',
            3 => '<a data-toggle="tooltip" title="Manual e Automático" ><i class="fas fa-keyboard"></i>&nbsp;&nbsp;<i class="fas fa-robot"></i></a>',
            4 => '<a data-toggle="tooltip" title="Distribuidor x Distribuidor"><i class="fas fa-network-wired"></i></a>',
            5 => '<a data-toggle="tooltip" title="Distribuidor x Manual" ><i class="fas fa-network-wired"></i>&nbsp;&nbsp;<i class="fas fa-keyboard"></i></a>',
            6 => '<a data-toggle="tooltip" title="Distribuidor x Automático" ><i class="fas fa-network-wired"></i>&nbsp;&nbsp;<i class="fas fa-robot"></i></a>',
        ];

        return (isset($regra_venda)) ? $data[$regra_venda] : ''; 
    }
}

if (!function_exists('array_format')) {
    function array_format($array)
    {
        if (!isset($array[0])) {

           $arrayCopy = $array;

           unset($array);

           $array[0] = $arrayCopy;
        }

        return $array;
    }
}

function mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

if (!function_exists('dbNumberFormat')) {
    function dbNumberFormat($value = NULL)
    {
        $v = str_replace(',', '.', str_replace('.', '', $value));

        if (is_numeric($v)) {
            return floatval($v);
        } else {
            return false;
        }
    }
}


function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result, true);
}