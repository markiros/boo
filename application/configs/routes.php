<?php

return array('routes' => array(

    'index'                         =>array('route'=> '/',                                'defaults'=>array( 'controller'=>'index',  'action'=>'index' )),
    'viewer-coords'                 =>array('route'=> 'viewer/:z/:x/:y',                  'defaults'=>array( 'controller'=>'index',  'action'=>'viewer' ),'reqs'=>array( 'z'=>'\d+', 'x'=>'\d+', 'y'=>'\d+' )),

));
