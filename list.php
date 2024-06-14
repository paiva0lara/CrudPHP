<?php
    echo "<link rel='stylesheet' type='text/css' href='cru.css'/>";
	include 'banco.php';
	$lista=$cmd->query("select * from tbCadastro");
	$total_registros =$lista->rowCount();
    if ($total_registros > 0)
        {
        echo "<table>";
        echo "<tr> <th colspan=6> Dados Cadastrados </th> </tr>";
        echo "<tr> 
                <th> Código </th>
                <th> Nome </th>
                <th> e-Mail </th>
                <th> Senha </th>
                <th> Sexo </th>
                <th> Nascimento </th>
             </tr>";
				
        while($linha=$lista->fetch(PDO::FETCH_ASSOC))
        {
            $Codigo=$linha['id'];
            $nome=$linha['nome'];
            $email=$linha['email'];
        	$senha=$linha['senha'];
			$sexo=$linha['sexo'];
            $datanasc=$linha['dtna'];
            echo "<tr>
                    <td>$Codigo</td>
                    <td>$nome</td>
                    <td>$email</td>
                    <td>$senha</td>
                    <td>$sexo</td>
                    <td>$datanasc</td>
                  </tr>";
		}
		echo "</table>";
        echo "<br/><br/>";
        echo "<a href='index.html'>Voltar para o Menu</a>";
       }
    else
        {
        echo "<script language=javascript> window.alert('Não existem registros para exibir!!!'); window.history.back(); </script>";
        }
    ?>