# CI-Caching
Simple caching class.

This class was made for CodeIgniter. But, you can use it any project. This class contains following functions;
  -	fileGet()
  -	fileSave()

fileGet function is searching your file on your cache path. If exists, it will check editing time of file. If file is old, it will throw an exception and it will return false value. If not, it will return cache file content. If file not exist, it will throw an exception and it will return false value.

fileSave function is creating cache file to your cache path. 

Other exceptions;
  - If cache path not writable, 
  - If parameters types is wrong,

If you're interested in, you can access at the below link to documentation;
https://github.com/gurkanbicer/CI-Caching/wiki
