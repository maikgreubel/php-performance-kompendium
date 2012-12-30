@echo off & setlocal

set PATH=%PATH%;.\bin\util

php -v 2>&1 > nul:
if not %errorlevel%==0 goto _no_php_binary_found

ansicon php -f bin/start.php

goto _end

:_no_php_binary_found
ansicon -e [1;31;40mNo PHP executable found! Please add PHP installation folder to your PATH environment.
ansicon -e [1;31;40mPHP.exe nicht gefunden! Bitte PHP-Installationsordner zur PATH Umgebungsvariable hinzufuegen.

:_error_end

:_end