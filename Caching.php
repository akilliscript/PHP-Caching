<?php
/**
 * PHP Disk Caching Class.
 * 
 * @author Gürkan Biçer <gurkan@gurkanbicer.com>
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPL 3.0
 * @since 2014-08-19
 * @link https://github.com/gurkanbicer/PHP-Caching
 */
 
    Class Caching {
        
        protected $cachePath;
        protected $errors;
        
        public function __construct($path) 
        {
            $this->cachePath = $path;
        }
        
        public function getErrors() 
        {
            var_dump($this->errors);    
        }    
	
	    public function getCache($key) 
        {
			try
			{
				if (empty($key)) throw new Exception(0);
				if (!is_string($key)) throw new Exception(1);
				
				$orig_key = $key;
				$key = md5($key);
				
				$dirs[] = substr($key, 0, 2);
				$dirs[] = substr($key, 2, 2);
				$dirs[] = substr($key, 4, 2);
				
				$path = $this->cachePath . implode($dirs, '/') . '/' . $key;
				if (!file_exists($path)) throw new Exception(2);
				$file = unserialize(file_get_contents($path));
				
				$eTime = filemtime($path) + ($file['expire'] * 60);
				$cTime = time();
				if ($eTime > $cTime) return $file['content'];
				else throw new Exception(3);				
			}
			catch (Exception $e)
			{
                switch ($e->getMessage()) {
                    case 0:
                        $this->errors[] = 'getCache(): Key parameter empty.';
                        break;
                    case 1:
                        $this->errors[] = 'getCache(): Key parameter invalid.';
                        break;
                    case 2:
                        $this->errors[] = 'getCache(): Cache file not found.';
                        break;
                    case 3:
                        $this->errors[] = 'getCache(): Cache file expired.';
                        break;
                }        
				return false;
			}
		}
		
		public function setCache($key, $content, $time = 15) 
        {
			try
			{
				if (empty($key)) throw new Exception(0);
				if (!is_string($key)) throw new Exception(1);
				if (empty($content)) throw new Exception(2);
				if (empty($time)) throw new Exception(3);
				if (!is_numeric($time)) throw new Exception(4);
			
				$orig_key = $key;
				$key = md5($key);
				
				$dirs[] = substr($key, 0, 2);
				$dirs[] = substr($key, 2, 2);
				$dirs[] = substr($key, 4, 2);
				
				if (!file_exists($this->cachePath . $dirs[0])) 
					mkdir($this->cachePath . $dirs[0]);
				
				if (!file_exists($this->cachePath . $dirs[0] . '/' . $dirs[1])) 
					mkdir($this->cachePath . $dirs[0] . '/' . $dirs[1]);
				
				if (!file_exists($this->cachePath . $dirs[0] . '/' . $dirs[1] . '/' .$dirs[2])) 
					mkdir($this->cachePath . $dirs[0] . '/' . $dirs[1] . '/' .$dirs[2]);
				
				if (file_exists($this->cachePath . implode($dirs, '/'))):
					$orig_content = $content;
					$file = serialize(array( 'expire'  => $time, 'content' => $content ));
					
					if (is_writable($this->cachePath . implode($dirs, '/'))) 
                        file_put_contents($this->cachePath . implode($dirs , '/') . '/' . $key, $file);
					else 
                        throw new Exception(5);
				endif;
			
			} catch (Exception $e) {
                switch ($e->getMessage()) {
                    case 0:
                        $this->errors[] = 'setCache(): Key parameter empty.';
                        break;
                    case 1:
                        $this->errors[] = 'setCache(): Key parameter invalid.';
                        break;
                    case 2:
                        $this->errors[] = 'setCache(): Content parameter empty.';
                        break;
                    case 3:
                        $this->errors[] = 'setCache(): Time parameter empty.';
                        break;
                    case 4:
                        $this->errors[] = 'setCache(): Time parameter invalid.';
                        break;
                    case 5:
                        $this->errors[] = 'setCache(): Cache directory isnt writable.';
                        break;      
                }
				return false;
			}		
		}		
	
	}
