<?php
 
require_once('LexerZeroCode.class');
require_once('TokenZero.class');


$entrada = fopen("cliente.zc", "r");
$num_linea = 0;

if ($entrada) {
    while(!feof($entrada)) {
		$linea = fgets($entrada);
		$num_linea++;
		// echo "Línea #<b>{$num_linea}</b> : " . htmlspecialchars($linea) . "<br />\n";
		$lexer = new LexerZeroCode($linea);
				
		$token = $lexer->nextToken();
		 
		while($token->type != $lexer::EOF_TYPE) {
			echo $token . "\n";

			$token = $lexer->nextToken();
		}
		 echo "<::EOF::>\n"; 

    } // wend
    fclose($entrada);
} else {
    echo  "Error al escribir el archivo";
} 



return 0;
 
// $lexer = new LexerZeroCode($argv[1]);
$lexer = new LexerZeroCode("a, asd,asd,ad,[da ad],  (asdad) ,1asd12");
//$lexer = new LexerZeroCode("cliente.zc");
$lexer->tokenSpcOff();



//echo ($lexer->tokenSpc())?"ok\n":"No\n";

$token = $lexer->nextToken();
 
while($token->type != $lexer::EOF_TYPE) {
    echo $token . "\n";
    $token = $lexer->nextToken();
}
  
?>
