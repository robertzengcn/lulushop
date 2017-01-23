<?php /*
=================================================
=== PIG version 0.3.2.1 from 13 Aug 2013
=== Ecommerce Inc.
=== Updated by: James Holt
=== Changes from pig-0.3.2.0:
=================================================
=== Added compatibility for PHP 5.4 - Thanks Sergey Nosko!
=================================================
*/ ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"
        "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>		
	<HEAD>
		<STYLE TYPE="text/css">
			div { display: inline-block; }
			.green { color : green; }
			.red { color : red; }
			.bold { font-weight: bold; }
			.italic { font-style: italic; }
			#pig {
				position: fixed;
				right: 10px;
				bottom: 10px;
			}
		</STYLE>
		<script>
			var iniDefault={
				'mbstring.language': 'Japanese',
				'mbstring.http_input': 'auto',
				'mbstring.http_output': 'SJIS',
				'session.save_path': '',
				'upload_max_filesize': '2M',
				'post_max_size': '8M',
				'memory_limit': '24M'
			};
			var iniRec={
				'mbstring.language': 'Neutral',
				'mbstring.http_input': 'pass',
				'mbstring.http_output': 'pass',
				'session.save_path': '',
				'upload_max_filesize': '25M',
				'post_max_size': '30M',
				'memory_limit': '32M'
			};
			function SetParams(params){
				for(var prop in params){
					var name='parameter['+prop+']';
					document.getElementsByName(name)[0].value = params[prop];
				}
			}
		</script>
	</HEAD>
	<BODY id="body">

<?php
//PHP 4 MISSING FUNCTIONS
if(!function_exists('stripos')){
	function stripos($haystack, $needle,$offset=0){
		return strpos(strtolower($haystack), strtolower($needle), $offset);
	}
}
	
if(!function_exists('file_put_contents')){
    function file_put_contents($filename,$data){
        $f = @fopen($filename, 'w');
        if(!$f){
            return false;
        }else{
            $bytes = fwrite($f, $data);
            fclose($f);
            return $bytes;
        }
    }
}

if(!function_exists('file_get_contents')){
	function file_get_contents($filename){
		$f = @fopen($filename, 'r');
	    if(!$f){
	        return false;
	    }else{
			$content = fread($f, filesize($filename));
			fclose($f);
			return $content;
		}
	}
}

if(!defined('PHP_MAJOR_VERSION')){
	$phpver=explode('.',PHP_VERSION);
	define('PHP_MAJOR_VERSION',$phpver[0]);
	define('PHP_MINOR_VERSION',$phpver[1]);
	if(isset($phpver[2])){define('PHP_RELEASE_VERSION',$phpver[2]);}
}

if(function_exists('date_default_timezone_set'))
	date_default_timezone_set('America/New_York');


//DEFINITIONS
define('DEBUG', false);
define('VERSION', '0.3.2.1');
define('UPDATEDOMAIN', 'linker.ixtestdomain.com');
define('DIRSCANFN', 'pig-dirscan.pl');

define('WIN','WINNT');
define('LINUX','Linux');
define('N','<br>');
define('DS', PHP_OS == WIN ? "\\" : "/" );
//debug levels:
define( 'INFO', 0 );
define( 'WARN', 1 );
define( 'ERR', 2);

if( DEBUG )
	ini_set( 'display_errors', '1' );

if( PHP_MAJOR_VERSION == '4' )
{ set_error_handler("myErrorHandler"); }//In PHP4 there should be only one argument
else
{ set_error_handler("myErrorHandler", E_WARNING); }
	
LogEvent("QUERY_STRING: " . $_SERVER['QUERY_STRING']);

$controlpanelarr = array(
	1 => array("iis5","iis12","iisn101","iisn102","iisn103","iisn104","iisn105","web57","web58","web98","web107","web160","web218","web224","web236","web250","web254","web257","web1000"),
	2 => array("iisn201","iisn202","iisn203","iisn204","iisn205","iisn206","web208","web256","web258"),
	3 => array("iisn301","iisn302","iisn303","iisn304","iisn305","iisn306","iisn307","iisn308","iisn309","iisn310","iisn311","web252","web259"),
	4 => array("iishstest","iisn401","iisn402","iisn403","iisn404","iisn405","iisn406","iisn407","iisn408","iisn409","iisn410","iisn411","iisn412","iisn413","web245","web255","web260"),
	5 => array("iis132","iis133","iis134","iis138","iis139","iis140","web215","web216","web217","web222","web223","web228","web229","web230","web231","web232","web233","web234","web235","web239","web240","web241","web242","web243","web244","web247","web248","web249","web261")
);

$phpvars=array(
	"4.4"=>array(
		"ini"=>"/hsphere/local/config/httpd/php4/php.ini",
		"cgi"=>array(
			"server"=>"/hsphere/shared/php4/bin/php-cgi",
			"local"=>'php4-custom-ini.cgi',
			"code"=>"#!/bin/sh\nexport PHP_FCGI_CHILDREN=3\nexec /hsphere/shared/php4/bin/php-cgi -c "
		),
		"htaccess"=>array(
			"code"=>"AddHandler phpini-cgi .php\nAction phpini-cgi /cgi-bin/php4-custom-ini.cgi\n\n",
			"search"=>"@(?<!#)AddHandler\s+phpini-cgi\s+\.php(?:\s+\.html?)?\s+Action\s+phpini-cgi\s+/cgi-bin/php4-custom-ini\.cgi\n*@ims"
		)
	),
	"5.2"=>array(
		"ini"=>"/hsphere/local/config/httpd/php5/php.ini",
		"cgi"=>array(
			"server"=>"/hsphere/shared/php5/bin/php-cgi",
			"local"=>'php5-custom-ini.cgi',
			"code"=>"#!/bin/sh\nexport PHP_FCGI_CHILDREN=3\nexec /hsphere/shared/php5/bin/php-cgi -c "
		),
		"htaccess"=>array(
			"code"=>"AddHandler phpini-cgi .php\nAction phpini-cgi /cgi-bin/php5-custom-ini.cgi\n\n",
			"search"=>"@(?<!#)AddHandler\s+phpini-cgi\s+\.php(?:\s+\.html?)?\s+Action\s+phpini-cgi\s+/cgi-bin/php5-custom-ini\.cgi\n*@ims"
		)
	),
	"5.3"=>array(
		"ini"=>"/hsphere/shared/php53/etc/php.ini",
		"cgi"=>array(
			"server"=>"/hsphere/shared/php53/bin/php-cgi",
			"local"=>'php53.cgi',
			"code"=>"#!/bin/sh\nexport PHP_FCGI_CHILDREN=3\nexec /hsphere/shared/php53/bin/php-cgi "
		),
		"htaccess"=>array(
			"code"=>"AddHandler php53 .php\nAction php53 /cgi-bin/php53.cgi\n\n",
			"search"=>"@(?<!#)AddHandler\s+php53\s+\.php(?:\s+\.html?)?\s+Action\s+php53\s+/cgi-bin/php53\.cgi\n*@ims"
		)
	),
	"5.4"=>array(
		"ini"=>"/hsphere/shared/php54/etc/php.ini",
		"cgi"=>array(
			"server"=>"/hsphere/shared/php54/bin/php-cgi",
			"local"=>'php54.cgi',
			"code"=>"#!/bin/sh\nexport PHP_FCGI_CHILDREN=3\nexec /hsphere/shared/php54/bin/php-cgi "
		),
		"htaccess"=>array(
			"code"=>"AddHandler php54 .php\nAction php54 /cgi-bin/php54.cgi\n\n",
			"search"=>"@(?<!#)AddHandler\s+php54\s+\.php(?:\s+\.html?)?\s+Action\s+php54\s+/cgi-bin/php54\.cgi\n*@ims"
		)
	)

);

//determine available PHP versions
$phpavail=array();
foreach($phpvars as $ver=>$args){
	if(file_exists($args['cgi']['server'])){
		$phpavail[$ver]=(PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION==$ver)?" checked='checked'":"";
	}
}



ob_start(); 
phpinfo(); 
$phpinfo_full = ob_get_clean(); 
//ob_end_clean(); 
$phpinfo = preg_replace ('/<[^>]*>/', '', $phpinfo_full);

$step=isset($_POST['step'])?$_POST['step']:1;
$phpverselected=isset($_POST['phpverselected'])?$_POST['phpverselected']:"";

$logFH = NULL;
$serverdomainname=GetServerDomainName($phpinfo_full);
$controlpanel = GetCPNumber($serverdomainname,$controlpanelarr);
$serverphpinipath='';
GetServerPhpIniPath($phpvars);
$loadedphpinipath=version_compare(PHP_VERSION,'5.2.4','>=') ? php_ini_loaded_file() : 'N/A, PHP ver<5.2.4';
if($loadedphpinipath===false) $loadedphpinipath="(none)";
$php_ini_contents='';
$php_ini_contents_arr=array();
$wasNewLine = true;
preg_match(PHP_OS==LINUX?'#/hsphere/local/home/([^/]*)/([^/]*)/([^/]*)#':'/d:\\\\hshome\\\\([^\\\\]*)\\\\([^\\\\]*)\\\\([^\\\\]*)/i',__FILE__,$matches);
$username=$matches[1];
$domainname=$matches[2];
$rootdir=PHP_OS==LINUX?'/hsphere/local/home/':'d:\\hshome\\';
$rootdir.=$username;
$tmpdir=PHP_OS==LINUX?'/tmp/':'C:\\WINDOWS\\TEMP\\';
$phpinipath=SetPhpIniPath($domainname);
srand();
$inodeQuota = 0;
$inodeFiles = 0;
$overQuota = false;

//PERL script for Windows - resturns domain list in JSON format
$dirScanFileContent = '
#!c:\\perl\\perl
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\\n\\n";
$rootdir = \'' . addslashes($rootdir) . '\';
opendir(DH, $rootdir);
@dirContent = readdir DH;
print(\'{"domains":[\');
foreach(@dirContent)
{
	if( -d $rootdir.\'\\\\\'.$_ ) 
		{ print(\'"\'.$_.\'",\'); }
}
print("]}");
';

//Added at the beginning of each generated php.ini file
$phpIniHeader = 
';                           |PIG v' . VERSION . '|
';

//<!-- ----------------------- FUNCTIONS ---------------------- -->

//Error handling
function myErrorHandler($errNumber, $errMessage, $errFile, $errLine, $errContext)
{
echo "<div class='bold'>ERROR </div>at line $errLine: $errMessage<br>Context:<br><pre>";
var_dump($errContext);
echo "</pre>";
}

//General Functions
function nop()//used as placeholder where nothing to do but should be anything(like condition()?(nothing):(something))
{}

function GetQuota()
{
	global $inodeQuota, $inodeFiles, $overQuota;
	if( PHP_OS == LINUX )
	{
		ob_start();
		echo "<pre>";
		system('quota -s');
		$sQuota = ob_get_clean();
		$aQuota = split("\n", $sQuota);
		$sKey = $aQuota[1] . ' ';
		$sVal = $aQuota[2] . ' ';
		$isLimit = false;
		do
		{
			$sKey = ltrim($sKey);
			$isElementFound =   $sKey != '';
			$isNull = false;
			if($isElementFound)
			{	
				$iKeyLen = strcspn($sKey, ' ');
				$aKey[] = substr($sKey, 0, $iKeyLen);
				if( trim(substr($sVal, 0, $iKeyLen)) == '' )//check if there's empty value under the Key
				{
					$sVal = ltrim($sVal);
					$isNull = true;
					$iValLen = $iKeyLen;
					$aVal[] = '';
				}
				else
				{
					$isNull = false;
					$sVal = ltrim($sVal);
					$iValLen = strcspn($sVal, ' ');
					$aVal[] = substr($sVal, 0, $iValLen);//Extract value
				}
				//Delete extracted value from start of string
				if( ! $isNull)//otherwise it has been already trimmed
					$sVal = substr($sVal, $iValLen, strlen($sVal) - $iValLen);
				$sKey = substr($sKey, $iKeyLen + 1, strlen($sKey) - $iKeyLen);
			}
		}
		while ($isElementFound);
		
		$aQuota['Key'] = $aKey;
		$aQuota['Val'] = $aVal;
		$inodeFiles = $aQuota['Val'][5];
		$inodeQuota = $aQuota['Val'][7];
		$overQuota = str_replace('k', '000', $inodeFiles) > str_replace('k', '000', $inodeQuota) ? true : false;
	}
}

function SetPhpIniPath($domainname)
{
	$domaindir = $rootdir . DS . $domainname;
	if(PHP_OS==LINUX)//detect php.ini path, root dir and domain dir
	{
		return $domaindir.'/cgi-bin/php.ini';
	}else{
		return $domaindir.'\\php'.PHP_MAJOR_VERSION.'.ini';
	}
}

function LogEvent( $event )
{
	if( DEBUG )
	{
		global $logFH;
		
		if( is_null($logFH) )
		{
			$logFH = fopen("pig.log", "a");
			$date = date("Y-m-d   H:i:s");
			fputs($logFH, "--------------------- LogStart: $date ---------------------\n");
		}
		
		fputs($logFH, $event . "\n");
	}
}

function LogMsg ( $text, $newLine = true, $logLevel = INFO )
{
	if ( DEBUG )
	{
	global $wasNewLine;
	if( $wasNewLine) 
		echo 'Log: ';
	
		switch ( $logLevel )
		{
			case INFO:
				echo '<div class=\'bold\'' . $text . '</div>';
				break;
			
			case WARN:
				echo '<div class=\'green>\'\>' . $text . '</div>';
				break;
				
			case ERR:
				echo '<div class=\'red\'\>' . $text . '</div>';
				break;
			default:
				echo "uhoh... known log level $logLevel... message: $text";
				break;
		}//switch
		
		if( $newLine ) 
		{ 
			echo N;
			$wasNewLine = true;
		}//if( $newLine ) 
		else
		{
			$wasNewLine = false;
		}
		
	}//if ( DEBUG )
	
}//Log()



function PlaceCustomPhpIni($domain)
{
	
	global $php_ini_contents;
	global $set_postmaster;
	global $phpinipath;
	global $doNothing;
	global $rootdir;
	
	$phpinipath=SetPhpIniPath($domain);
	LogMsg("PlaceCustomPhpIni: $domain: $rootdir.DS.$phpinipath", true, WARN );
	if( $set_postmaster )
		switch (PHP_OS)
		{
			case WIN: UpdateParameter('sendmail_from','postmaster@'.$domain); break;
			case LINUX: UpdateParameter('sendmail_path','/usr/sbin/sendmail -t -i -fpostmaster@'.$domain); break;
		}
	if( DEBUG ) echo '<PRE>' . $php_ini_contents . '</PRE><BR>';
	$doNothing ? nop() : file_put_contents( $rootdir.DS.$phpinipath, $php_ini_contents );
}

function PlaceCustomcgi($domain)
{
	
	global $controlpanel;
	global $phpvars;
	global $php_ini_contents;
	global $rootdir;
	global $phpinipath;
	global $doNothing;
	global $phpverselected;
	
	$domaindir = $rootdir . DS . $domain;
	$phpinipath=SetPhpIniPath($domain);
	$path=$domaindir.'/'.'cgi-bin';
	LogMsg("PlaceCustomcgi: $domain: $path", true, WARN );
	if(PHP_OS==LINUX)
	{
		
		if( ! $doNothing ) 
		{
			file_exists($path) ? nop() : mkdir( $path );
			chmod($path,0755);
		}
		
		if($controlpanel >= 6)
		{
			if( ! $doNothing )
			{
				file_put_contents($path.'/'.$phpvars[$phpverselected]['cgi']['local'],$phpvars[$phpverselected]['cgi']['code'] . $rootdir . DS . $phpinipath);
				chmod($path.'/'.$phpvars[$phpverselected]['cgi']['local'],0755);
			}
		}//controlpanel>=6
	}//LINUX
}

function Placehtaccess($domain)
{
	
	global $controlpanel;
	global $phpvars;
	global $rootdir;
	global $doNothing;
	global $phpverselected;
	
	$domaindir = $rootdir . DS . $domain;
	$path=$domaindir.'/'.'cgi-bin';
	LogMsg("Placehtaccess: $domain: $path", true, WARN );
	if(PHP_OS==LINUX)
	{
		
		if( ! $doNothing ) 
		{
			file_exists($path) ? nop() : mkdir( $path );
			chmod($path,0755);
		}
		
		if($controlpanel >= 6)
		{
			if(file_exists($domaindir.'/.htaccess'))
			{
				//search for other handlers; if found - replace
				$htacontent=file_get_contents($domaindir.'/.htaccess');
				$replaced=false;
				foreach($phpvars as $ver=>$args){
					if($phpverselected==$ver){
						//do nothing
					}else{
						if(preg_match($phpvars[$ver]['htaccess']['search'],$htacontent))
						{
							$htacontent=preg_replace($phpvars[$ver]['htaccess']['search'],$phpvars[$phpverselected]['htaccess']['code'],$htacontent);
							LogMsg( '** Handler Replaced: $ver' );
							$replaced=true;
						}
					}
				}
				//check if correct handler exists; if not - add it
				if(!preg_match($phpvars[$phpverselected]['htaccess']['search'],$htacontent))
				{
					$htacontent=$phpvars[$phpverselected]['htaccess']['code']."\n$htacontent";
				}
				else//php handler in htaccess found
				{
					LogMsg( '** Handler Found: $phpverselected' );
				}
			}
			else//htaccess not exists
			{
				$htacontent=$phpvars[$phpverselected]['htaccess']['code'];
			}
			if( ! $doNothing )
			{
				file_put_contents($domaindir.'/.htaccess',$htacontent);
			}
		}//controlpanel>=6
	}//LINUX
}

function UpdateParameter( $key, $value)
	{
		if( $key )
		{
			LogMsg( "UpdateParameter:: Updating: $key = $value: ", false);
			
			global $php_ini_contents;
			global $php_ini_contents_arr;
			if ( $value == null && $value !== '') 
				$value = 0;
			elseif ( $value === '') 
				$value = '';
				
			if ( ( stristr( $php_ini_contents, $key ) != false ) && ( $key != 'zend_extension' ) )//key exists: change the value
			{
				LogMsg( 'Replace' );
				$php_ini_contents = preg_replace( '/^.*' . $key . '[^=]*=.*$/im', '  ' . $key . ' = ' . $value, $php_ini_contents );
				$php_ini_contents_arr = explode( "\n", $php_ini_contents );
			}
			
			else//add the new key
			
			{
				LogMsg( 'Add' );
				$arr = array();
				$w = 0;
				
				for( $q=0; $q < count( $php_ini_contents_arr ); $q++)
				{
					$arr[ $w ] = $php_ini_contents_arr[ $q ];
					LogMsg( '	UpdateParameter:: $arr[ $w ] = ' . $arr[ $w ] );
					switch ( $key ) 
					{
						case 'sendmail_from':
							if ( strcmp( $arr[ $w ], '[mail function]' ) == 0 )
							{
								LogMsg( 'UpdateParameter:: [mail function] section found' );
								$w++;
								$arr[ $w ] = '  ' . $key . ' = ' . $value;
							}
							break;
							
						case 'zend_extension':
							if( strcmp( $arr[ $w ], '[Zend]' ) == 0)
							{
								LogMsg('UpdateParameter:: [Zend] section found');
								$my_custom_variable = '  ' . $key . ' = ' . $value; // code added 
								if (in_array($my_custom_variable, $arr)) { $w++; } // if added here
								$arr[ $w ] = '  ' . $key . ' = ' . $value;
							}
							break;

						default:
							if( strcmp( $arr[ $w ], '[PHP]') == 0)
							{
							LogMsg( 'UpdateParameter:: [PHP] section found' );
							$w++;
							$arr[ $w ] = '  ' . $key . ' = ' . $value;
							}
					}//switch
					
					$w++;
				}//for
				
				$php_ini_contents = implode( "\n", $arr );
			}//else: add new key
				
		}//if($key)
		
	}//function
	
function GetServerDomainName($phpinfo_full){//(C) Code by Roman Rott
	$phpinfo = array('phpinfo' => array());
	if(preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', $phpinfo_full, $matches, PREG_SET_ORDER))
	foreach($matches as $match)
		if(strlen($match[1]))
			$phpinfo[$match[1]] = array();
		elseif(isset($match[3]))
			$phpinfo[end(array_keys($phpinfo))][$match[2]] = isset($match[4]) ? array($match[3], $match[4]) : $match[3];
		else
		   $phpinfo[end(array_keys($phpinfo))][] = $match[2];
	preg_match('/.+(((web)|(iis)|(iis))[^\s]+)\s.*/i',$phpinfo['phpinfo']['System'],$matches);
		if(!stripos($matches[1],'opentransfer.com')&&$matches[1]!='')$matches[1]=$matches[1].'.opentransfer.com';
		$matches[1]=strtolower($matches[1]);
	return $matches[1]!=''?$matches[1]:false;
}

function GetCPNumber($serverDomainName,$controlpanelarr){
	global $controlpanelarr;
	preg_match('/[^\d]+(\d{0,4})/', $serverDomainName, $matches);
	$serverNumber = $matches[1];//matches '123' in 'iis123.opentransfer.com'
	$serverName = $matches[0];//matches 'iis123' in 'iis123.opentransfer.com'
	$CP = 0;
	if( $serverNumber >= 300 && $serverNumber < 600) 
	    $CP = floor($serverNumber/100) + 3;
	elseif($serverNumber >= 900)
	    $CP = floor($serverNumber/100);
	else
		for( $i = 1; $i <= 5; $i++ )
			if( in_array($serverName, $controlpanelarr[$i]) )
				$CP = $i;
	if( 0 == $CP)
	$CP = "1-CP5 Possible iisnXXX server";		
	return $CP;
}

function GetDirList()
{
	global $dirScanFileContent;
	global $rootdir, $domainname;
	
	LogEvent("GetDirList()");
	
	if( PHP_OS == 'WINNT' )
	{
		file_put_contents(DIRSCANFN, $dirScanFileContent);
		echo "<script>AJAXGetDirList('" . DIRSCANFN . "');</script>"; // call AJAX function to retrieve directory listing
	}
	else
	{
		$dh = opendir($rootdir);
		$json = '{"domains":['; // format data for JS update script
		while( $el = readdir($dh) ){
			if( $el != '..' && is_dir($rootdir . '/' . $el) &&   preg_match("/^[a-z0-9\.-]+\.[a-z0-9-]+$/",$el) &&   $el != "ssl.conf" )
				$json .= '"' . $el . '",';
		}
		$json .= ']}';
		echo "<script>UpdateDirList('$json');</script>"; // call JS function with formed JSON string
	}
}

function GetServerPhpIniPath($phpvars)
{
	global $serverphpinipath,$serverphpinifolder,$phpverselected,$phpinfo;

	LogEvent("GetServerPhpIniPath()");

	if($phpverselected!=""){
		$serverphpinipath=$phpvars[$phpverselected]['ini'];
	    $serverphpinifolder = dirname($serverphpinipath);
	}elseif(PHP_MAJOR_VERSION=='5' && PHP_MINOR_VERSION=='4' && PHP_OS==LINUX){
		$serverphpinipath=$phpvars['5.4']['ini'];
	    $serverphpinifolder = dirname($serverphpinipath);
	}elseif(PHP_MAJOR_VERSION=='5' && PHP_MINOR_VERSION=='3' && PHP_OS==LINUX){
		$serverphpinipath=$phpvars['5.3']['ini'];
	    $serverphpinifolder = dirname($serverphpinipath);
	}elseif(PHP_MAJOR_VERSION=='5' && PHP_MINOR_VERSION=='2' && PHP_OS == LINUX){
		$serverphpinipath=$phpvars['5.2']['ini'];
	    $serverphpinifolder = dirname($serverphpinipath);
	}elseif(PHP_MAJOR_VERSION=='4' && PHP_OS == LINUX){
		$serverphpinipath=$phpvars['4']['ini'];
	    $serverphpinifolder = dirname($serverphpinipath);
	}elseif( (PHP_MAJOR_VERSION == '4')   ||   (PHP_OS == LINUX   &&   PHP_MAJOR_VERSION == '5') ){
		LogEvent("--- PHP version 4 Windows");
		preg_match ('/Loaded\ Configuration\ File[ \t]*([^\t\n]*)/', $phpinfo, $matches);
		$serverphpinipath = isset($matches[1])?trim($matches[1]):'(none)';
		preg_match ('/Configuration\ File\ \(php\.ini\)\ Path[ \t]*([^\t\n]*)/', $phpinfo, $matches);
		$serverphpinifolder = trim($matches[1]);
		if($serverphpinipath=='(none)') 
		    $serverphpinipath=$serverphpinifolder;
	}
	else
	{ 	
	    $serverphpinipath = php_ini_loaded_file(); 
	    $serverphpinifolder = dirname($serverphpinipath);
	}
		
	LogEvent("--- \$serverphpinipath = $serverphpinipath");

	/*Here we need to check if php.ini was loaded from domain folder. If it is so - some settings may be incorrect, 
	we need original file from the server, so this one should be renamed. We will rename it back after script
	will be reloaded.*/
/*	if( stristr($serverphpinipath, $domainname))
	{
		LogEvent("--- $domainname found in \$serverphpinipath");
		if(!stristr(ini_get('open_basedir'),$serverphpinifolder)){
		    global $php_ini_contents;
			global $php_ini_contents_arr;
		    $php_ini_contents='';
		    LoadPhpIni($php_ini_contents);
		    UpdateParameter( 'open_basedir', '' );
		    file_put_contents( $serverphpinipath, $php_ini_contents );
		}
		rename($serverphpinipath, $serverphpinipath . '.old');
		
		$char =   $_SERVER['QUERY_STRING'] == '' ? '' : '&';
		$refreshURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . $char . 'rename=' . base64_encode($serverphpinipath);
		LogEvent("--- Redirect: $refreshURL");
		?>
			<script>
			window.location = '<?=$refreshURL;?>';
			</script>
		<?php
		exit;
	}
	
	if( strstr($serverphpinipath,'.ini') == false )
	{
		LogEvent("--- .ini part not found in $serverphpinipath");
		$serverphpinipath .= DS . 'php.ini';
		LogEvent("--- New value: $serverphpinipath");
	}
	
	if( isset($_GET['rename']) )//Rename back previously renamed file
	{
		$fn = base64_decode($_GET['rename']);
		LogEvent("--- Renaming from $fn.old to $fn");
		rename($fn . '.old', $fn);
	}	
*/
}

function renamePhpIni($phpinipath){
	rename($phpinipath, $phpinipath.'.'.date("Ymd_Hi"));
}

function LoadPhpIni(&$contents)
{
	global $serverphpinipath;
	global $php_ini_contents_arr;
	global $domainname;
	global $controlpanel;
	global $phpIniHeader;
	LogMsg( 'LoadPhpIni:: $serverphpinipath = ' . $serverphpinipath );
	$contents = file_get_contents( $serverphpinipath );
	if( $contents == '' ) die('No content: ' . $serverphpinipath);
	if(strpos($contents, $phpIniHeader)===FALSE)
		$contents = $phpIniHeader . $contents;
	$php_ini_contents_arr = explode( "\n", $contents);
}

function reprint_post_inputs($k,$v){
	if(is_array($v)){
		foreach($v as $k2=>$v2)
			reprint_post_inputs($k.'['.$k2.']',$v2);
	}else{
		echo "<input type='hidden' name='$k' value='$v'>\n";
	}

}

// #################### CHECK IF CURRENT SERVER USE HTSCANNER MODULE TO PROCESS PHP SETTINGS ####################
function CheckHtscanner()
{
	global $phpinipath;
	
	$isHtscanner = false;
	ob_start();
	phpinfo();
	$phpinfo = ob_get_clean();
	if(strstr($phpinfo, 'htscanner'))
	{
		$isHtscanner = true;
		?>
		<script>
		document.getElementById('htscanner').innerHTML = '<red>HTSCANNER</red>'; // inform user about it
		document.getElementById('submit').disabled = false; // changing settings through .htaccess is not implemented
		</script>
		<?php
	}
	
	return $isHtscanner;
}

?>
<script>
var cbflag=true;
var fcbPostmaster=true;
var sDefaultSendmailFrom='';
var iDomainsChecked=999;//value doesn't make sense, this is only for function to determine it should be initialized
//Modified code from: http://www.citforum.ru/internet/javascript/dynamic_form/
var c=0;
function addline()
{
	c++;
	newline='<TR><TD><INPUT TYPE="text" NAME="add_param_name['+c+']"> = <TD><INPUT TYPE="text" NAME="add_param_val['+c+']">';
	s=document.getElementById('table').innerHTML;
	s=s.replace(/[\r\n]/g,'');
	
	re=/(.*)(<\/TBODY>.*)/i; 
	s=s.replace(re,'$1'+newline+'$2');
	document.getElementById('table').innerHTML=s;
	return false; 
}

function DomainClick(cbnum)
{
if(iDomainsChecked==999)iDomainsChecked=document.form.cb.length;
if(iDomainsChecked==1)//if at start this eq to 1 than after processing it will certainly change, disallow manual edit of sendmail_from
{
document.getElementById('tSendmailFrom').disabled=true;
document.getElementById('tSendmailFrom').value='<leave unchanged>';
}
if(document.form.cb[cbnum].checked==true)
{iDomainsChecked++;}else{iDomainsChecked--;}
if(iDomainsChecked==1)//Only one domain chosen, allow manually modify sendmail_from
{
document.getElementById('tSendmailFrom').disabled=false;
}
//Check "All" button if all domains checked one by one, uncheck if all unchecked
if(iDomainsChecked==0)document.getElementById('cbAll').checked=false;
if(iDomainsChecked==document.form.cb.length)document.getElementById('cbAll').checked=true;
}

function SetDefaultSendmailFrom(value)
{sDefaultSendmailFrom=value;}

function Swap(field)
{
	if(!cbflag)
		{
		for (i = 0; i < field.length; i++)
			field[i].checked = true ;
		iDomainsChecked=field.length;
		}
	else
		{
		for (i = 0; i < field.length; i++)
			field[i].checked = false ;
		iDomainsChecked=0;
		}
cbflag=!cbflag;
}

function SwapPostmaster(){
	var s;
	if(fcbPostmaster){
		if(iDomainsChecked==1){
			s=sDefaultSendmailFrom
		}else{
			s='<leave unchanged>';
		}
		document.getElementById('tSendmailFrom').value=s;
	}else{
		sPostmaster=document.getElementById('tSendmailFrom').value;
		document.getElementById('tSendmailFrom').value='postmaster@<domain.com>';
	}
	fcbPostmaster=!fcbPostmaster;
}



//		UPDATE DIRECTORY LIST SECTION IN THE TABLE
//		JSON - JSON object from which domain list will be retrieved

function UpdateDirList(JSON)
{
	cell = document.getElementById('domains');
	if( JSON == '' )
		{ JSON = '{"domains":["<?=$domainname;?>"]}'; }
	else
		{ cell.innerHTML = ''; }
	obj = eval( "(" + JSON + ")" );
	REdomain = /\w+\.\w+/;
	for ( var i = 0; i < obj.domains.length; i++ )
	{
		if( 
			obj.domains[i] != '.'   &&
			obj.domains[i] != '..'  &&
			REdomain.exec(obj.domains[i]) != null
		)
			{ cell.innerHTML = cell.innerHTML + '<INPUT TYPE="checkbox" ID="cb" NAME="domain[' + i + ']" VALUE="' + obj.domains[i] + '" ONCLICK=DomainClick(' + i + ') CHECKED> ' + obj.domains[i] + '<BR>'; }
	}

}



//		GET DIRECTORY LISTING IN JSON FORMAT FROM PERL SCRIPT. USED ON WINDOWS TO TRICK RESTRICTED ACCESS TO USERS'S FOLDER FOR PHP 
//		filename - PERL SCRIPT FILE GOING TO BE EXECUTED

function AJAXGetDirList(filename)
{
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if( xmlhttp.readyState == 4 )
		{
			cell = document.getElementById('domains');
			cell.innerHTML = '';
			if( xmlhttp.status != 200 )
			{
				cell.innerHTML = '<span style="color:red">There was an error retrieving directory listing.<br> Probably PERL does not work. Please make sure PERL works for this domain<br></span>';
				UpdateDirList('');
			}
			else
				{ UpdateDirList(xmlhttp.responseText); }
		}
	}
	xmlhttp.open("GET", filename, true);
	xmlhttp.send(null);
}

function AJAXGenPHPInfo()
{
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
	{
		if( xmlhttp.readyState == 4 )
		{
			div = document.getElementById('dPHPInfo');
			if( xmlhttp.status != 200 )
				{ text = '<span style="color:red">There was an error generating phpinfo()</span>'; }
			else
				{ text = xmlhttp.responseText; }
			div.innerHTML = text;
		}
	}
	xmlhttp.open("GET", '<?=$_SERVER['PHP_SELF'];?>?genPHPInfo', true);
	xmlhttp.send(null);
}

</script>


<?php
//This block appears here to prevent doubled Ecommerce logo in ouput
if( isset($_GET['genPHPInfo']) )
{
	$content = '<? phpinfo(); ?>';
	file_put_contents('phpinfo.php', $content);
	if( preg_match('/' . $domainname . '(.*)/', __FILE__, $matches) == 0 )
		{ $path = dirname($matches[1]); }
	else
		{ $path = '/'; }
	echo 'http://' . $_SERVER['HTTP_HOST'] . $path . 'phpinfo.php';
	exit;
}
?>

<IMG ALIGN="RIGHT" ALT="Ecommerce logo" WIDTH=140 HEIGHT=76 SRC="http://api.crmyknife.com/res/img/ecommerce.gif">

<IMG id="pig" ALT="PIG logo" WIDTH=80 HEIGHT=80 SRC="http://api.crmyknife.com/res/img/pig.jpg">

<?php

//<!-- ----------------------- MAIN -------------------- -->

//IMPLEMENTATION
//Clicked "Show Me" button - show only phpinfo()
if(isset($_GET['show_phpinfo']))
{
	phpinfo();
	exit();
}
	
if(isset($_GET['btnSuicide']))
{
	$suicidesuccessful=(PHP_OS == WIN )? unlink($_SERVER['PATH_TRANSLATED']) : unlink($_SERVER['SCRIPT_FILENAME']);
	echo $suicidesuccessful?'<script>alert("Suicide Successful");</script>':'<script>alert("Suicide Failed - Please delete manually");</script>';
	exit();
}

//Normal behavior
if(isset($_POST['submit'])){
		$doNothing = isset($_POST['do_nothing']);
		if( $doNothing )
		LogMsg( 'PIG: I\'m not going to make any changes to filesystem.', true, WARN );

		// Halt if nothing was selected
		if( ! isset($_POST['domain']) )
		{
			echo '
			No domains specified, nothing to do
			<form>
			<p><input type="submit" value="<< Back"></p>
			</form>
			';
			exit;
		}

		// Remove PERL script file if it was created
		if( file_exists(DIRSCANFN) )
			unlink(DIRSCANFN);

		// downloading ioncube if not already installed
		if( isset($_POST['ioncube']) && !file_exists($rootdir."/ioncube")){
		    $ch = curl_init("http://downloads2.ioncube.com/loader_downloads/ioncube_loaders_lin_" . $_POST['ioncube'] . ".tar.gz");
		    $fp = fopen($rootdir  . "/ioncube.tar.gz" , "w");
		    curl_setopt($ch, CURLOPT_FILE, $fp);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    curl_exec($ch);
		    curl_close($ch);
		    fclose($fp);
		    if ( filesize($rootdir  . "/ioncube.tar.gz" ) > 1000 ) 
		    { 
		      print ("Downloading ioncube.zip : <font color='green'><div class='bold'>[ Ok ]</div></font><br>");
		      print `cd $rootdir  && tar -xvzf $rootdir/ioncube.tar.gz  > /dev/null && chmod 755 -vR $rootdir/ioncube/*  > /dev/null`;
		    }
		}//end downloading ioncube

		LoadPhpIni($php_ini_contents);
		while( $element = each( $_POST[ 'parameter' ] ) )
		{
			if ( $element['key'] == 'sendmail_from' && $element['value'] == '<leave unchanged>' ) 
			{
				continue;
			}
			elseif ( $element['key'] == 'session.save_path' && $element['value'] == '' ) 
			{
				continue;
			}
			else
			{
			UpdateParameter($element['key'], $element['value']);
			}
		}
		
		if( ! isset( $_POST[ 'parameter' ] [ 'register_globals' ] ) )
			UpdateParameter( 'register_globals', '0' );
			
		if( ! isset( $_POST[ 'parameter' ] [ 'display_errors' ] ) )
			UpdateParameter( 'display_errors', '0' );
			
	    if( ! isset( $_POST[ 'parameter' ] [ 'open_basedir' ] ) ){
			UpdateParameter( 'open_basedir', '' );
	    }
	    else {
	        $open_basedir = $rootdir.'/'.PATH_SEPARATOR.$tmpdir.ltrim(ini_get('include_path'),'.').PATH_SEPARATOR. $serverphpinifolder;
	        if(ini_get('auto_prepend_file'))
	            $open_basedir .= PATH_SEPARATOR.dirname(ini_get('auto_prepend_file'));
	        UpdateParameter( 'open_basedir', $open_basedir );
	    }
		for($q=0;$q<=count($_POST['add_param_name'])-1;$q++)
			UpdateParameter($_POST['add_param_name'][$q],$_POST['add_param_val'][$q]);
			
		$set_postmaster=isset($_POST['cbPostmaster']);
		$i = 0;
		while( $element = each( $_POST[ 'domain' ] ) )
		{
			echo("Processing cgi for: <div class='bold'>${element['value']}</div>... ");
			PlaceCustomcgi( $element[ 'value' ] );
			echo "<font color='green'><div class='bold'>[ Done ]</div></font><br>";
			echo("Processing htaccess for: <div class='bold'>${element['value']}</div>... ");
			Placehtaccess( $element[ 'value' ] );
			echo "<font color='green'><div class='bold'>[ Done ]</div></font><br>";
			if(file_exists($phpinipath)){
				echo("Rename php.ini for: <div class='bold'>${element['value']}</div>... ");
				rename($phpinipath, $phpinipath.'.'.date("Ymd_Hi"));
				echo "<font color='green'><div class='bold'>[ Done ]</div></font><br>";
			}
			echo("Processing php.ini for: <div class='bold'>${element['value']}</div>... ");
			//ioncube install
			if( isset($_POST['ioncube']) )
			 {
//			    UpdateParameter("zend_extension",$rootdir . "/ioncube/ioncube_loader_lin_".PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION.".so");
			    UpdateParameter("zend_extension",$rootdir . "/ioncube/ioncube_loader_lin_".$phpverselected.".so");
			 }
			//end ioncube install
			
			PlaceCustomPhpIni( $element[ 'value' ] );
			echo "<font color='green'><div class='bold'>[ Done ]</div></font><br>";
			$i++;
		}
		echo "<p><div class='bold'>$i</div> domains updated.</p>";
		if($controlpanel > 8 && in_array($phpverselected, array("5.3","5.4")))
			echo "<br>You have requested PHP $phpverselected on CP$controlpanel.<br>Please be sure to change version to $phpverselected in WebOptions --> PHP Advanced";
		?>
		<P>
		<table border="0">
		<tr>
			<td>
				<table border="0">
				<tr>
					<td>
						<FORM METHOD=GET><INPUT TYPE=SUBMIT VALUE="Suicide" NAME="btnSuicide"></FORM>  
					</td>
					<td>
						<INPUT TYPE="button" VALUE="phpinfo()" ONCLICK=window.open("<?=$_SERVER['PHP_SELF'];?>?show_phpinfo")>
					</td>
					<td>
						<FORM><INPUT TYPE=submit VALUE="<< Back"></FORM>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="Generate phpinfo()" onclick="AJAXGenPHPInfo();">
			<td>
		</tr>
		</table>
		</P>
		<div id="dPHPInfo"></div>
		<?php

}else{
		?><iframe src="http://<?=UPDATEDOMAIN;?>/pig-versioncheck.php?ver=<?=VERSION?>" width="0" height="0" frameborder="0"></iframe><?php //Check new version
		
		echo '<SUB>P.I.G. v' . VERSION . '</SUB><BR>';
		if( DEBUG ) echo '<red><div class=\'bold\'>DEBUG MODE</div></red><BR>';
		
		//GetServerPhpIniPath();
		GetQuota();
		
		?>
		<FORM NAME="form" METHOD="post">
		<INPUT TYPE='HIDDEN' NAME='step' VALUE='2'>
		<?php if( DEBUG ) echo '<INPUT TYPE="checkbox" NAME="do_nothing" CHECKED> Do Nothing<BR>'; ?>
		<TABLE BORDER=2>
		<TFOOT>
		<TR><TD COLSPAN=2 ALIGN=center><INPUT id="submit" TYPE="submit" NAME="submit" VALUE="Submit"<?=$controlpanel==''?'DISABLED':''?>>
		</TFOOT>
		<TBODY ALIGN=center>
		<TR><TD><div class='bold'>OS<TD><?php echo PHP_OS==WIN?"Windows":"Linux"; ?>
		<TR><TD><div class='bold'>Server<TD><?= $serverdomainname!=''?$serverdomainname:'Unable to detect';?>
		<TR><TD><div class='bold'>Control Panel<TD><?= $controlpanel != '' ? 'CP' . $controlpanel : 'Unable to detect';?>
		<TR><TD><div class='bold'>inode Quota<TD><?= $inodeQuota == 0 ? "Not set" : $inodeQuota; ?>
		<TR><TD><div class='bold'>User Files<TD>
		<?php
		if( PHP_OS == LINUX )
			{ echo ( $overQuota &&   $inodeQuota != 0 ) ? "<red>$inodeFiles</red>" : $inodeFiles; }
		else
			echo "<div class='italic'>Not available</div>";
		?>
		<TR><TD><div class='bold'>PHP Version<TD><?=PHP_VERSION;?>
		<TR><TD><div class='bold'>Username<TD><?=$username;?>
		<TR><TD><div class='bold'>Domain Name<TD><?=$domainname;?>
		<TR><TD><div class='bold'>Server php.ini location<TD><?=$serverphpinipath;?>
		<TR><TD><div class='bold'>Place php.ini to<TD><span id="htscanner"><?=(PHP_OS==WIN)?(!CheckHtscanner()?$phpinipath:false):$phpinipath;?></span>
		<TR><TD><div class='bold'>Loaded php.ini<TD><?=$loadedphpinipath;?>
		<TR><TD><div class='bold'>phpinfo()</div><TD><INPUT TYPE="button" VALUE="Show Me" ONCLICK=window.open("<?= $_SERVER['PHP_SELF'];?>?show_phpinfo")><!--"Show me" button - shows phpinfo() in new window-->
		<TR><TD><div class='bold'>Install Ioncube: </div><TD ALIGN=left>
		<!--ioncube  -->
		<?php 
		     if ( PHP_OS==LINUX ) 
		       { 
		        if  (strstr($phpinfo, 'ioncube'))
		            print (" [x] IonCube: This server has Ioncube loader installed by default<br>");
		        elseif ($controlpanel < 9)
		            print ("<INPUT TYPE=checkbox name='ioncube' value='x86'  ><div class='bold'>IonCube x86</div> <BR>");
		        else
		             print ("<INPUT TYPE=checkbox name='ioncube' value='x86-64'><div class='bold'>IonCube x86_64</civ>  <BR>");
		       }
		     else print (" [x] IonCube: read <a target='_blank' href='http://wiki.opentransfer.com/doku.php/cr/info/technical/general_hosting_help/php?s[]=installed%20by%20default#ioncube_php_loader'> this </a>  first<br>");
		 ?>
		<!--ioncube end-->	

		<TR><TD><div class='bold'>Choose domains:</div>
		<TD ALIGN=left><INPUT TYPE=checkbox ID="cbAll" ONCLICK=Swap(document.form.cb) CHECKED><div class='bold'>All</div><BR><HR>
		<span id="domains">
		<img src="http://api.crmyknife.com/res/img/loadingcir.gif"> Retrieving directory list...
		</span>
		<TR>
			<TD><div class='bold'>Choose PHP Version</div></TD>
			<TD ALIGN=left>
			<?php 
				foreach($phpavail as $ver=>$sel){
					echo "\t\t\t\t<div><INPUT TYPE='radio' NAME='phpverselected' value=\"$ver\"$sel>$ver</div> \n";
				}
			?>
			</TD>
			</TR>
		<TR><TD ROWSPAN=3><div class='bold'>Recently used parameters:</div><BR>
		<INPUT TYPE=button VALUE="Default" ONCLICK=SetParams(iniDefault);><INPUT TYPE=button VALUE="Recommended" ONCLICK=SetParams(iniRec);>
		<TR><TD ALIGN=left>
		<INPUT TYPE="CHECKBOX" NAME="parameter[register_globals]" VALUE="1" <?=ini_get('register_globals')=='1'?'CHECKED':'';?>> Register Globals<BR>
		<INPUT TYPE="CHECKBOX" NAME="parameter[display_errors]" VALUE="1" <?=ini_get('display_errors')=='1'?'CHECKED':'';?>> Display Errors<BR>
		<INPUT TYPE="CHECKBOX" NAME="parameter[open_basedir]" VALUE="1" <?=ini_get('open_basedir')!=''?'CHECKED':'';?>> Open base dir (for security purposes only)<BR>
		<INPUT TYPE="CHECKBOX" NAME="cbPostmaster" VALUE="1" ONCLICK=SwapPostmaster() CHECKED> Set envelope sender to postmaster@&lt;domain.com&gt;
		<TR><TD><TABLE NAME="textparamtable" BORDER=1>
		<THEAD><TR><TH>Name<TH>Value</THEAD>
		<TBODY><FONT FACE="Courier New">
		<TR><TD>mbstring.language =<TD><INPUT TYPE="TEXT" NAME="parameter[mbstring.language]" VALUE="<?=ini_get('mbstring.language');?>">
		<TR><TD>mbstring.http_input =<TD><INPUT TYPE="TEXT" NAME="parameter[mbstring.http_input]" VALUE="<?=ini_get('mbstring.http_input');?>">
		<TR><TD>mbstring.http_output =<TD><INPUT TYPE="TEXT" NAME="parameter[mbstring.http_output]" VALUE="<?=ini_get('mbstring.http_output');?>">
		<TR><TD>session.save_path =<TD><INPUT TYPE="TEXT" NAME="parameter[session.save_path]" VALUE="<?=ini_get('session.save_path');?>">
		<TR><TD>upload_max_filesize =<TD><INPUT TYPE="TEXT" NAME="parameter[upload_max_filesize]" VALUE="<?=ini_get('upload_max_filesize');?>">
		<TR><TD>post_max_size =<TD><INPUT TYPE="TEXT" NAME="parameter[post_max_size]" VALUE="<?=ini_get('post_max_size');?>">
		<TR><TD>memory_limit =<TD><INPUT TYPE="TEXT" NAME="parameter[memory_limit]" VALUE="<?=ini_get('memory_limit');?>">
		<TR><TD>sendmail_from =<TD><INPUT TYPE="TEXT" NAME="parameter[sendmail_from]" ID="tSendmailFrom" VALUE="postmaster@<domain.com>" DISABLED>
		</FONT>
		</TBODY>
		</TABLE>
		<TR><TD><div class='bold'>Additional parameters:</div><BR><!--Dynamic additional parameters textfields with help of js-->
		<INPUT TYPE="button" VALUE="Add" ONCLICK="return addline();">
		<TD><SPAN ID="table">
		<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=3>
		<THEAD><TR><TH>NAME<TH>VALUE</THEAD>
		<TBODY>
		<TR><TD><INPUT TYPE="text" NAME="add_param_name[0]"> = <TD><INPUT TYPE="text" NAME="add_param_val[0]">
		</TBODY>
		</TABLE>
		</SPAN>
		</TBODY>
		</TABLE>
		<input type="hidden" name="serverPhpIniPath" value="<?=base64_encode($serverphpinipath);?>">
		<input type="hidden" name="serverPhpIniFolder" value="<?=base64_encode($serverphpinifolder);?>">
		</FORM>
		<?php
		GetDirList(); // Populate domains list
}



/*
 *	on submission
 * 	for each domain
 *		load form values
 *		
*/
?>
</BODY>
</HTML>