<?php
class Codigo
{
    public static function Ticket($db,$table,$col,$email){
$count = 0;
$Codigo = null;
$numTicket = 0;
switch ($table) {
    case 'ticket':
        do{
            $arrayTicket=range(1,rand(1,10));
            foreach($arrayTicket as $val){
                $numTicket .= $val;
            }
            $where = " WHERE Ticket = :Ticket";
            $response = $db->select1("Ticket",$table,$where,array('Ticket' => (string)$numTicket));
            if (is_array($response)) {
                $response = $response['results'];
                if (0 < count($response)) {
                    $count = count($response);
                }else{
                    $count=0;
                    return $numTicket;
                }
            } else {
            $count=0;
                return $response;
            }
                }while(0 < $count);
        break;
    
    case 'compras':
        do{
            $arrayTicket=range(1,rand(1,10));
            foreach($arrayTicket as $val){
                $numTicket .= $val;
            }
            $where = " WHERE Year = :Year AND Email = :Email";
            $array = array(
'Year' => date("Y"), //Vamos a obtener registros de acuerdo al año del sistema
'Email' =>$email
            );
            $response = $db->select1("Codigo",$table,$where,$array);
            if (is_array($response)) {
                $response = $response['results'];
                if (0 < count($response)) {
                    $count = count($response);
                }else{
                    $count=0;
                    return $numTicket;
                }
            } else {
            $count=0;
                return $response;
            }
                }while(0 < $count);
        break;
}

}
}
?>