<?php
    include 'banco.php';
    $vnome=$_POST['txt1'];
    $vemail=$_POST['txt2'];
    $vsenha=$_POST['txt3'];
    $vsexo=$_POST['txtsexo'];
    $vdata=$_POST['txtdate'];
    $incluir=$cmd->query("insert into tbCadastro(nome,email,senha,sexo,dtna)
    values('$vnome', '$vemail','$vsenha','$vsexo', '$vdata')");

    echo "<script language='Javascript'>
    alert('Dados cadastrados com sucesso!!! ');
    location.href='cad.html';
    </script>";
?>