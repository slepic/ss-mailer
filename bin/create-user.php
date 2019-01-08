<?php

declare(strict_types=1);

if (!isset($_SERVER['argv'][3])) {
	echo '
Add new user to database.

Usage: create-user.php <name> <email> <password>
';
	exit(1);
}

[, $name, $email, $password] = $_SERVER['argv'];

/** @var Nette\DI\Container $container */
$container = require __DIR__ . '/../app/bootstrap.php';

$manager = $container->getByType(App\Model\UserManager::class);

try {
	$manager->add($name, $email, $password);
	echo "User $name was added.\n";

} catch (App\Model\DuplicateNameException $e) {
	echo "Error: duplicate name.\n";
	exit(1);
}
