Description:  
A chatroom.  
  
Installation:  
* Copy all files to folder.
* Chown data/ to www-data, cd to data/ and run ./clear.sh as www-data.
* Configure stuff using config/
* Configuration instructions in config/README
  
Note: It is HIGHLY recommended to server this site over TLS. Otherwise all passwords will be visible in plaintext.  
  
Changelog:  
* Increased Security + Efficiency + Readability (got rid of a lot of system calls, moved data files to data/)
* Initial commit (have been working on this for a long time though)
