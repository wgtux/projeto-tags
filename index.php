<?php

//conexão com o banco
try{
    $pdo = new PDO("mysql:dbname=projeto_tags; host=localhost", "root", "");
}
catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}
//Pegando as caracteristicas
$sql = "SELECT caracteristicas FROM usuarios";
$sql = $pdo->query($sql);

//armazenando as informações em um array e ja contando as palavras
if($sql->rowCount() > 0){
    $lista = $sql->fetchAll();

    $carac = array();

    foreach($lista as $usuario){
        //separam as caracteriscas por virgulas em um unico array
        $palavras = explode(",", $usuario['caracteristicas']); 
        foreach($palavras as $palavra){ //verifica se ja tem o nome, caso sim adiona a contagem, caso não cria um array com o nome
            $palavra = trim($palavra); // trim() = tira os espaços do começo e do fim

            if(isset($carac[$palavra])){
                $carac[$palavra]++;
            }
            else{
                $carac[$palavra] = 1;
            }
        }
    }
    
    arsort($carac);//colocar em ordem alfabetica
    
    // divindo as palavras (chaves) dos valores(conteudo)
    $palavras = array_keys($carac);
    $contagens = array_values($carac);

    //armazena o maior valor
    $maior = max($contagens);

    $tamanhos = array(11, 15, 20, 30);

    for($x=0; $x<count($palavras); $x++){
        $n = $contagens[$x] / $maior;
        $h = ceil($n * count($tamanhos));
        echo "<p style='font-size:".$tamanhos[$h-1]."px'>".$palavras[$x]." (".$contagens[$x].")</p>";
    }

}

?>