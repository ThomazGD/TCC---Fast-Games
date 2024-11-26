<?php
// Inicia a sessão e conexão com o banco de dados
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('conexao.php');
// Função para atualizar os pontos
function atualizarPontos($email, $conexao) {
    // Verifica se o email foi enviado corretamente
    if (!isset($email)) {
        die('Email não foi enviado!');
    }
    // Consulta para pegar os dados do usuário
    $stmt = $conexao->prepare("SELECT pontos, ultima_atualizacao FROM cadastro WHERE email = ?");
    if (!$stmt) {
        die('Erro na preparação da consulta: ' . $conexao->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    // Se o usuário existir no banco
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $pontos = $row['pontos'];
        $ultima_atualizacao = strtotime($row['ultima_atualizacao']); // Converte para timestamp
        // Tempo atual
        $tempo_atual = time();
        // Verifica se 1 segundo se passou
        if ($tempo_atual - $ultima_atualizacao >= 10) {
            // Atualiza os pontos
            $pontos += 1;
            // Atualiza a última atualização para o tempo atual
            $stmt_update = $conexao->prepare("UPDATE cadastro SET pontos = ?, ultima_atualizacao = NOW() WHERE email = ?");
            $stmt_update->bind_param("is", $pontos, $email);
            $stmt_update->execute();

            // Retorna a nova pontuação
            echo "Pontos atualizados para: " . $pontos;
            $stmt_update->close();
        } else {
            echo "Menos de 1 segundo desde a última atualização.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
    $stmt->close();
}
// Pega o email do POST e chama a função
if (isset($_POST['email'])) {
    atualizarPontos($_POST['email'], $conexao);
} else {
    echo "";
}
// Fecha a conexão - isso deve ser feito apenas se as operações estiverem concluídas
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="logo sfundo.png"  type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fast Games</title>
    <link rel="stylesheet" href="style.css">
    <style>* {
    scrollbar-width: none;
    margin: 0;
    padding: 0;
}
.sub-categoria1{
    display: inline-flex;
    position: absolute;
    bottom: -120%;
    background-color: yellow;
    border: solid #000;
    width: 100%;
    height: 35px;
    justify-content: center;
    justify-items: center;
    z-index: 9999;
    margin: 30px;
    margin-left: -5px;
}
.sub-categoria1 i{
    position: relative;
    display: inline;
    padding: 30px;
    bottom: -8px;
    font-size: 20px;
    transition: .2s ease-in;
    -webkit-text-stroke: .8px #000;
}.sub-categoria1 i:hover{
    color: #fff;
}
img{
    width: 5%;
    position: absolute;
    bottom: 0;
}
/* Container para o iframe */
.container {
    position: fixed;
    display:flex;
    scrollbar-width: none;
    width: 100%;
    height: 100vh;
    overflow: hidden; /* Garante que nada ultrapasse o container */
    margin: 0;
 
}
/* Estilização do iframe */
iframe {
    transform: translateY(-9%);
    width: 100%;
    height: 120vh;
    border: none; /* Remove a borda */
    scrollbar-width: none; /* Remove barras de rolagem no Firefox */
    overflow: hidden; /* Remove barras de rolagem internas */
}</style>
</head>
<body>
<div class="Menu-Redes">
<a href="main-page.php"><img class="img-ini" src="logo sfundo.png" style="position: absolute; left:-1.5px ; width: 4.5%;" alt=""></a>
    <nav id="menuzinho1" class="dp-menu " style="position:absolute; left: -2%; z-index:99999;" >
        <ul id="menuzinho1" class="menuzinho">
        <li style="position: relative;">
            <ul class="redes" id="menu1">Redes</ul>
            <ul id="lista-inline" class="dp-menu1" style="position:absolute; transform:translateY(20%)">
                <li id="Insta" class="drop"><a class="link-drop" href="https://www.instagram.com/fastgames.ofc/"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li id="zap" class="drop"><a class="link-drop" href="#"><i class="fa-brands fa-x-twitter"></i>Twitter</a></li>
                <li id="Facebook" class="drop"><a class="link-drop" href="https://www.facebook.com/profile.php?id=61566819844960"><i class="fa-brands fa-facebook"></i>Facebook</a></li>
            </ul></li></ul>
    <ul id="menuzinho1">
        <ul class="menuzinho2">
            <ul><a id="menu1" href="#">Categorias</a></ul>
            <ul id="menu11" class="dp-menu1">
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#car-chain"><i class="fa-solid fa-car"></i>Corrida</a></li>
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#raciocinio-chain"><i class="fa-solid fa-chess"></i>Raciocinio</a></li>
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#2players-chain"><i class="fa-solid fa-user-group"></i>2 Jogadores</a></li>
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#futebol-chain"><i class="fa-regular fa-futbol"></i>Futebol</a></li>
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#cozinhar-chain"><i class="fa-solid fa-utensils"></i>Cozinhar</a></li>
                <li class="drop-ctg"><a class="link-drop" href="main-page.php#jogosio-chain"><i class="fa-solid fa-gamepad"></i>Jogos.Io</a></li>                       
            </ul>
        </ul>               
        <li><a id="menu1" href="main-page.php#footer-site">Contato</a></li>
<ul class="menuzinho2"><ul>
        <?php if (isset($_SESSION['email'])): ?>
            <li><a id="menu1" href="#"><?php echo htmlspecialchars(explode('@', $_SESSION['email'])[0]); ?></a></li>
            <ul style="position: relative; width:100%; transform:translateY(30%); z-index: 9999;"  id="menu12" class="dp-menu1">
            <li class="drop-ctg">
                <a class="link-drop" href="logout.php"><i  class="fa-solid fa-sign-out-alt"></i>  Deslogar</a>
                <a class="link-drop" href="ranking.php">
                <i style="padding: -5px;" class="fa-solid fa-ranking-star">Ranking</i>
                </a></li>
        </ul><?php else: ?><li><a id="menu1" href="login.php">Login</a></li></ul>   
    </ul></ul><?php endif; ?></ul></nav>
<li class="sub-categoria1">
            <div class="car">
                <a style="text-decoration: none; color: black;" href="main-page.php#car-chain"><i class="fa-solid fa-car"> Corrida</i> </a>
            </div>
            <div class="futebol">
                <a style="text-decoration: none; color: black;" href="main-page.php#futebol-chain"><i class="fa-solid fa-futbol">Futebol</i></a>   
            </div>
            <div class="players">
                <a style="text-decoration: none; color: black;" href="main-page.php#2players-chain"><i class="fa-solid fa-users">2 Jogadores</i></a>             
            </div>
            <div class="cozinhar">
                <a style="text-decoration: none; color: black;" href="main-page.php#cozinhar-chain"><i class="fa-solid fa-utensils">Cozinhar</i></a>          
            </div>
            <div class="raciocinio">
                <a style="text-decoration: none; color: black;" href="main-page.php#raciocinio-chain"><i class="fa-solid fa-chess-knight">Raciocinio</i>   </a>            
            </div>
            <div class="jogosio">
                <a style="text-decoration: none; color: black;" href="main-page.php#jogosio-chain"><i class="fa-solid fa-gamepad">Jogos.IO</i></a>
            </div></li></div>
    <div class="container">
        <iframe  src="https://www.jogos360.com.br/almond_coconut_cake.html"></iframe>
    </div>
</body>
<script>
    // Função para enviar requisição de atualização de pontos
    function atualizarPontos() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "atualiza_pontos.php", true); // Arquivo PHP que atualiza os pontos
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Tratamento da resposta do servidor
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                console.log("Resposta do servidor: " + xhr.responseText);
            }
        };
        // Envia o email do usuário pela requisição
        xhr.send("email=<?php echo $_SESSION['email']; ?>");
    }
    // Chama a função para atualizar pontos a cada 1 minuto (60000 ms)
    setInterval(atualizarPontos, 60000);
    window.onload = atualizarPontos;
    


</script>
</html>