# CI-Caching
Simple caching class.

This class was made for CodeIgniter. But, you can use it any project. This class contains following functions;
  -	fileGet()
  -	fileSave()

fileGet function is search your file on your cache path. If exists, it will check edit time of file. If the file is old, it will make an exception and it will return false value. If isn't, it will return cache file content. If the file not exist, it will make an exception and it will return false value.

fileSave function is create cache file to your cache path. 

Other exceptions;
  - If cache path not writable, 
  - If parameters types is wrong,

If you're interest in, you can access at the below link to documentation;

https://github.com/gurkanbicer/CI-Caching/wiki
