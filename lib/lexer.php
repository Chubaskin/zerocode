<?php
namespace Chubasco\ZeroCode;
class Lexer
{
    /**
     * This class should not be instanciated
     */
    private function __construct()
    {
        ;
    }

    public static function test($string)
    {
    	$len = strlen($string);

    	return $len;
    }
    
    public static function tokenize($string)
    {
        $len = strlen($string);
        $tokens = array();
        $current_token = new Token(Token::T_NONE, 0);

                
        $i = 0;
        while($i < $len) {
            $c = $string[$i];
            switch($c) {
                case '\\': // Escape character
                    $current_token->addData($string[++$i]);
                    break;
                case ' ':
                    self::push($tokens, $current_token, $i);
                    // ************************************************************ //
                    print($current_token->getName($current_token));
                    break;
                case '"':
                    if($current_token->getData() == null) {
                        $current_token->setTypeIfNone(Token::T_STRING);
                        self::readAlfaString($current_token, $string, $i);
                        if($i + 1 < $len && $string[$i + 1] != ' ') // Peek one ahead. Should be empty
                            throw new ParseException('Unexpected T_STRING', $string, $i + 1);
                    } else {
                        throw new ParseException('Unexpected T_STRING', $string, $i);
                    }
                    break;
                default:
                    $current_token->addData($c);
            }
            $i++;
        }
        self::push($tokens, $current_token, $i);
        return $tokens;
    }
    
    static private function push(&$tokens, &$current_token, $i)
    {
        if($current_token->getData() === null)
            return;
        $current_token->setTypeIfNone(Token::T_STRING);
        $tokens[] = $current_token;
        $current_token = new Token(Token::T_NONE, $i);
    }
    
    static private function readAlfaString(Token $current_token, $string, &$i)
    {
        while(++$i < strlen($string)) {
            if($string[$i] == '\\') {
                $current_token->addData($string[++$i]);
            } else if($string[$i] != '"') {
                $current_token->addData($string[$i]);
            } else {
                break;
            }
        }
    }
    
    static private function readInt(Token $current_token, $string, &$i)
    {
        while(++$i < strlen($string)) {
            if(in_array($string[$i], array('0', '1', '2', '3', '4', '5', '6', '7',
                        '8', '9', '-'), true)) {
                $current_token->addData($string[$i]);
            } else {
                $i--;
                break;
            }
        }
    }
}