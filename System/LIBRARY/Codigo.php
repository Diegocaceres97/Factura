<?php
class Codigo
{
    public static function Ticket($db,$table){
$count = 0;
$numTicket = 0;
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
}
}
?>