#!/bin/bash

#docker-compose -f docker-compose-local.yml down
#rm -rf ./App/Settings/DockerLocal/mysql/master/data/*
#rm -rf ./App/Settings/DockerLocal/mysql/slave/data/*
#docker-compose -f docker-compose-local.yml build
#docker-compose -f docker-compose-local.yml up -d

until docker exec otus.mysql.master sh -c 'export MYSQL_PWD=dinhO959; mysql -u root -e ";"'
do
    echo "Waiting for mysql_master database connection..."
    sleep 4
done

priv_stmt='GRANT REPLICATION SLAVE ON *.* TO "root"@"%" IDENTIFIED BY "dinhO959"; FLUSH PRIVILEGES;'
docker exec otus.mysql.master sh -c "export MYSQL_PWD=dinhO959; mysql -u root -e '$priv_stmt'"

until docker exec otus.mysql.slave sh -c 'export MYSQL_PWD=dinhO959; mysql -u root -e ";"'
do
    echo "Waiting for mysql_slave database connection..."
    sleep 4
done

docker-ip() {
    docker inspect --format '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "$@"
}

MS_STATUS=`docker exec otus.mysql.master sh -c 'export MYSQL_PWD=dinhO959; mysql -u root -e "SHOW MASTER STATUS"'`
CURRENT_LOG=`echo $MS_STATUS | awk '{print $6}'`
CURRENT_POS=`echo $MS_STATUS | awk '{print $7}'`

start_slave_stmt="CHANGE MASTER TO MASTER_HOST='$(docker-ip otus.mysql.master)',MASTER_USER='root',MASTER_PASSWORD='dinhO959',MASTER_LOG_FILE='$CURRENT_LOG',MASTER_LOG_POS=$CURRENT_POS; START SLAVE;"
start_slave_cmd='export MYSQL_PWD=dinhO959; mysql -u root -e "'
start_slave_cmd+="$start_slave_stmt"
start_slave_cmd+='"'
docker exec otus.mysql.slave sh -c "$start_slave_cmd"

docker exec otus.mysql.slave sh -c "export MYSQL_PWD=dinhO959; mysql -u root -e 'SHOW SLAVE STATUS \G'"