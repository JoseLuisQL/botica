<?php
//https://api.sunat.cloud/ruc/10403322097
//https://eldni.com/buscar-por-dni?dni=46419110
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");
require_once ("menu.php");
$a2=recoge1('tip_doc');
$doc1=recoge1('doc1');
$nombre_cliente="";
$sql1="select * from clientes where documento=$doc1";
$rw1=mysqli_query($con,$sql1);//recuperando el registro
$rs1=mysqli_fetch_array($rw1);//trasformar el registro en un vector asociativo
$nombre_cliente=$rs1["nombre_cliente"];
$direccion_cliente=$rs1["direccion_cliente"];
$telefono_cliente=$rs1["telefono_cliente"];
$email_cliente=$rs1["email_cliente"];

if($nombre_cliente<>""){
    echo "$nombre_cliente|$direccion_cliente|$telefono_cliente|$email_cliente";
}else{
    
if($a2==2){
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
			
				//return $rtn;
			
			
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
    
    
$a1=recoge1('doc1');
$cliente = new Sunat();
 	//$ruc="20549500553";
    $a5=$cliente->getDataRUC($a1);
    $a5 = str_replace("&",'',$a5);
//$porciones = explode("</font>", $a5);
//$a5=$porciones[1];
    //print"$a5";
    $clientes = new Sunat1();
 	//$ruc="20549500553";
    $a3=$clientes->getDataRUC1($a1);
    
    $clientes1 = new Sunat2();
 	//$ruc="20549500553";
    $a4=$clientes1->getDataRUC2($a1);
    $a4 = str_replace("&",'',$a4);
    //$a5 = str_replace("&","",$a2);

echo "$a5|$a4||";
}

if($a2==1){
    
//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
//while(!feof($fp)) {
$dni = $_POST['doc1'];
$fp = fopen("https://eldni.com/buscar-por-dni?dni=$dni","r");
//$fp = fopen($doc, "r");
    for ($i = 0; $i <= 150; $i++) {
        $EstWebs[$i] = fgets($fp);
    }
    fclose($fp);



$a1= trim(strip_tags($EstWebs[139])) ;
$a2= trim(strip_tags($EstWebs[140])) ;
$a3= trim(strip_tags($EstWebs[141])) ;
$a4= trim(strip_tags($EstWebs[142])) ;
$a5=trim($a1." ".$a2." ".$a3." ".$a4);
echo "$a5|||";
}
}
?>