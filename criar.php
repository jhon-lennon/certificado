<?php

require 'vendor/autoload.php';
require 'enviarEmail.php';

$nome = strtoupper($_POST['nome']);
$name_arquivo = 'certificado_' . str_replace(' ', '_', $_POST['nome']) . '.pdf';
$nota = str_replace('.', ',', $_POST['nota']);
$modelo = 'certificad.pdf';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0) {
        $modelo = $_FILES["pdf"]["tmp_name"];
    }
}



use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
$pdf->SetAutoPageBreak(false);
// Adicione a página do PDF existente
$pdf->setSourceFile($modelo);
$templateId = $pdf->importPage(1); // Número da página que você deseja importar (aqui, importamos a primeira página)

// Adicione uma nova página em branco com o FPDF
$pdf->AddPage();
$pdf->useTemplate($templateId, null, null, null, null, true); // O último parâmetro "true" mantém o tamanho original

// Defina a fonte e tamanho do texto
$pdf->SetFont('Times', '', 18);
$largura = $pdf->GetStringWidth($nome); // Obtém a largura do texto
$x = ($pdf->GetPageWidth() - $largura) / 2; // Calcula a posição X para centralizar
$pdf->SetX($x);
$pdf->Cell($largura, 122, $nome, 0, 1, 'C'); // 

$pdf->SetFont('Times', '', 150);
$largura = $pdf->GetStringWidth($nota); // Obtém a largura do texto
$x = ($pdf->GetPageWidth() - $largura) / 2; // Calcula a posição X para centralizar
$pdf->SetX($x);
$pdf->Cell($largura, 25, $nota, 0, 1, 'C'); // 


$pdf->SetFont('Times', '', 18);
$texto = date('d/m/Y');
$largura = $pdf->GetStringWidth($texto); // Obtém a largura do texto
$x = ($pdf->GetPageWidth() - $largura) / 2; // Calcula a posição X para centralizar
$pdf->SetX($x);
$pdf->Cell($largura, 46, $texto, 0, 1, 'C'); // 
$pdf->Output($name_arquivo, 'F');
$pdf->Output($name_arquivo, 'D');

if (isset($_POST['email']) && file_exists($name_arquivo)) {

    $texto = "Parabens $nome, você foi aprovado. Aqui esta seu sertificado";
    enviarEmail($_POST['email'], $nome, 'Certificado',  $texto, $name_arquivo);
}
