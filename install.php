<?php
///////////////////////////////////
//         ajax im 3.41          //
//    AJAX Instant Messenger     //
//   Copyright (c) 2006-2008     //
//    http://www.ajaxim.com/     //
//   Do not remove this notice   //
///////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <title>ajax im - installation</title>
      <style type="text/css" media="screen">
         body {   
            background: #101010;
         }
         
         a {
            color: #fff;
         }
         
         h1 {
            font: 160px Arial, Verdana, Tahoma, sans-serif;
            color: #fff;
            margin: 0 auto 40px;
            padding: 0;
            text-align: center;
            width: 80%;
         }
         
         h2 {
            font: 28px tahoma, verdana, arial, sans-serif;
            font-weight: bold;
            color: #84e03a;
            margin: 0;
            padding: 0 0 10px 0;
        }
 
         div {
            border: 2px solid #1d1d1d;
            padding: 10px;
            font: 12px Verdana, Tahoma, Arial, sans-serif;
            width: 400px;
            margin: 10px auto;
            color: #fff;
         }
         
         label, input {
            font: 14px Verdana, Tahoma, Arial, sans-serif;
         }
         
         label {
            display: block;
            width: 100px;
            float: left;
            color: #fff;
         }
         
         input {
            border: 0;
            padding: 2px;
         }
         
         input#install {
            display:  block;
            background-color: #101010;
            color: #84e03a;
            font: 32px Verdana, Tahoma, Arial, sans-serif;
            margin: 0 auto;
            text-decoration: underline;
         }
         
         input#username, input#password, input#email, label {
            margin-top: 10px;
         }
         
         input#username {
            clear: right;
         }
         
         div.error {
            color: #ff0000;
            text-align: center;
         }
         
         div.success {
            color: #84e03a;
            text-align: center;
         }
      </style>
   </head>
   
   <body>
      <h1>ajax im</h1>
      <?php
         if(!$_GET['go']) {
      ?>
      <div>
         <h2>before you begin...</h2>
         Did you remember to:
         <ul>
            <li>setup a database for ajax im?</li>
            <li>edit <strong>config.php</strong> to match your MySQL configuration?</li>
            <?php if ($maxBuddyIconSize > 0 && trim(substr(sprintf('%o', fileperms('./buddyicons/')), -4)) != 777) { echo '<li>CHMOD <strong>buddyicons/</strong> to 0777, it is at: '. substr(sprintf('%o', fileperms('./buddyicons/')), -4) .'?</li>'; } ?>
         </ul>
      </div>
      
      <form method="post" action="install.php?go=true">
         <div>
            <h2>first admin account</h2>
      
            This will be the first account registered on ajax im. It will automatically be set to be an admin account.
      
            <label id="username-label" for="username">username:</label> <input type="text" name="username" id="username" />
            <label id="password-label" for="password">password:</label> <input type="password" name="password" id="password" />
            <label id="email-label" for="password">email:</label> <input type="text" name="email" id="email" />
         </div>
            
         <div>
            <h2>ready?</h2>
               
            <input type="submit" id="install" value="install!" />
         </div>
      </form>
      <?php
         } else {
      ?>
      <div>
         <h2>installing...</h2>
      <?php
            require 'config.php';
            
            $link = mysql_connect($sql_host, $sql_user, $sql_pass);
            mysql_select_db($sql_db);
            
            $table_messages = 'CREATE TABLE `'.SQL_PREFIX.'messages` ( `recipient` text, `sender` text, `message` text, `type` text, `stamp` text, `id` bigint(20) unsigned NOT NULL auto_increment, UNIQUE KEY `id` (`id`) ) ;';
            if(!mysql_query($table_messages)) {
               if(mysql_errno() == 1050) {
                  print "Table '".SQL_PREFIX."messages' already exists! If you had a version of ajax im less than 3.2 installed on this database, please delete the table and then run this script again, otherwise ignore this error.<br /><br />\n";
                  $problem = true;
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               mysql_query('ALTER TABLE `'.SQL_PREFIX.'messages` CHANGE `message` `message` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');
               print "Table '".SQL_PREFIX."messages' added successfully!<br /><br />\n";
            }
            
            $table_users = 'CREATE TABLE `'.SQL_PREFIX.'users` ( `username` varchar(32), `password` varchar(32), `email` text, `is_online` int(11) default \'0\', `last_ping` text, `last_ip` varchar(15), `banned` tinyint(1) default \'0\', `admin` tinyint(1) default \'0\', `buddyicon` varchar(4) NOT NULL default \'none\', `profile` text, `id` bigint(20) unsigned NOT NULL auto_increment, UNIQUE KEY `id` (`id`), UNIQUE `username` (`username`) ) ;';
            if(!mysql_query($table_users)) {
               if(mysql_errno() == 1050) {
                  print "Table '".SQL_PREFIX."users' already exists! If you had a version of ajax im less than 3.2 installed on this database, please delete the table and then run this script again, otherwise ignore this error.<br /><br />\n";
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               print "Table '".SQL_PREFIX."users' added successfully!<br /><br />\n";
            }
            
            $table_chats = 'CREATE TABLE `'.SQL_PREFIX.'chats` ( `room` text, `user` text, `id` bigint(20) unsigned NOT NULL auto_increment, UNIQUE KEY `id` (`id`) ) ;';
            if(!mysql_query($table_chats)) {
               if(mysql_errno() == 1050) {
                  print "Table '".SQL_PREFIX."chats' already exists! If you had a version of ajax im less than 3.0 installed on this database, please delete the table and then run this script again, otherwise ignore this error.<br /><br />\n";
                  $problem = true;
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               mysql_query('ALTER TABLE `'.SQL_PREFIX.'chats` CHANGE `room` `room` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL');
               print "Table '".SQL_PREFIX."chats' added successfully!<br /><br />\n";
            }
         
            $table_buddylists = 'CREATE TABLE `'.SQL_PREFIX.'buddylists` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `user` VARCHAR( 100 ) NOT NULL, `buddy` VARCHAR( 100 ) NOT NULL, `group` VARCHAR( 100 ) NOT NULL, INDEX ( `user` , `group` )) ENGINE = MYISAM ;';
            if(!mysql_query($table_buddylists)) {
               if(mysql_errno() == 1050) {
                  print "Table '".SQL_PREFIX."buddylists' already exists! If you had a version of ajax im less than 3.2 installed on this database, please delete the table and then run this script again, otherwise ignore this error.<br /><br />\n";
                  $problem = true;
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               print "Table '".SQL_PREFIX."buddylists' added successfully!<br /><br />\n";
            }
            
            $table_blocklists = 'CREATE TABLE `'.SQL_PREFIX.'blocklists` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `user` VARCHAR( 100 ) NOT NULL, `buddy` VARCHAR( 100 ) NOT NULL, INDEX ( `user` , `buddy` )) ENGINE = MYISAM ;';
            if(!mysql_query($table_blocklists)) {
               if(mysql_errno() == 1050) {
                  print "Table '".SQL_PREFIX."blocklists' already exists! If you had a version of ajax im less than 3.2 installed on this database, please delete the table and then run this script again, otherwise ignore this error.<br /><br />\n";
                  $problem = true;
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               print "Table '".SQL_PREFIX."blocklists' added successfully!<br /><br />\n";
            }
         
            $add_user = 'INSERT INTO `'.SQL_PREFIX.'users` (username, password, email, admin) VALUES (\'' . mysql_real_escape_string($_POST['username']) . '\', \'' . mysql_real_escape_string(md5($_POST['password'])) . '\', \'' . mysql_real_escape_string($_POST['email']) . '\', 1)';
            if(!mysql_query($add_user)) {
               print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
               print "Unable to add the first user! This likely means there was some other issue during installation.<br /><br />\n";
               $error = true;
            } else {
               print "First/admin user registered!<br /><br />\n";
            }

            if ($maxBuddyIconSize > 0) {
               if (trim(substr(sprintf('%o', fileperms('./buddyicons/')), -4)) != 777) {
                  $error = true;
                  print "<b>File permissions:</b>: <br/><br/>CHMOD buddyicons/ to 0777</b><br/><br/>";
               } else {
                  print "You have change permissions of buddyicons/<br/><br/>";
               }
            }

            mysql_close();
      ?>
      </div>
         
      <div class="<?php if($error) print 'error'; else print 'success'; ?>">
         <h2>status</h2>
         <?php
            if($error)
               print 'There was an error while installing the script! Please refer to the messages above to solve your issue.';
            else
               print 'Congratulations! ajax im installed successfully! You can now login with your new admin account <a href="./">here</a>. Please be sure to delete install.php and update.php!';
         ?>
      </div>
      <?php } ?>
   </body>
</html>
