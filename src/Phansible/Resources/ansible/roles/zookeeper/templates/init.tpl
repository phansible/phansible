#!/bin/sh
#
#chkconfig: 2345 20 80
#
### BEGIN INIT INFO
# Provides:          zookeeper
# Required-Start:    $remote_fs $syslog
# Required-Stop:     $remote_fs $syslog
# Default-Start:
# Default-Stop:
# Description:       Controls Apache ZooKeeper as a Service
### END INIT INFO

ZOOKEEPER_INSTALL_DIR={{ zookeeper_path }}

if [ ! -d "$ZOOKEEPER_INSTALL_DIR" ]; then
  echo "$ZOOKEEPER_INSTALL_DIR not found! Please check the ZOOKEEPER_INSTALL_DIR setting in your $0 script."
  exit 1
fi

case "$1" in
  start|start-foreground|stop|restart|status|upgrade|print-cmd)
    ZOOKEEPER_CMD=$1
    ;;
  *)
    echo "User: $0 {start|start-foreground|stop|restart|status|upgrade|print-cmd}"
    exit
esac

$ZOOKEEPER_INSTALL_DIR/bin/zkServer.sh $ZOOKEEPER_CMD
