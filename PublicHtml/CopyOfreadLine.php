<?php
namespace Chubasco\ZeroCode;
// include shared code
include '../lib/common.php';
include '../lib/lexer.php';
include '../lib/token.php';

// start or continue the session
session_start();
header('Cache-control: private');


$file = fopen("../README","r");

while(! feof($file))
  {
  	$linea = fgets($file);
  echo ">>".$linea. "<< ";
  
  $current_token = new Token(Token::T_NONE, 0);
  $tokens = Lexer::tokenize($linea);
	// $tokens = Lexer::test($linea);
    // print_r($tokens);
    echo "  <br />";
  
  } // wend

fclose($file);
/**
 *  public function updateQuery($queryExpr)
    {
        $tokens = Lexer::tokenize($queryExpr);
        $searchQuery = '';
        while(false !== ($token = current($tokens))) {
            switch($token->getType()) {
                case Token::T_STRING:
                    $searchQuery.= ' ' . $token->getData();
                    break;
                case Token::T_FIELD_NAME:
                    $nextToken = next($tokens);
                    if($nextToken === false)
                        throw new ParseException('Unexpected end of token stream');
                    switch($nextToken->getType()) {
                        case Token::T_FIELD_VALUE:
                            $this->addFilter($token->getData(), $nextToken->getData());
                            break;
                        case Token::T_FIELD_WEIGHT:
                            $this->addWeight($token->getData(), $nextToken->getData());
                            break;
                        default:
                            throw new ParseException('Unexpected ' . Token::getName($nextToken->getType()), $queryExpr, $token->getStartPosition());
                    }
                    break;
                case Token::T_FIELD_SEARCH:
                    $this->addSearchField($token->getData());
                    break;
                default:
                    throw new ParseException('Unexpected ' . Token::getName($token->getType()) . ' (This is a lexer bug, please report it)', $queryExpr, $token->getStartPosition());
            }
            next($tokens);
        }
        $this->setSearchQuery(substr($searchQuery, 1));
        return $this;
 */

?>