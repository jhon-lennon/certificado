<?php
require 'vendor/autoload.php'; // Certifique-se de que o PHPMailer esteja incluído corretamente
use PHPMailer\PHPMailer\PHPMailer;
function enviarEmail($email, $nome, $assunto, $texto, $arquivo){
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.titan.email'; // Servidor SMTP
$mail->SMTPAuth = true;
$mail->Username = 'contato@jhonlennoncarvalho.com'; // Seu email SMTP
$mail->Password = '99857660@Jhon'; // Sua senha SMTP
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
$mail->Port = 465;

// Configurações de email
$mail->setFrom('contato@jhonlennoncarvalho.com', 'Nome Do Remetente');
$mail->addAddress($email, $nome);
$mail->Subject = $assunto;
$mail->Body =  $texto;

// Anexar um arquivo PDF
$arquivo_pdf = 'caminho_para_seu_arquivo.pdf'; // Substitua pelo caminho do seu arquivo PDF
$mail->addAttachment( $arquivo, basename($arquivo)); // Substitua pelo nome que você deseja para o anexo

// Enviar o email
if ($mail->send()) {
    unlink($arquivo);
    return 'Email enviado com sucesso!';
} else {
    return 'Erro ao enviar o email: ' . $mail->ErrorInfo;
}
}
?>
