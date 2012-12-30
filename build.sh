#!/bin/bash

php -v 2>&1 > /dev/null
if test "x$?" != "x0"; then
	echo "PHP Interpreter not found!"
	echo "PHP Interpreter nicht gefunden!"
fi

php -f ./bin/start.php
