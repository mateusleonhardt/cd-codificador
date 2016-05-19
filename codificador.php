<?php
	$title = 'Codificador - NRZ-I';
	include("header.php");
?>
		
<?php 
	// Inclui o arquivo com funções para gerar o gráfico
	define('NOME_PASTA_UPLOADS', 'Uploads');

	$palavra = '';
	$valorBinario = '';

	if(isset($_POST['submit'])) 
	{
		//deletaDats();
		deletaUploads();

		fazUpload();
	}

	function txtsec2binsec($string){	// Função que receberá a string do arquivo 'upado' e o retornará como binário
        $data = '';
        for($i=0;$i<strlen($string);$i++)
        {
            $meuByte = decbin(ord($string[$i]));
            $meuBitSec = substr("00000000",0,8 - strlen($meuByte)) . $meuByte;
            $data .= $meuBitSec;
        }
        return $data;
    }

    function fazUpload(){
    	@rmdir(NOME_PASTA_UPLOADS);															// Remove a pasta dos Uploads
    	mkdir(NOME_PASTA_UPLOADS);															// Recria a pasta Uploads

		for($i=0; $i<count($_FILES['fileToUpload']['name']); $i++) {						// Loop para ler cada arquivo
		  
		  $tmpFilePath = $_FILES['fileToUpload']['tmp_name'][$i];							// Pega o caminho temporário do arquivo

		  if ($tmpFilePath != ""){															// Verifica se há mesmo um caminho de uma arquivo
		    $newFilePath = NOME_PASTA_UPLOADS . "/" . $_FILES['fileToUpload']['name'][$i];	// Seta o novo caminho do arquivo

		   
		    move_uploaded_file($tmpFilePath, $newFilePath);									// Upload do arquivo para a pasta Uploads
		  }
		}
    }

    function deletaUploads() {
    	$arquivos = glob(NOME_PASTA_UPLOADS . '/*.txt'); // $arquivos recebe todos os '.txt' contidos na pasta Uploads
    	foreach ($arquivos as $arquivo) {
    		@unlink($arquivo);							 // Em cada arquivo recebido, o mesmo é removido da pasta
    	}
    }

    function leArquivos(){
    	$arquivos = glob(NOME_PASTA_UPLOADS . '/*.txt'); // Recebe os arquivos txt
    	$binarios = array();
    	foreach ($arquivos as $arquivo) { 				 // Lê cada arquivo recebido 
    		$conteudo = file_get_contents($arquivo);	 // variável recebe o conteúdo contido no arquivo
    		$binarios[] = txtsec2binsec($conteudo);      // Transforma o conteúdo em binário e o salva em um array
    	}

    	foreach ($binarios as $binario) {													// Leitura de cada valor binário contido no array criado previamente
    		echo '<strong>Valor binário referente ao gráfico: </strong>' . $binario;
    		echo '<img src="gera-grafico.php?bits=' . $binario . '&nome='. $arquivo .'">';	// Irá exibir o gráfico na página
    		echo '<br><br>';
    	}
    }

?>
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-8">
			<form action="" method="post" enctype="multipart/form-data" role="form">
				<div class="form-group">					
					<div class='row'>
						<div class="col-sm-7">
							<label class="control-label"> Faça upload do <u>arquivo texto</u> do qual deseja gerar a onda: </label>
							<input id="fileToUpload" name="fileToUpload[]" class="form-control" type="file" multiple="multiple"/> 
						</div>
					</div>
				</div>
				<div class="form-group">
					<input class="btn btn-success" type="submit" name="submit" value="Ler Arquivo(s)"/>
				</div>
			</form>		  	
		</div>		
	</div>
	<div class="panel panel-success">
			  <div class="panel-heading">
			    <h3 class="panel-title">Gráficos</h3>
			  </div>
			  <div class="panel-body word-break" style="overflow:auto;">
			  <?php
				if(isset($_POST['submit'])) 
				{
					leArquivos();
			  	}
	  		  ?>
			  </div>
			</div>
	<div class="growRow"></div>
<?php
	include("footer.php");
?>