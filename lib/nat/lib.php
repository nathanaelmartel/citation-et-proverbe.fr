<?php

class simplementNat
{ 

  public static function cleanString($text) {
    
        $text = strip_tags($text);
        $text = htmlentities($text, ENT_COMPAT, 'ISO-8859-1');
  
        $text = str_replace(
	        array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
	        array("'", "'", '"', '"', '-', '--', '...'),
	        $text);
        $text = str_replace(
          array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
          array("'", "'", '"', '"', '-', '--', '...'),
          $text);
 
        $text = html_entity_decode($text);
        $text = utf8_decode($text);
        
        $text = str_replace(
          array('&#13;', '&#amp;'), 
          array(" ", '&'),
          $text);
        
        return $text;
  }
  
  
  public function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
  {
    $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
    
    $response = file_get_contents($bitly);
    
    if(strtolower($format) == 'json')
    {
      $json = @json_decode($response,true);
      return $json['results'][$url]['shortUrl'];
    }
    else
    {
      $xml = simplexml_load_string($response);
      return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
    }
  }
  
  public function make_tiny_url($url)
  {
    $parse_url = parse_url($url);
    if( empty($parse_url['scheme']) ) return FALSE;
    
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url='.urlencode($url));  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
    $content = curl_exec($ch);  
    curl_close($ch);  
    
    if( strpos($content, 'http') === FALSE )
      return FALSE;
    
    return trim($content);
  }
  
  public function make_googl_url($url)
	{
	    $parse_url = parse_url($url);
	    if( empty($parse_url['scheme']) ) return FALSE;
	     
	    $ch = curl_init(); 
	    curl_setopt($ch, CURLOPT_URL, 'http://ggl-shortener.appspot.com/?url='.urlencode($url)); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
	    $content = curl_exec($ch); 
	    curl_close($ch); 
	     
	    preg_match('`"(http[^"]+)"`', $content, $m);
	    if( !isset($m[1]) ) return FALSE;
	     
	    return $m[1];
  }
  
  public function make_isdg_url($url)
  {
    $parse_url = parse_url($url);
    if( empty($parse_url['scheme']) ) return FALSE;
    
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, 'http://is.gd/api.php?longurl='.urlencode($url));  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
    $content = curl_exec($ch);  
    curl_close($ch);  
    
    if( strpos($content, 'http') === FALSE )
      return FALSE;
    
    return trim($content);
  }

  
  public function twitter_statuses_update($message, $keys)
  {
    global $aktt;
    $aktt = json_decode($keys);
    
    require_once sfConfig::get('sf_lib_dir').'/nat/twitteroauth/twitteroauth.php';
    if (!defined('AKTT_API_POST_STATUS'))
    	define('AKTT_API_POST_STATUS', 'https://api.twitter.com/1.1/statuses/update.json');
    
    if ($connection = aktt_oauth_connection()) {
      $connection->post(
        AKTT_API_POST_STATUS
        , array(
          'status' => $message
          , 'source' => 'Citations Francophones'
        )
      );
      if (strcmp($connection->http_code, '200') == 0) {
        return true;
      } else {
    		sfTask::log('twitter failed : '.$connection->http_code);
      }
    }
    return false;
  }
  
  
	static public function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', ' ', $text);
	 
	  // trim
	  $text = trim($text, '-');
	 
	  // transliterate
	  if (function_exists('iconv'))
	  {
	    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	  }
	 
	  // lowercase
	  $text = strtolower($text);
	 
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', ' ', $text);
	 
	  if (empty($text))
	  {
	    return 'n-a';
	  }
	 
	  return $text;
	}
  
  
}

function aktt_oauth_connection() {
  global $aktt;
  if ( !empty($aktt->app_consumer_key) && !empty($aktt->app_consumer_secret) && !empty($aktt->oauth_token) && !empty($aktt->oauth_token_secret) ) { 
    $connection = new TwitterOAuth(
      $aktt->app_consumer_key, 
      $aktt->app_consumer_secret, 
      $aktt->oauth_token, 
      $aktt->oauth_token_secret
    );
    $connection->useragent = 'Citation Francophone';
    return $connection;
  }
  else {
    return false;
  }
}
