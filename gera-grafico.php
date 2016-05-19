<?php
// requisição da classe PHPlot
require_once 'phplot library/phplot.php';
ini_set('memory_limit', '2048M');

$use_shapes = "squared";

$bits = $_GET['bits'];
$splitedBits = str_split($bits);
$cod = array();
$i = 0;

foreach ($splitedBits as $bitPalavra) {
	if ($i == 0){
		$bit = $bitPalavra; 
	}
	else{
		$bitAnterior = $cod[$i-1];
		if ($bitPalavra == 0){
			$bit = $bitAnterior;
		}
		else if($bitAnterior == 1){
			$bit = 0;
		}
		else{
			$bit = 1;
		}
	}
	$cod[] = $bit;
	$i++;

}

// Valores gerados para o grafico
$data = array();
$n = 0;
foreach ($cod as $bit) {
	$data[] = array($n, $bit);
	$n += 1;
}

# Cria um novo objeto do tipo PHPlot com 900px de largura x 320px de altura                 
$plot = new PHPlot(150 + (count($splitedBits) * 30), 320);     
  
// Organiza Gráfico -----------------------------
$plot->SetTitle('Palavra Codificada');
# Precisão de uma casa decimal
$plot->SetPrecisionY(1);
# tipo de Gráfico em "quadrados"
$plot->SetPlotType($use_shapes);
# Tipo de dados que preencherão o Gráfico
$plot->SetDataType("text-data");
# Adiciona ao gráfico os valores do array
$plot->SetDataValues($data);
// -----------------------------------------------
  
// Organiza eixo X ------------------------------
# Tamanho da fonte que varia de 1-5
$plot->SetXLabelFontSize(2);
$plot->SetAxisFontSize(2);
# Remove a linha do eixo X
$plot->SetDrawXAxis(False);
// -----------------------------------------------
  
// Organiza a área do gráfico --------------------
# Substituição em escala automática de dados para coordenadas do gráfico
$plot->SetPlotAreaWorld(NULL, -1, NULL, 2);
# Muda cor da linha no gráfico
$plot->SetDataColors(array('red'));
# Adiciona legenda
$plot->SetLegend('nivel');
# Adiciona o tipo da legenda de acordo com o tipo de gráfico
$plot->SetLegendUseShapes($use_shapes);
# Adiciona bordas ao redor do gráfico
$plot->SetPlotBorderType("full");
// -----------------------------------------------

//Remove o Grid de X e Y no gráfico
$plot->SetDrawXGrid(False);
$plot->SetDrawYGrid(False);

// Desenha o Gráfico -----------------------------
$plot->DrawGraph();
// -----------------------------------------------
?>