SELENIUM_SERVER="java -jar Tests/selenium-server-standalone-2.46.0.jar"

echo "Starting Selenium Server on port 4444"
$SELENIUM_SERVER > /dev/null 2>&1 &

SELENIUM_SERVER_PID=$!
sleep 1

./vendor/bin/phpunit --testdox Tests/Unit/Selenium/HomePage.php


kill $SELENIUM_SERVER_PID

echo "Selenium server Ended"