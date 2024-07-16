<?php

//a "salt" is a random string that is used to hash a password, when you preview this echo, it prints a 32 character string that is the password of "admin" hashed with the salt "dl5s?3".  This makes passwords significantly more secure.  This string will be added on the end of the user password before it is hashed.  This makes it much more difficult for a hacker to crack the password.
echo md5('admin' . 'dl5s?3');

?>