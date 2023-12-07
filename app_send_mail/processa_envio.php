<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Mensagem {
    // Propriedades privadas
    private $para = array();
    private $assunto = null;
    private $mensagem = null;
    public $status = array('codigo_status' => null, 'descricao_status' => '');

    // Métodos mágicos para acessar propriedades privadas
    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    // Validação da mensagem antes de enviar
    public function mensagemValida()
    {
        // Verificar se os e-mails são válidos
        foreach ($this->para as $email) {
            if (!$this->validarEmail($email)) {
                $this->status['codigo_status'] = 2;
                $this->status['descricao_status'] = "Pelo menos um e-mail é inválido";
                return false;
            }
        }

        // Verificar se os campos obrigatórios estão preenchidos
        if (!empty($this->assunto) && !empty($this->mensagem)) {
            return true;
        } else {
            $this->status['codigo_status'] = 2;
            $this->status['descricao_status'] = "Assunto e mensagem são obrigatórios";
            return false;
        }
    }

    // Função privada para validar o formato do e-mail
    private function validarEmail($email) {
        $padrao = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return preg_match($padrao, $email);
    }

    // Enviar e-mail usando PHPMailer
    public function enviarEmail() {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kohakoprojects@gmail.com';
            $mail->Password = 'peck wgxm geyo vdnm';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Configurações do e-mail
            $mail->setFrom('kohakoprojects@gmail.com', 'Kohako Dev');
            foreach ($this->para as $email) {
                $mail->addAddress($email);
            }
            $mail->addReplyTo('kohakoprojects@gmail.com', 'Information');

            // Configurações do conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = $this->__get('assunto');
            $mail->Body    = $this->__get('mensagem');
            $mail->AltBody = 'É preciso usar um cliente que suporte HTML para ter acesso total a essa mensagem!';

            // Enviar e-mail
            $mail->send();

            // Atualizar status de sucesso
            $this->status['codigo_status'] = 1;
            $this->status['descricao_status'] = "Mensagem enviada!";
        } catch (Exception $e) {
            // Atualizar status de erro
            $this->status['codigo_status'] = 2;
            $this->status['descricao_status'] = "Mensagem não enviada! Detalhes do erro: " . $e->getMessage();
        }
    }
}

// Instanciar a classe Mensagem
$mensagem = new Mensagem();

// Atribuir valores com base nos dados do formulário
$mensagem->__set('para', explode(',', $_POST['para']));
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

// Enviar e-mail e exibir resultados na página
$mensagem->enviarEmail();
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>App Mail Send</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="flex flex-col pt-[20%] md:pt-[10%] md:pt-[5%] lg:pt-[2.5%] items-center bg-zinc-200 h-screen overflow-hidden">
            <div class="flex flex-col items-center text-zinc-800">
                <img class="block w-[80%] md:w-[35%] lg:w-[30%] object-contain" src="Assets/logo.png">
                <h2 class="font-bold uppercase text-8xl md:text-7xl lg:text-5xl my-[2%]">Send Mail</h2>
                <p class="text-5xl md:text-3xl lg:text-2xl font-medium">Seu app de envio de e-mails particular!</p>
            </div>
            <div class="flex flex-col items-center mt-[15%] lg:mt-[8%]">
                <?php
                switch ($mensagem->status['codigo_status']) {
                    case 1:
                        echo '<div class="pt-[20%] lg:pt-[5%]">
                            <h1 class="text-[10em] md:text-9xl text-green-600 font-bold lg:text-7xl uppercase">Sucesso!</h1>
                            <p class="text-6xl md:text-3xl lg:text-3xl font-medium mb-[25%]">' . $mensagem->status['descricao_status'] . '</p>
                            <a href="index.php" class="bg-green-600 items-center font-bold px-[12%] py-[3%] lg:mt-[1%] lg:px-[12%] uppercase text-4xl md:text-3xl rounded-sm lg:text-xl tracking-wider text-zinc-200 pointer cursor-pointer">Voltar</a>
                        </div>';
                        break;
                    case 2:
                        echo '<div class="pt-[20%] lg:pt-[5%]">
                            <h1 class="text-[10em] md:text-9xl text-red-500 font-bold lg:text-7xl uppercase">Ops...</h1>
                            <p class="text-6xl md:text-3xl lg:text-3xl font-medium mb-[25%]">'. $mensagem->status['descricao_status'] .'</p>
                            <a href="index.php" class="bg-red-500 items-center font-bold px-[12%] py-[3%] lg:mt-[1%] lg:px-[12%] uppercase text-4xl md:text-3xl rounded-sm lg:text-xl tracking-wider text-zinc-200 pointer cursor-pointer">Voltar</a>
                        </div>';
                        break;
                }
                ?>
            </div>
        </div>
    </body>
</html>
