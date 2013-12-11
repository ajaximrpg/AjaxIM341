<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <title>ajax im - update version 3.3 to 3.x</title>
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
         <ul>
            <li>are you sure you are updating, not installing?</li>
            <?php if (trim(substr(sprintf('%o', fileperms('./buddyicons/')), -4)) != 777) { echo '<li>CHMOD <strong>buddyicons/</strong> to 0777, it is at: '. substr(sprintf('%o', fileperms('./buddyicons/')), -4) .'!</li>'; } ?>
         </ul>
      </div>
      
      <form method="post" action="update.php?go=true">
         <div>
            <h2>ready?</h2>
               
            <input type="submit" id="install" value="update!" />
         </div>
      </form>
      <?php
         } else {
      ?>
      <div>
         <h2>updating...</h2>
      <?php
            require 'config.php';
            
            $link = mysql_connect($sql_host, $sql_user, $sql_pass);
            mysql_select_db($sql_db);
            
            $table_users = 'ALTER TABLE `ajaxim_users` ADD `buddyicon` VARCHAR( 4 ) NOT NULL DEFAULT \'none\' AFTER `admin`, ADD `profile` TEXT NULL AFTER `buddyicon` ';
            if(!mysql_query($table_users)) {
               if(mysql_errno() == 1060) {
                  print "Column 'buddyicon' and/or 'profile' already exists! You updated already.<br /><br />\n";
               } else {
                  print("<b>A MySQL error occured:</b> (" . mysql_errno() . ") " . mysql_error() . "<br /><br />\n");
                  $error = true;
               }
            } else {
               print "Table '".SQL_PREFIX."users' altered successfully!<br /><br />\n";
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
               print 'There was an error while updating the script! Please refer to the messages above to solve your issue.';
            else
               print 'Congratulations! ajax im updated successfully! You can now login with your old admin account <a href="./">here</a>. Please be sure to delete install.php and update.php!';
         ?>
      </div>
      <?php } ?>
   </body>
</html>
