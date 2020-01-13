<?php
/*===============================================================
* Keep db_credentials in a seperate file
* - Makes it easy to exclude the file from git
* - Unique credentials for development and production
* - Unique credentials if working with multiple developers
===============================================================*/

/*===============================================================
* REMOVE -sample from the filename so you endup with:
* 'db_credentials.php'
* enter your informations below
===============================================================*/

define("DB_SERVER", "MY SERVER NAME");
define("DB_USER", "MY USER NAME");
define("DB_PASSWORD", "MY PASSWORD");
define("DB_NAME", 'MY DATABASE NAME');
