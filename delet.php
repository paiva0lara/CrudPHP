
            <?php
            //estabelecendo a conexão com banco de dados
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
                    $vCodigo=$linha['id'];
                    $vnome=$linha['nome'];
                    $vemail=$linha['email'];
                    $vsenha=$linha['senha'];
                    $vsexo=$linha['sexo'];
                    $dtna=$linha['dtna'];
                    echo "<tr>
                            <td>$vCodigo</td>
                            <td>$vnome</td>
                            <td>$vemail</td>
                            <td>$vsenha</td>
                            <td>$vsexo</td>
                            <td>$dtna</td>
                          </tr>";
                }
                echo "</table>";
       
            //recebendo os valores preenchidos nos campos do formulário nas variáveis do PHP
            $vCodigo=$_POST['txtcodi'];
            if (isset($vCodigo))
            {
                if ($vCodigo!='') //se na caixa de texto do código escolhido estiver diferente de vazio executa o bloco abaixo
                    {                    
                        //verificando se o código escolhido EXISTE na tabela                
                        $pesq=$cmd-> query("select * from tbCadastro where id='$vCodigo'");
                        $total_registros =$pesq->rowCount();
                        if ($total_registros > 0)
                        {
                            //vamos apagar o registro escolhido
                            $excl=$cmd-> query("delete from tbCadastro where id='$vCodigo'");
                            echo "<script language=javascript>
                                    window.alert('Registro excluído com sucesso!!! ');
                                    location.reload();
                                  </script>";
                        }                        
                        else
                        {
                            //o usuário escolheu um código que não foi apresentado na listagem
                            echo "<script language=javascript>
                                    window.alert('Registro inexistente!!! ');
                                    location.reload();
                                 </script>";
                        }              
                   }
                else  //o usuário deixou a caixa de texto em branco e clicou no botão “confirma”
                       echo "<script language=javascript>
                                window.alert('Escolha um código da lista!!! ');  
                                document.getElementById('txtcodi').focus();  
                            </script>";
                }
            }
        else // do 1º if
            {
                echo "<script language=javascript>
                        window.alert('Não existem registros para excluir!!!');
                        window.history.back();
                    </script>";
                    echo "<meta http-equiv='refresh' content='0' />";
            }
            ?>