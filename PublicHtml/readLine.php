<?php
namespace Chubasco\ZeroCode;

// include shared code
include '../lib/common.php';
include '../lib/lexer.php';
include '../lib/token.php';

// start or continue the session
// session_start();
header('Cache-control: private');


$file = fopen("../README","r");

while(! feof($file))
  {
  	$linea = fgets($file);
  // echo ">>".$linea. "<< ";
  
  $current_token = new Token(Token::T_NONE, 0);
  $tokens = Lexer::tokenize($linea);
	// $tokens = Lexer::test($linea);
  
	echo "  <br />";
  
  } // wend

fclose($file);


?>