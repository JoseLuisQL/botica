<?php
session_start();
include('menu.php');
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	class cURL
	{
		protected $_useragent = 'Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:53.0) Gecko/20100101 Firefox/53.0';
		protected $_url;
		protected $_followlocation;
		protected $_timeout;
		protected $_httpheaderData = array();
		protected $_httpheader = array('Expect:');
		protected $_maxRedirects;
		protected $_cookieFileLocation;
		protected $_post;
		protected $_postFields;
		protected $_referer ="https://www.google.com/";
 
		protected $_session;
		protected $_webpage;
		protected $_includeHeader;
		protected $_noBody;
		protected $_status;
		protected $_binary;
		protected $_binaryFields;
 
		public    $authentication = false;
		public    $auth_name      = '';
		public    $auth_pass      = '';
 
		public function __construct( $followlocation = true, $timeOut = 30, $maxRedirecs = 4, $binary = false, $includeHeader = false, $noBody = false )
		{
			$this->_followlocation = $followlocation;
			$this->_timeout = $timeOut;
			$this->_maxRedirects = $maxRedirecs;
			$this->_noBody = $noBody;
			$this->_includeHeader = $includeHeader;
			$this->_binary = $binary;
 
			$this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';
		}
 
		public function useAuth( $use )
		{
			$this->authentication = false;
			if($use == true) $this->authentication = true;
		}
 
		public function setName( $name )
		{
			$this->auth_name = $name;
		}
		public function setPass( $pass )
		{
			$this->auth_pass = $pass;
		}
 
		public function setReferer( $referer )
		{
			$this->_referer = $referer;
		}
 
		public function setHttpHeader( $httpheader=array() )
		{
			$this->_httpheader = array();
			foreach( $httpheader as $i=>$v )
			{
				$this->_httpheaderData[$i]=$v;
			}
			foreach( $this->_httpheaderData as $i=>$v )
			{
				$this->_httpheader[]=$i.":".$v;
			}
		}
 
		public function setCookiFileLocation( $path )
		{
			$this->_cookieFileLocation = $path;
			if ( !file_exists($this->_cookieFileLocation) )
			{
				file_put_contents($this->_cookieFileLocation,"");
			}
		}
 
		public function setPost( $postFields = array() )
		{
			$this->_binary = false;
			$this->_post = true;
			$this->_postFields = http_build_query($postFields);
		}
 
		public function setBinary( $postBinaryFields = "" )
		{
			$this->_post = false;
			$this->_binary = true;
			$this->_binaryFields = $postBinaryFields;
		}
 
		public function setUserAgent( $userAgent )
		{
			$this->_useragent = $userAgent;
		}
 
		public function createCurl( $url = 'nul' )
		{
			if($url != 'nul')
			{
				$this->_url = $url;
			}
 
			$s = curl_init();
			curl_setopt($s,CURLOPT_URL,$this->_url);
			curl_setopt($s,CURLOPT_HTTPHEADER,$this->_httpheader);
			curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
			curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
			curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
			curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
			curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);
 
			if($this->authentication == true)
			{
				curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
			}
 
			if($this->_post)
			{
				curl_setopt($s,CURLOPT_POST,true);
				curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
			}
 
			if($this->_binary)
			{
				curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
				curl_setopt($s,CURLOPT_POSTFIELDS, $this->_binaryFields);
				$this->setHttpHeader( array('Content-Length'=>strlen($this->_binaryFields)) );
			}
 
			if($this->_includeHeader)
			{
				curl_setopt($s,CURLOPT_HEADER,true);
			}
 
			if($this->_noBody)
			{
				curl_setopt($s,CURLOPT_NOBODY,true);
			}
 
			curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
			curl_setopt($s,CURLOPT_REFERER,$this->_referer);
			$this->_webpage = curl_exec($s);
			$this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
			curl_close($s);
		}
 
		public function getHttpStatus()
		{
			return $this->_status;
		}
 
		public function __toString()
		{
			return $this->_webpage;
		}
		// simplificado
		public function send($url, array $post = array() )
		{
			if( count($post)!=0 )
				$this->setPost( $post );
 
			$this->createCurl( $url );
			return $this->_webpage;
		}
		public function sendBinary($url,$binary="")
		{
			if( $binary != "" )
				$this->setBinary( $binary );
			$this->createCurl( $url );
			return $this->_webpage;
		}
	}

	class Sunat{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC( $ruc )
		{
			$numRand = $this->getNumRand();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$patron='/<input type="hidden" name="desRuc" value="(.*)">/';
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if(isset($matches[0]))
				{
					$RS = utf8_encode(str_replace('"','', ($matches[0][1])));
					$rtn = trim($RS);
                                        
				}
 
				
				
			}
			
				return $rtn;
			
			return false;
		}
	}



	class Sunat1{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand1()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC1( $ruc )
		{
			$numRand = $this->getNumRand1();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$patron='/<td class="bgn" colspan=1>Tel&eacute;fono\(s\):<\/td>[ ]*-->\r\n<!--\t[ ]*<td class="bg" colspan=1>(.*)<\/td>/';
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if( isset($matches[0]) )
				{
					$rtn = trim($matches[0][1]);
				}
 
				
				
			}
			
				return $rtn;
			
			
		}
	}
        
        
        class Sunat2{
		var $cc;  // cUrl
		function __construct()
		{
			$this->cc = new cURL();
		}
		function getNumRand2()
		{
			$url="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random";
			$numRand = $this->cc->send($url);
			return $numRand;
		}
		function getDataRUC2( $ruc )
		{
			$numRand = $this->getNumRand2();
			
			if($ruc != "" && $numRand!=false)
			{
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $numRand
				);
 
				$url = "http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->send($url,$data);
 
				//RazonSocial
				$busca=array(
					
					"Direccion" 			=> "Direcci&oacute;n del Domicilio Fiscal"
					
				);
				foreach($busca as $i=>$v)
				{
					$patron='/<td class="bgn"[ ]*colspan=1[ ]*>'.$v.':[ ]*<\/td>\r\n[\t]*[ ]+<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn = trim(utf8_encode( preg_replace( "[\s+]"," ", ($matches[0][1]) ) ) );
					}
				}
 
				
				
			}
			
				return $rtn;
			
			
		}
	}
 
$nombre=$_POST['nombre'];
$doc=$_POST['doc'];
$dni=$_POST['dni'];
$ven=$_POST['ven'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];
$direccion=$_POST['direccion'];
$departamento=$_POST['departamento'];
$provincia=$_POST['provincia'];
$distrito=$_POST['distrito'];
$cuenta=$_POST['cuenta'];
$aceptar=$_POST['aceptar'];
$ruc1=$_POST['ruc1'];
$tienda1=$_SESSION['tienda'];
$estado=intval($_POST['estado']);
date_default_timezone_set('America/Lima');
$date_added=date("Y-m-d H:i:s");
if($aceptar==1){

    $sql="INSERT INTO clientes values (NULL,'$nombre','$telefono','$email','$direccion','$estado','$date_added','$doc','$dni','$ven','Peru','$departamento','$provincia','$distrito','$cuenta','1','$tienda1','0','0','0','0')";
    
    if (mysqli_query($con,$sql)){
        header("location:clientes.php");
    } else{
        header("location:ingresocliente.php?accion=Cliente duplicado");
    }
		
}        
 

if($ruc1==1){

    $a1=$_POST['doc'];
    $cliente = new Sunat();
 	//$ruc="20549500553";
    $a2=$cliente->getDataRUC($a1);
    
    $clientes = new Sunat1();
 	//$ruc="20549500553";
    $a3=$clientes->getDataRUC1($a1);
    
    $clientes1 = new Sunat2();
 	//$ruc="20549500553";
    $a4=$clientes1->getDataRUC2($a1);
    
    $a5="";
    $a6="";
    $consulta1 = "DELETE FROM consultas";
    if (mysqli_query($con, $consulta1)) {
        header("location:ingresocliente.php");
    } else {
        die("No se pudo insertar2..");
    }   
    $consulta = "INSERT INTO consultas values (NULL,'30','$a1','$a2','$a3','$a4','$a5','$a6')";
    if (mysqli_query($con, $consulta)) {
        header("location:ingresocliente.php");
   } else {
        die("No se pudo insertar3..");
   } 
}   
 
?>



