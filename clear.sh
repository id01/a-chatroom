#!/bin/sh

echo '0' > number.txt
echo 'The room was created by the admin.<br /><br />' > messages.txt
adminuserhash=$(echo -n 'admin' | sha1sum | awk '{print toupper($0)}' | cut -d " " -f 1)
adminpasshash=$(grep '$_CONFIG\["adminhash"\]' config/config.php | cut -d '=' -f 2 | tr -d "\"'; ")
echo "$adminuserhash $adminpasshash 3" > loginfile.txt
echo -n '' > banned.txt
cat config/restricted_template.txt > restricted.txt
