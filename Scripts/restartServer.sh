export $(cat App/.env | xargs)
echo "Restarting server...";
/Applications/mampstack-$MAMP_VERSION/ctlscript.sh restart apache > /dev/null 2>&1
echo "Done";