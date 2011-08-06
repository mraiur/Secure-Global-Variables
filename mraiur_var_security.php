<?php
/**
 * Secure global vars
 *@author Nikolai Ivanov <mraiur@nikolai-ivanov.com>
 *@copyright Copyright (c) 2010, Nikolai Ivanov
 *@link http://nikolai-ivanov.com
 *@version v0.1
 *@license http://opensource.org/licenses/gpl-license.php GNU Public License
*/  
class mraiur_var_security
{
	public function Varchecker()
	{
		
	}
    
    private function process_vars( $paramArray = "post", $paramName, $paramType = "str", $paramDefault = "" )
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
			return $this->clearString($from_array, $paramName, $paramDefault);
		}
		elseif( $paramType == "int" )
		{
			return $this->clearInt($from_array, $paramName, ( ($paramDefault=="")?0:$paramDefault ) );
		}
        elseif( $paramType == "double" )
		{
			return $this->clearDouble($from_array, $paramName, ( ($paramDefault=="")?0:$paramDefault ) );
		}
    }
	
    
    /**
     *@param $paramName name string of the key of array 
     *@param $paramType string for the clear method "str", "int", "double"
     *@param $paramDefault default return value if not found in the array
     */
    public function get($paramName, $paramType = "str", $paramDefault = "")
    {
        return $this->process_vars("get", $paramName, $paramType, $paramDefault);
    }
    
	/**
     *@param $paramName name string of the key of array 
     *@param $paramType string for the clear method "str", "int", "double"
     *@param $paramDefault default return value if not found in the array
     */
	public function post( $paramName, $paramType = "str", $paramDefault = "")
	{
		return $this->process_vars("post", $paramName, $paramType, $paramDefault);
	}
	
    
	public function clearString( $paramArray, $paramName = "", $paramDefault = "")
	{
		if( isset($paramArray[$paramName]))
		{
			return addslashes(strip_tags(trim($paramArray[$paramName])));
		}
		else
		{
			return $paramDefault;
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