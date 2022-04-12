#!/bin/bash
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

if  [ -z $SUDO_USER  ]; then
echo "You must have root privilege to do the installation."
exit 1;
fi

read -p "You want to run the queues with? (cron/supervisord)" QUEUE
if [ $QUEUE = "cron" ]; then
	echo "Creating crontab job..."
	line="* * * * * php ${DIR}/artisan schedule:run 1>> /dev/null 2>&1"
	crontab -l | { cat; echo "$line"; } | crontab -
	echo "crontab created"
else
	echo "Installing supervisord"
	sudo apt-get install -y supervisor || (echo "Error Installing supervisord"; exit 1;)

	CONFIG=$(cat <<EOF
[program:service-queue]
command=php ${DIR}/artisan queue:work --sleep=3 --tries=3
user=$USER
process_name=%(program_name)s_%(process_num)d
directory=${DIR}
stdout_logfile=${DIR}/storage/logs/queue.log
redirect_stderr=true
autostart=true
autorestart=true
startretries=3
numprocs=1
EOF
	)
	sudo touch /etc/supervisor/conf.d/queue.conf
	sudo echo "${CONFIG}" > /etc/supervisor/conf.d/queue.conf

	sudo service supervisor restart
fi
echo "Successfully installed"