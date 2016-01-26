<?php
class LexerBase
{
    # private $id;     // id
    # private $fields;  // other record fields


    // *************************************************************    
    /*
     * Inicializa el objeto User
     */
    private function __construct()
    {
        $this->id = null;
        $this->fields = array('username' => '',
                              'password' => '',
                              'emailAddr' => '',
                              'isActive' => false);
    }
    

    public static function tokenize($string)      # Retorna una lista de tokens
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
    				break;
    			case ':':
    				if($current_token->getData() == null)
    					throw new ParseException('Expected T_FIELD_NAME, got nothing', $string, $i);
    				if(!$current_token->isTypeNoneOr(Token::T_FIELD_NAME))
    					throw new ParseException('Expected T_FIELD_NAME, got ' . Token::getName($current_token->getType()), $string, $i);
    				$current_token->setType(Token::T_FIELD_NAME);
    				self::push($tokens, $current_token, $i);
    				$current_token->setType(Token::T_FIELD_VALUE);
    				break;
    			case '^':
    				if($current_token->getData() == null)
    					throw new ParseException('Expected T_FIELD_NAME, got nothing', $string, $i);
    				if(!$current_token->isTypeNoneOr(Token::T_FIELD_NAME))
    					throw new ParseException('Expected T_FIELD_NAME, got ' . Token::getName($current_token->getType()), $string, $i);
    				$current_token->setType(Token::T_FIELD_NAME);
    				$field_token = $current_token;
    				self::push($tokens, $current_token, $i);
    				$current_token->setType(Token::T_FIELD_WEIGHT);
    				self::readInt($current_token, $string, $i);
    				self::push($tokens, $current_token, $i);
    				if($i + 1 < $len && $string[$i + 1] == ':') // Peek one ahead. Duplicate T_FIELD_NAME token if a T_FIELD_VALUE follows.
    					$current_token = $field_token;
    				break;
    			case '@':
    				if($current_token->getData() != null)
    					throw new ParseException('Expected nothing, got ' . Token::getName($current_token->getType()), $string, $i);
    				$current_token->setType(Token::T_FIELD_SEARCH);
    				break;
    			case '"':
    				if($current_token->getData() == null) {
    					$current_token->setTypeIfNone(Token::T_STRING);
    					self::readEncString($current_token, $string, $i);
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
        

}
?>
