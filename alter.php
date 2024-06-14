<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "dbanco";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cmd = $conn; // Define $cmd como a conexão PDO para uso posterior
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Encerra o script se a conexão falhar
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="alte.css">
</head>
 
<body>
    <form id="form1" method="post" action="alter.php">
        <h3>Alteração de Registros</h3>
        <label for='txtcodigo'>Código do registro a ser alterado&nbsp;</label>
        <input class="fea" type='text' name='txtcodigo' id='txtcodigo'/><br/>
        <div class="arroz">
        <label for='txtnome'>Nome&nbsp;</label>
        <input type='text' name='txtnome' id='txtnome' readonly/><br/>
        </div>
        <div class="arroz">
        <label for='txtemai'>e-mail&nbsp;</label>
        <input type='email' name='txtemai' id='txtemai' readonly/><br/>
        </div>
        <div class="arroz">
        <label for='txtsenha'>Senha&nbsp;</label>
        <input type='password' name='txtsenha' id='txtsenha' readonly/><br/>
        </div>
        <label for='txtsexo'>Sexo&nbsp;</label>
        <div class="sex">
        Feminino<input type='radio' value='f' name='txtsexo' id='txtsexof' readonly />
        <input type='radio' value='m' name='txtsexo' id='txtsexom' readonly/>Masculino<br/>
        </div>
        <label for='txtdtna'>Informe sua data de nascimento</label>
        <input type='date' id='txtdtna' name='txtdtna'/><br/><br/>

        <div class='botoes'>
            <input type='submit' name='bt' id='bt' value='Escolher'/>&nbsp;&nbsp;
          <a href="index.html"><input type='button' value='Menu'/></a>
        </div>
    </form>

    <?php
    // Exibir os dados cadastrados
    echo "<table>";
    echo "<tr><th colspan=6>Dados Cadastrados</th></tr>";
    echo "<tr>
            <th>Codigo</th>
            <th>Nome</th>
            <th>e-Mail</th>
            <th>Senha</th>
            <th>Sexo</th>
            <th>Nascimento</th>
          </tr>";

    $listar = $cmd->query("SELECT * FROM tbcadastro");
    $total_registros = $listar->rowCount();

    if ($total_registros > 0) {
        while ($linha = $listar->fetch(PDO::FETCH_ASSOC)) {
            $vcodi = $linha['id'];
            $vnome = $linha['nome'];
            $vemai = $linha['email'];
            $vsenh = $linha['senha'];
            $vsexo = $linha['sexo'];
            $vdtna = $linha['dtna'];
            echo "<tr>
                    <td>$vcodi</td>
                    <td>$vnome</td>
                    <td>$vemai</td>
                    <td>$vsenh</td>
                    <td>$vsexo</td>
                    <td>$vdtna</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<script language=javascript> 
                window.alert('Não existem registros para alterar!!!'); 
                location.href='index.html';
              </script>";
    }

    if (isset($_POST['bt'])) {
        $vcodi = $_POST['txtcodigo'] ?? '';
        $vbt = $_POST['bt'] ?? '';

        if ($vbt == 'Escolher') {
            $pesq = $cmd->prepare("SELECT * FROM tbcadastro WHERE id = :vcodi");
            $pesq->bindParam(':vcodi', $vcodi, PDO::PARAM_INT);
            $pesq->execute();
            $total_registros = $pesq->rowCount();

            if ($total_registros > 0) {
                while ($linha = $pesq->fetch(PDO::FETCH_ASSOC)) {
                    $vcodi = $linha['id'];
                    $vnome = $linha['nome'];
                    $vemai = $linha['email'];
                    $vsenh = $linha['senha'];
                    $vsexo = $linha['sexo'];
                    $vdtna = $linha['dtna'];
                    
                    echo "<script language=javascript>
                            document.getElementById('txtcodigo').value='$vcodi';
                            document.getElementById('txtnome').value='$vnome';
                            document.getElementById('txtemai').value='$vemai';
                            document.getElementById('txtsenha').value='$vsenh';
                            if ('$vsexo' == 'f')
                                document.getElementById('txtsexof').checked=true;
                            else
                                document.getElementById('txtsexom').checked=true;
                            document.getElementById('txtdtna').value='$vdtna';
                            document.getElementById('bt').value='Alterar';
                            document.getElementById('txtcodigo').readOnly=true;
                            document.getElementById('txtnome').readOnly=false;
                            document.getElementById('txtemail').readOnly=false;
                            document.getElementById('txtsenha').readOnly=false;
                             document.getElementById('txtsexof').readOnly=false;
                              document.getElementById('txtsexom').readOnly=false;
                               document.getElementById('txtdtna').readOnly=false;
                          </script>";
                }
            } else {
                echo "<script language=javascript> 
                        window.alert('Código inexistente!!!'); 
                        location.href='alter.php'; 
                      </script>";
            }
        } elseif ($vbt == 'Alterar') {
            $vnome = $_POST['txtnome'] ?? '';
            $vemai = $_POST['txtemai'] ?? '';
            $vsenh = $_POST['txtsenha'] ?? '';
            $vsexo = $_POST['txtsexo'] ?? '';
            $vdtna = $_POST['txtdtna'] ?? '';

            // Validação para garantir que os valores estão corretos
            if (!in_array($vsexo, ['f', 'm'])) {
                echo "<script language=javascript> 
                        window.alert('Sexo inválido!'); 
                        location.href='alter.php'; 
                      </script>";
                exit;
            }

            $alter = $cmd->prepare("UPDATE tbcadastro SET nome = :vnome, email = :vemai, senha = :vsenh, sexo = :vsexo, dtna = :vdtna WHERE id = :vcodi");
            $alter->bindParam(':vnome', $vnome, PDO::PARAM_STR);
            $alter->bindParam(':vemai', $vemai, PDO::PARAM_STR);
            $alter->bindParam(':vsenh', $vsenh, PDO::PARAM_STR);
            $alter->bindParam(':vsexo', $vsexo, PDO::PARAM_STR);
            $alter->bindParam(':vdtna', $vdtna, PDO::PARAM_STR);
            $alter->bindParam(':vcodi', $vcodi, PDO::PARAM_INT);
            $alter->execute();
            
            echo "<script language=javascript>
                    window.alert('Registro alterado com sucesso!!!');
                    document.getElementById('bt').value='Escolher';
                    document.getElementById('txtcodigo').readOnly=false;
                    document.getElementById('form1').reset();
                    clearFormFields();
                  </script>";
            echo "<meta http-equiv='refresh' content='0'/>";
        }
    }
    ?>
</body>
</html>
