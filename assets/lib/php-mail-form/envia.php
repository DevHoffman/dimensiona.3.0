<?php

require_once "PHPMailerAutoload.php"; // Defina o caminho correto do arquivo class.phpmailer.php

$mail = new PHPMailer();

$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "smtp.comunicabrasil.net.br"; // Seu endereço de host SMTP
$mail->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
$mail->Port = 25; // Porta de comunicação SMTP - Mantenha o valor "587"
$mail->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
$mail->SMTPAutoTLS = false; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
$mail->Username = 'naoresponda@comunicabrasil.net.br'; // Conta de email existente e ativa em seu domínio
$mail->Password = 'Nao@123456@'; // Senha da sua conta de email

$mail->Sender = "naoresponda@comunicabrasil.net.br"; // Conta de email existente e ativa em seu domínio
$mail->From = "naoresponda@comunicabrasil.net.br"; // Sua conta de email que será remetente da mensagem
$mail->FromName = "Fale Com a Gerência - Intranet"; // Nome da conta de email

$mail->AddAddress('faroc@comunicabrasil.net.br'); // Define qual conta de email receberá a mensagem

$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

$mail->Subject  = "Formulário de Contato Intranet"; // Assunto da mensagem

$mail->Body .= " Mensagem: ".nl2br($_POST['mensagem']); // Texto da mensagem

$enviado = $mail->Send();

$mail->ClearAllRecipients();


if ($enviado) {
        
  echo "E-mail encaminhado para a gerência, agora é só aguardar o retorno ;D.";

} else {
  
  echo "Não foi possível encaminhar seu email, <br />Detalhes do erro: " . $mail->ErrorInfo;

}

header('location: /index.php/fale-com-a-gerencia/');
exit;

?>