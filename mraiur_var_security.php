<?php
/**
 * Secure global vars
 *@author Nikolai Ivanov <mraiur@nikolai-ivanov.com>
 *@copyright Copyright (c) 2010, Nikolai Ivanov
 *@link http://nikolai-ivanov.com
 *@version v0.1
 *@license http://opensource.org/licenses/gpl-license.php GNU Public License
*/  
class vars
{
	public function vars()
	{
		
	}
    
    private function process_vars( $paramArray = "post", $paramName, $paramType = "str", $paramDefault = "", $skip_formats = array() )
    {
        $from_array = array();
        if($paramArray === "post" )
        {
            $from_array = $_POST;   
        }
        elseif($paramArray === "get")
        {
            $from_array = $_GET;
        }
        
        if( $paramType == "str" )
		{
			return $this->clearString($from_array, $paramName, $paramDefault, $skip_formats);
		}
		if( $paramType == "str_alpha" )
		{
			return $this->clearAlphaString($from_array, $paramName, $paramDefault);
		}
		elseif( $paramType == "int" )
		{
			return $this->clearInt($from_array, $paramName, ( ($paramDefault=="")?0:$paramDefault ) );
		}
        elseif( $paramType == "double" )
		{
			return $this->clearDouble($from_array, $paramName, ( ($paramDefault=="")?0:$paramDefault ) );
		}
		elseif( $paramType == "bool" )
		{
			return $this->clearBool($from_array, $paramName, false);
		}
    }
	
    
    /**
     *@param $paramName name string of the key of array 
     *@param $paramType string for the clear method "str", "int", "double"
     *@param $paramDefault default return value if not found in the array
     */
    public function get($paramName, $paramType = "str", $paramDefault = "", $skip_formats = array())
    {
        return $this->process_vars("get", $paramName, $paramType, $paramDefault, array_flip($skip_formats));
    }
    
	public function get_all()
	{
		$return = array();
		foreach($_GET as $key => $value)
		{
			if($value > 0 )
			{
				$return[$key] = $this->get($key, "int");
			}
			else
			{
				$return[$key] = $this->get($key);
			}
		}
		return $return;
	}
	
	/**
     *@param $paramName name string of the key of array 
     *@param $paramType string for the clear method "str", "int", "double"
     *@param $paramDefault default return value if not found in the array
     */
	public function post( $paramName, $paramType = "str", $paramDefault = "", $skip_formats = array())
	{
		return $this->process_vars("post", $paramName, $paramType, $paramDefault, array_flip($skip_formats));
	}
	
    public function clearString( $paramArray, $paramName = "", $paramDefault = "", $skip_formats = array())
	{
		if( isset($paramArray[$paramName]))
		{
			$string = $paramArray[$paramName];
			if( !isset($skip_formats['trim']) ){ $string = trim($string); }
			if( !isset($skip_formats['strip_tags']) ){ $string = strip_tags($string); }
			if( !isset($skip_formats['addslashes']) ){ $string = addslashes($string); }
			return $string;
		}
		else
		{
			return $paramDefault;
		}
	}
	
	
	public function clearAlphaString( $paramArray, $paramName = "", $paramDefault = "")
	{
		if( isset($paramArray[$paramName]))
		{
			$string = strip_tags(trim($paramArray[$paramName]));
			$string = preg_replace("/[^A-Za-z]/", "", $string);
			return addslashes( $string );
		}
		else
		{
			return $paramDefault;
		}
	}
	
	public function clearBool( $paramArray, $paramName = "", $paramDefault = "")
	{
		if( isset($paramArray[$paramName]) && ( $paramArray[$paramName] == true || $paramArray[$paramName] == "true"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function clearInt( $paramArray, $paramName = "", $paramDefaultValue = 0)
	{
		if( isset($paramArray[$paramName]) )
		{
			return intval(strip_tags(trim($paramArray[$paramName])));
		}
		else
		{
			return $paramDefaultValue;
		}
	}
    
    public function clearDouble( $paramArray, $paramName = "", $paramDefaultValue = 0)
	{
		if( isset($paramArray[$paramName]) )
		{
			return floatval(strip_tags(trim($paramArray[$paramName])));
		}
		else
		{
			return $paramDefaultValue;
		}
	}
}
?>