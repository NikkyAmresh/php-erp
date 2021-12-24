export $(cat App/.env | xargs)
export DB_NAME='erp_test'
echo "Configuring Test Database";
/Applications/mampstack-$MAMP_VERSION/ctlscript.sh restart apache > /dev/null 2>&1
SELENIUM_SERVER="java -jar Tests/selenium-server-standalone-2.46.0.jar"
echo "Starting Selenium Server on port 4444"
$SELENIUM_SERVER > /dev/null 2>&1 &
SELENIUM_SERVER_PID=$!
sleep 2

# ------------------- Tests ----------------------

./vendor/bin/phpunit --testdox Tests/Unit/Selenium/HomePage.php

# -------------------------------------------------
kill $SELENIUM_SERVER_PID
echo "Selenium server Ended"
export $(cat App/.env | xargs)
echo "Finishing up...";
/Applications/mampstack-$MAMP_VERSION/ctlscript.sh restart apache > /dev/null 2>&1