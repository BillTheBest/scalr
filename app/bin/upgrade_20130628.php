#!/usr/bin/env php
<?php

// Migration to new config script

define("NO_TEMPLATES", 1);

require_once __DIR__ . '/../src/prepend.inc.php';

set_time_limit(0);

$ScalrUpdate = new Update20130628();
$ScalrUpdate->Run();

class Update20130628
{

    public function Run()
    {
        $container = Scalr::getContainer();
        $db = $container->adodb;

        $db->Execute('DROP TABLE IF EXISTS `services_mongodb_config_servers`');
        $db->Execute('CREATE TABLE IF NOT EXISTS `services_mongodb_config_servers` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `farm_role_id` int(11) NOT NULL,
        `config_server_index` tinyint(1) NOT NULL,
        `shard_index` tinyint(2) NOT NULL,
        `replica_set_index` tinyint(2) NOT NULL,
        `volume_id` varchar(36) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `farm_roleid_index` (`farm_role_id`,`config_server_index`),
        KEY `farm_role_id` (`farm_role_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;');

        $db->Execute('
            ALTER TABLE `services_mongodb_config_servers`
            ADD CONSTRAINT `services_mongodb_config_servers_ibfk_1` FOREIGN KEY (`farm_role_id`) REFERENCES `farm_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
        ');
    }
}
