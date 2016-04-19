<?php
$container = new tad_DI52_Container();

$container->register('restquery_ServiceProviders_Activation');
$container->register('restquery_ServiceProviders_QueryHooks');

return $container;
