<?php

namespace App\Phansible\Controller;

use App\Phansible\Roles\Apache;
use App\Phansible\Roles\Beanstalkd;
use App\Phansible\Roles\Blackfire;
use App\Phansible\Roles\Composer;
use App\Phansible\Roles\ElasticSearch;
use App\Phansible\Roles\Hhvm;
use App\Phansible\Roles\Mariadb;
use App\Phansible\Roles\Mongodb;
use App\Phansible\Roles\Mysql;
use App\Phansible\Roles\Nginx;
use App\Phansible\Roles\Pgsql;
use App\Phansible\Roles\Php;
use App\Phansible\Roles\Rabbitmq;
use App\Phansible\Roles\Redis;
use App\Phansible\Roles\Server;
use App\Phansible\Roles\Solr;
use App\Phansible\Roles\Sqlite;
use App\Phansible\Roles\Xdebug;
use App\Phansible\Roles\Zookeeper;
use DateTimeZone;
use Michelf\Markdown;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;

/**
 * @package Phansible
 */
class DefaultController extends AbstractController
{
    public function indexAction(): Response
    {
//        $config = $this->getParameter('config');
        $config = Yaml::parse(file_get_contents('../config/config.yaml'));

//        $config['boxes']           = Yaml::parse(file_get_contents('../config/phansible/boxes.yaml'));
//        $config['webservers']      = Yaml::parse(file_get_contents('../config/phansible/webservers.yaml'));
//        $config['syspackages']     = Yaml::parse(file_get_contents('../config/phansible/syspackages.yaml'));
//        $config['phppackages']     = Yaml::parse(file_get_contents('../config/phansible/phppackages.yaml'));
//        $config['databases']       = Yaml::parse(file_get_contents('../config/phansible/databases.yaml'));
//        $config['workers']         = Yaml::parse(file_get_contents('../config/phansible/workers.yaml'));
//        $config['peclpackages']    = Yaml::parse(file_get_contents('../config/phansible/peclpackages.yaml'));
//        $config['rabbitmqplugins'] = Yaml::parse(file_get_contents('../config/phansible/rabbitmqplugins.yaml'));

        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/boxes.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/webservers.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/syspackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/phppackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/databases.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/workers.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/peclpackages.yaml')));
        $config = array_merge($config, Yaml::parse(file_get_contents('../config/phansible/rabbitmqplugins.yaml')));

        $config['timezones'] = DateTimeZone::listIdentifiers();

        // Server settings
        $initialValues['server'] = (new Server())->getInitialValues();

        // Deploy roles
//        $initialValues = (new VagrantLocal())->getInitialValues());

        // Webservers
        $initialValues['apache'] = (new Apache())->getInitialValues();
        $initialValues['nginx'] = (new Nginx())->getInitialValues();

        // Languages
        $initialValues['hhvm'] = (new Hhvm())->getInitialValues();

        // Databases
        $initialValues['mysql'] = (new Mysql())->getInitialValues();
        $initialValues['mariadb'] = (new Mariadb())->getInitialValues();
        $initialValues['pgsql'] = (new Pgsql())->getInitialValues();
        $initialValues['mongodb'] = (new Mongodb())->getInitialValues();
        $initialValues['sqlite'] = (new Sqlite())->getInitialValues();
        $initialValues['redis'] = (new Redis())->getInitialValues();

        //Workers
        $initialValues['rabbitmq'] = (new Rabbitmq())->getInitialValues();
        $initialValues['beanstalkd'] = (new Beanstalkd())->getInitialValues();

        // Only if Solr cloud mode is enabled
        $initialValues['zookeeper'] = (new Zookeeper())->getInitialValues();

        // Search Engines
        $initialValues['solr'] = (new Solr())->getInitialValues();
        $initialValues['elasticsearch'] = (new ElasticSearch())->getInitialValues();

        // PHP roles should always be last! this way we can detect other
        // roles and check if we need to add extra packages
        $initialValues['php'] = (new Php())->getInitialValues();
        $initialValues['xdebug'] = (new Xdebug())->getInitialValues();
        $initialValues['composer'] = (new Composer())->getInitialValues();
        $initialValues['blackfire'] = (new Blackfire())->getInitialValues();

//        $roles = $this->getParameter('roles');

//        $initialValues = $roles->getInitialValues();
        $config = ['config' => $config];

        return $this->render('index.html.twig', array_merge($initialValues, $config));
    }

    public function docsAction($doc): Response
    {
        if (!in_array($doc, ['contributing', 'customize', 'usage', 'vagrant'])) {
            throw new NotFoundHttpException();
        }
        $docfile = $this->getParameter('docs.path') . DIRECTORY_SEPARATOR . $doc . '.md';

        $content = '';
        
        if (is_file($docfile)) {
            $content = file_get_contents($docfile);
        }

        return $this->render('docs.html.twig', [
            'content' => $content,
        ]);
    }
}
