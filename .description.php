<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arActivityDescription = [
	'NAME' => GetMessage('BPCMAA_DESCR_NAME'),
	'DESCRIPTION' => GetMessage('BPCMAA_DESCR_DESCR'),
	'TYPE' => 'activity',
	'CLASS' => 'CustomMailActivity',
	'JSCLASS' => 'BizProcActivity',
	'CATEGORY' => [
		'ID' => 'other',
	],
	'ROBOT_SETTINGS' => [
		'CATEGORY' => 'client',
	],
];
