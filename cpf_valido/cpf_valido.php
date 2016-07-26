<?php

function cpf_valido_config() {
    $configarray = array(
    "name" => "CPF Válido",
    "description" => "Consultor de CPF Válido",
    "version" => "1.0",
    "author" => "Luciano Zanita - WHMCS.RED",
    );
    return $configarray;
}

function cpf_valido_activate() {
  //Adiciona a Tabela
  $query = "CREATE TABLE IF NOT EXISTS `mod_cpfvalido` (`id` int(11) NOT NULL AUTO_INCREMENT, `campocpf` varchar(255) NOT NULL, `tipo` varchar(255) NOT NULL, `key` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
  mysql_query($query);
  //Insere o resultado
  $query = "INSERT INTO `mod_cpfvalido` (`id`, `campocpf`, `tipo`, `key`) VALUES ('1', '0', '0', '0');";
  mysql_query($query);

    # Retorno
    return array('status'=>'success','description'=>'Módulo de CPF Válido foi ativo com sucesso!');
    return array('status'=>'error','description'=>'Não foi possível ativar o módulo de CPF Válido por causa de um erro desconhecido');
    //return array('status'=>'info','description'=>'You can use the info status return to display a message to the user');
 
}
 
function cpf_valido_deactivate() {
    
    $query = "DROP TABLE `mod_cpfvalido`";
    mysql_query($query);
 
    # Retorno
    return array('status'=>'success','description'=>'Módulo de CPF Válido foi desativado com sucesso!');
    return array('status'=>'error','description'=>'Não foi possível desativar o módulo de CPF Válido por causa de um erro desconhecido');
    //return array('status'=>'info','description'=>'If you want to give an info message to a user you can return it here');
 
}
function cpf_valido_output(){
  echo '<div>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"'; if(array_key_exists('aut',$_GET)){ } else {  echo 'class="active"';}  echo'><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
    <li role="presentation"'; if($_GET['aut']=='validar'){echo ' class="active"'; } echo'><a href="#verificar" aria-controls="verificar" role="tab" data-toggle="tab"><i class="fa fa-user" aria-hidden="true"></i> Verificar Conta</a></li>
    <li role="presentation"'; if($_GET['aut']=='salvar'){echo ' class="active"'; } echo'><a href="#configuracoes" aria-controls="configuracoes" role="tab" data-toggle="tab"><i class="fa fa-cogs" aria-hidden="true"></i> Configurações</a></li>
  </ul>
  <br/>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane '; if(array_key_exists('aut',$_GET)){ } else {  echo ' active';}  echo'" id="home">
      <div class="row">
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-home" aria-hidden="true"></i> Principal</div>
            <div class="panel-body">
              Seja bem-vindo(a) ao consultor de CPF Válido.
              <p>Com o CPF Válido, você poderá checar se o CPF do titular da conta esta correto e válido, podendo assim trazer mais segurança e menos fraude em pedidos. O sistema é baseado na API da BIPBOP, tendo a versão gratuita que permite até 20 consultas por dia.</p>
              <br/>
              <p><b>Créditos:</b>
              <br/>
              - Desenvolvimento do Módulo: Luciano Zanita<br/>
              - Colaboração javascript: Victor Hugo
              - API: <a href="http://api.bipbop.com.br/" target="_new">BipBop</a><br/>
              <center><a href="http://www.whmcs.red" target="_new"><img src="http://whmcs.red/wp-content/uploads/2016/07/whmcs-red-logo.png"></a></center>
              </p>
            </div>
          </div>

        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-shield" aria-hidden="true"></i> Verificação de Atualização</div>
            <div class="panel-body">';
              $versao = "1.0";
              $versaodisponivel = file_get_contents("http://whmcs.red/versao/cpf_valido.txt");
              if($versao==$versaodisponivel){
                echo '<center><i class="fa fa-heart" aria-hidden="true"></i> Parabéns sua versão esta atualizada!</center>';
              }
              else{
                echo '<center><i class="fa fa-heartbeat" aria-hidden="true"></i> Sua Versão não esta atualizada!<br/><a href="http://www.whmcs.red" class="btn btn-danger">Atualizar Agora</a></center>';
              }
              echo'
            </div>
          </div>

        </div>
      </div>
    </div>
    

    <div role="tabpanel" class="tab-pane'; if($_GET['aut']=='validar'){echo ' active'; } echo'" id="verificar">';
$usesqlmod = "SELECT*FROM mod_cpfvalido WHERE id = 1";
$result = mysql_query($usesqlmod);
while ($data = mysql_fetch_array($result)) {
	$campodecpfveri = $data['campocpf'];
 }

$usesql = "SELECT tblclients.id, tblclients.firstname, tblclients.lastname, tblcustomfieldsvalues.relid, tblcustomfieldsvalues.value, tblcustomfieldsvalues.fieldid FROM tblclients INNER JOIN tblcustomfieldsvalues ON tblcustomfieldsvalues.relid = tblclients.id WHERE tblcustomfieldsvalues.fieldid = '".$campodecpfveri."' OR tblcustomfieldsvalues.value = 'on' order by tblclients.firstname";

        $clients = '';
        $result = mysql_query($usesql);
        while ($data = mysql_fetch_array($result)) {
            $clients .= '<option value="'.$data['id'].'">'.$data['firstname'].' '.$data['lastname'].'</option>';
        }
    echo'
      <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i> Selecione a Conta</div>
              <div class="panel-body"><center>
              <b>Selecione o usuário que deseja consultar:</b><br/>
                  <form id="form" action="addonmodules.php?module=cpf_valido&aut=validar" method="post">
                  <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="userconsultar">
                  	<option value="" disabled>Selecione o cliente</option>
                    '.$clients.'
                  </select>
                  <button type="submit"class="btn btn-info">Verificar Conta</button></center>
                  </form>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading"><i class="fa fa-info" aria-hidden="true"></i> Informações</div>
              <div class="panel-body">';
              if ($_POST['userconsultar']==''){
              	echo '<center><b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Aguardando dados do usuário!</b></center>';
              }
              if($_GET['aut']=='validar'){
              	$usesqlmod = "SELECT*FROM mod_cpfvalido WHERE id = 1";
				$result = mysql_query($usesqlmod);
				while ($data = mysql_fetch_array($result)) {
					$campodecpfveri = $data['campocpf'];
				  	$tipodekey = $data['tipo'];
				  	$keysystem = $data['key'];
				}

              	$conta = $_POST['userconsultar'];
              	$usesql = "SELECT*FROM tblclients WHERE id = '".$conta."'";
		        $result = mysql_query($usesql);
		        while ($data = mysql_fetch_array($result)) {
		        $iddaconta		= $data['id'];
		        $primeiro_nome 	= $data['firstname'];
		        $segundo_nome	= $data['lastname'];
		        }
		        $usesql2 = "SELECT*FROM tblcustomfieldsvalues WHERE fieldid = '".$campodecpfveri."' AND relid = '".$iddaconta."'";
		        $result = mysql_query($usesql2);
		        while ($data2 = mysql_fetch_array($result)) {
		        $cpfcadastrocheck 	= $data2['value'];
		        }
		     
				//strings
		        $nomecompletocadastro = "".$primeiro_nome." ".$segundo_nome."";

		        if($tipodekey=='0'){
		        	$key = "6057b71263c21e4ada266c9d4d4da613";
		        }
		        else{
		        	$key = $keysystem;
		        }

		        //Checar CPF
		        $site = file_get_contents(str_replace("%20", " ", "https://irql.bipbop.com.br/?q=SELECT FROM 'BIPBOPJS'.'CPFCNPJ' WHERE 'DOCUMENTO' = '".$cpfcadastrocheck."'&apiKey=".$key.""));
				$xml=simplexml_load_string($site);
				$nomechecadocpf = $xml->body->nome;

		      if(strtolower($nomecompletocadastro)==strtolower($nomechecadocpf)){
		      echo '<center><div class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Conta verificada, não existe dados divergentes!</div></center>';

		      echo '<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i> Nome Completo</span>
  <input type="text" class="form-control" value="'.$primeiro_nome.' '.$segundo_nome.'" disabled>
  <span class="input-group-addon"><i data-toggle="tooltip" data-placement="left" title="Nome Validado" class="fa fa-check-circle-o" aria-hidden="true"></i></span>
</div><br/>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i> CPF</span>
  <input type="text" class="form-control" value="'.$cpfcadastrocheck.'" disabled>
  <span class="input-group-addon"><i data-toggle="tooltip" data-placement="left" title="CPF Validado" class="fa fa-check-circle-o" aria-hidden="true"></i></span>
</div><br/>
<center><b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Nenhuma ação a ser tomada!</b></center>';
}
else{
	 echo '<center><div class="alert alert-danger" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Conta verificada, existem divergencias no cadastro!</div></center>';
		      echo '<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i> Nome Completo</span>
  <input type="text" class="form-control" value="'.$primeiro_nome.' '.$segundo_nome.'" disabled>
  <span class="input-group-addon"><i data-toggle="tooltip" data-placement="left" title="Nome não condiz com o CPF (inválido)" class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
</div><br/>
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i> CPF</span>
  <input type="text" class="form-control" value="'.$cpfcadastrocheck.'" disabled>
  <span class="input-group-addon"><i data-toggle="tooltip" data-placement="left" title="CPF não condiz com o nome (inválido)" class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
</div><br/>
<center><a href="supporttickets.php?action=open&userid='.$iddaconta.'" class="btn btn-warning"><i class="fa fa-ticket" aria-hidden="true"></i> Abrir Ticket</a> <a href="clientssummary.php?userid='.$iddaconta.'&action=closeclient&token=e8c2163bf4ed1187a97d0ab42c6be3c9fb1c3644" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Fechar Conta</a></center>';
}
			}
              echo'
              </div>
            </div>
        </div>
      </div>
    </div>
    

    <div role="tabpanel" class="tab-pane'; if($_GET['aut']=='salvar'){echo ' active'; } echo'" id="configuracoes">';
      if ($_GET['aut']=='salvar') {
        $update = array(
                    "campocpf" => $_POST['cpf'],
                    "tipo" =>$_POST['tipokey'],
                    "key" =>$_POST['key']
                );
        update_query("mod_cpfvalido", $update, "id = 1");
echo '<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> Dados atualizados com sucesso!
                  </div>';
        }
				$usesqlmod = "SELECT*FROM mod_cpfvalido WHERE id = 1";
				$result = mysql_query($usesqlmod);
				while ($data = mysql_fetch_array($result)) {
					$campodecpfveri = $data['campocpf'];
				  	$tipodekey = $data['tipo'];
				  	$keysystem = $data['key'];
				}
$result = select_query("tblcustomfields", "id,fieldname", $where);
        $cpfcampo = '';
        while ($data = mysql_fetch_array($result)) {
            if ($data['id'] == $campodecpfveri) {
                $selected = 'selected="selected"';
            } else {
                $selected = "";
            }
            $cpfcampo .= '<option value="' . $data['id'] . '" '.$selected.'>' . $data['fieldname'] . '</option>';
        }

    echo'
      <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-cog" aria-hidden="true"></i> Configuração de Campo Personalizado</div>
        <div class="panel-body">
        <form action="addonmodules.php?module=cpf_valido&aut=salvar" method="post" >
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i> CPF</span>
              <select name="cpf" class="form-control">
              '.$cpfcampo.'
              </select>
            </div>
            <br/>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-code-fork" aria-hidden="true"></i> Licença BipBop</span>
              <select id="tipokey" name="tipokey" class="form-control">
              <option value="0" '; if($tipodekey=='0'){ echo'selected=""'; } echo'>Grátis</option>
              <option value="1" '; if($tipodekey=='1'){ echo'selected=""'; } echo'>Pago (KEY)</option>
              </select>
            </div>
            <br/>
            <div id="key" class="input-group">
			  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i> API Key</span>
			  <input name="key" type="text" class="form-control" value="'.$keysystem.'" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" aria-describedby="basic-addon1">
			</div>

        <br/>
        <input type="submit" class="btn btn-info" value="Salvar">
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel-footer">Desenvolvido por <a href="http://www.whmcs.red" target="_new">Luciano Zanita - WHMCS RED</a></div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>
';
?>
<script>
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script type="text/javascript">
 function mudakey()
 {
  if($("#tipokey").val() != "1")
  {
   $("#key").hide();
  }
  else
  {
   $("#key").show();
  }
 }
 $("#tipokey").change(function(){mudakey();});
 mudakey();
</script>
<?
//Fim do output
}
?>