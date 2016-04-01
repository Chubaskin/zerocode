<?php
 
require_once('LexerZero.class');
require_once('TokenZero.class');
 
// $lexer = new LexerZero($argv[1]);
// $lexer = new LexerZero("a, asd,asd,ad,[da ad],  (asdad) ,asd");
$lexer = new LexerZero("Usuario Texto	largo 20 uq ");
$token = $lexer->nextToken();
 
while($token->type != $lexer::EOF_TYPE) {
    echo $token . "\n";
    $token = $lexer->nextToken();
}
  
?>
