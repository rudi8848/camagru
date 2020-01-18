<?php
include('database.php');

try {

	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbname = getenv("DB_NAME");

	$db->exec( "CREATE DATABASE IF NOT EXISTS $dbname DEFAULT CHARSET=utf8");
	$db->exec("USE $dbname");

	$db->exec("CREATE TABLE IF NOT EXISTS `roles` 
		(`role_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
		`role_name` VARCHAR(50) NOT NULL) 
		ENGINE=InnoDB DEFAULT CHARSET=utf8");
	
	$db->exec("INSERT IGNORE INTO `roles` VALUES
		(1, 'admin'),
		(2, 'moderator'),
		(3, 'regular')");

	$db->exec("CREATE TABLE IF NOT EXISTS `users`
		(`user_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`username` VARCHAR(20) NOT NULL UNIQUE,
		`password` VARCHAR(100) NOT NULL,
		`email` VARCHAR(100) NOT NULL UNIQUE,
		`role` INT(11) NOT NULL DEFAULT 3,
		`blocked` TINYINT(1) DEFAULT 0,
		`verified` TINYINT(1) DEFAULT 0,
		`token` VARCHAR (255) DEFAULT NULL,
		`pic` VARCHAR (255) DEFAULT '/views/styles/pic/default-user.png',
		FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `settings`
		(`settings_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`user` INT(11) NOT NULL,
		`user_photo` VARCHAR(155) DEFAULT NULL,
		`comments_notify` TINYINT(1) DEFAULT 1,
		`likes_notify` TINYINT(1) DEFAULT 0,
		FOREIGN KEY (`user`) REFERENCES `users` (`user_id`))	
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `posts`
		(`post_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`created_at` DATETIME NOT NULL DEFAULT NOW(),
		`image_path` VARCHAR(255) NOT NULL,
		`author` INT(11) NOT NULL,
		`description` VARCHAR(255) NULL,
		`is_deleted` TINYINT(1) DEFAULT 0,
		`deleted_at` DATETIME NULL,
		`deleted_by` INT(11) NULL,
		FOREIGN KEY (`author`) REFERENCES `users` (`user_id`),
		FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `comments`
		(`comment_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`to_post` INT(11) NOT NULL,
		`author` INT(11) NOT NULL,
		`content` VARCHAR(255) NOT NULL,
		`created_at` DATETIME NOT NULL DEFAULT NOW(),
		`is_deleted` TINYINT(1) DEFAULT 0,
		`deleted_at` DATETIME NULL,
		`deleted_by` INT(11) NULL,
		FOREIGN KEY (`to_post`) REFERENCES `posts` (`post_id`),
		FOREIGN KEY (`author`) REFERENCES `users` (`user_id`),
		FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `likes`
		(`like_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`to_post` INT(11) NOT NULL,
		`author` INT(11) NOT NULL,
		FOREIGN KEY (`to_post`) REFERENCES `posts` (`post_id`),
		FOREIGN KEY (`author`) REFERENCES `users` (`user_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `followers`
		(`follow_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`follower` INT(11) NOT NULL,
		`follows` INT(11) NOT NULL,
		FOREIGN KEY (`follower`) REFERENCES `users`(`user_id`),
		FOREIGN KEY (`follows`) REFERENCES `users`(`user_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `frames`
		(`frame_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`path` VARCHAR(255) NOT NULL,
		`description` VARCHAR(100) NULL)
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("INSERT IGNORE INTO `frames` VALUES 
(1, '/views/styles/frames/explode.png', ''),
(2, '/views/styles/frames/fire.png', ''),
(3, '/views/styles/frames/hair1.png', ''),
(4, '/views/styles/frames/hair2.png', ''),
(5, '/views/styles/frames/hat.png', ''),
(6, '/views/styles/frames/veapon.png', ''),
(7, '/views/styles/frames/film.png', ''),
(8, '/views/styles/frames/steve.png', ''),
(9, '/views/styles/frames/batman.png', ''),
(10, '/views/styles/frames/spy.png', ''),
(11, '/views/styles/frames/travolta.png', ''),
(12, '/views/styles/frames/portal.png', '')");

	$db->exec("CREATE TABLE IF NOT EXISTS `categories`
		(`category_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`name` VARCHAR(100) NOT NULL UNIQUE)
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `categorycrosstoframe`
		(`ccf_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`category` INT(11) NOT NULL,
		`frame` INT(11) NOT NULL,
		FOREIGN KEY (`category`) REFERENCES `categories`(`category_id`),
		FOREIGN KEY (`frame`) REFERENCES `frames`(`frame_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `replies`
		(`reply_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`to_comment` INT(11) NOT NULL,
		`author` INT(11) NOT NULL,
		`created_at` DATETIME NOT NULL DEFAULT NOW(),
		`content` VARCHAR(255) NOT NULL,
		`is_deleted` TINYINT(1) DEFAULT 0,
		`deleted_at` DATETIME NULL,
		`deleted_by` INT(11) NULL,
		FOREIGN KEY (`to_comment`) REFERENCES `comments`(`comment_id`),
		FOREIGN KEY (`author`) REFERENCES `users`(`user_id`),
		FOREIGN KEY (`deleted_by`) REFERENCES `users`(`user_id`))
		ENGINE=InnoDB DEFAULT CHARSET=utf8");

	$db->exec("CREATE TABLE IF NOT EXISTS `notifications`
		(`notification_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`receiver` VARCHAR(100) NOT NULL,
		`content` VARCHAR(255) NOT NULL,
		`sent_at` DATETIME DEFAULT NOW())
		ENGINE=InnoDB DEFAULT CHARSET=utf8");


	} 
	catch (PDOException $e) {
		
		echo 'Connection failed: ' . $e->getMessage();
	}
?>
