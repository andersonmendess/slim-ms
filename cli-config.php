<?php

require_once "index.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);