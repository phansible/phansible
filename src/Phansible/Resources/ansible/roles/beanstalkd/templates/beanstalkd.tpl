## Defaults for the beanstalkd init script, /etc/init.d/beanstalkd on
## Debian systems. Append ``-b /var/lib/beanstalkd'' for persistent
## storage.
BEANSTALKD_LISTEN_ADDR={{ beanstalkd_listen_addr }}
BEANSTALKD_LISTEN_PORT={{ beanstalkd_listen_port }}
BEANSTALKD_STORAGE={{ beanstalkd_storage }}
DAEMON_OPTS="-l $BEANSTALKD_LISTEN_ADDR -p $BEANSTALKD_LISTEN_PORT {% if beanstalkd_persistent %}-b $BEANSTALKD_STORAGE{% endif %}"

## Uncomment to enable startup during boot.
START={{ beanstalkd_enabled }}