## Defaults for the beanstalkd init script, /etc/init.d/beanstalkd on
## Debian systems. Append ``-b /var/lib/beanstalkd'' for persistent
## storage.
BEANSTALKD_LISTEN_ADDR={{ beanstalkd.listenAddress }}
BEANSTALKD_LISTEN_PORT={{ beanstalkd.listenPort }}
BEANSTALKD_STORAGE={{ beanstalkd.storage }}
DAEMON_OPTS="-l $BEANSTALKD_LISTEN_ADDR -p $BEANSTALKD_LISTEN_PORT {% if beanstalkd.persistent %}-b $BEANSTALKD_STORAGE{% endif %}"

