<?php
/**
 * It is simple caching class.
 * 
 * @author Gürkan Biçer <gurkan@gurkanbicer.com>
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPL 3.0
 * @since 2014-08-19
 * @link https://github.com/gurkanbicer/CI-Caching
 */
 
	Class Caching {
	
		public function fileGet($key) {
			try
			{
				if (empty($key)) throw new Exception(0);
				if (!is_string($key)) throw new Exception(1);
				
				$orig_key = $key;
				$key = md5($key);
				
				$dirs[] = substr($key, 0, 2);
				$dirs[] = substr($key, 2, 2);
				$dirs[] = substr($key, 4, 2);
				
				$path = CACHEPATH . implode($dirs, '/') . '/' . $key;
				if (!file_exists($path)) throw new Exception(2);
				$file = unserialize(file_get_contents($path));
				
				$eTime = filemtime($path) + ($file['expire'] * 60);
				$cTime = time();
				if ($eTime > $cTime) return $file['content'];
				else return false;				
			}
			catch (Exception $e)
			{
				return false;
			}
		}
		
		public function fileSave($key, $content, $time = 15) {
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
				
				if (!file_exists(CACHEPATH . $dirs[0])) 
					mkdir(CACHEPATH . $dirs[0]);
				
				if (!file_exists(CACHEPATH . $dirs[0] . '/' . $dirs[1])) 
					mkdir(CACHEPATH . $dirs[0] . '/' . $dirs[1]);
				
				if (!file_exists(CACHEPATH . $dirs[0] . '/' . $dirs[1] . '/' .$dirs[2])) 
					mkdir(CACHEPATH . $dirs[0] . '/' . $dirs[1] . '/' .$dirs[2]);
				
				if (file_exists(CACHEPATH . implode($dirs, '/'))):
					$orig_content = $content;
					$file = serialize(array( 'expire'  => $time, 'content' => $content ));
					
					if (is_writable(CACHEPATH . implode($dirs, '/'))) file_put_contents(CACHEPATH . implode($dirs , '/') . '/' . $key, $file);
					else throw new Exception(5);
				endif;
			
			} catch (Exception $e) {
				return $e->getMessage();
			}		
		}		
	
	}
