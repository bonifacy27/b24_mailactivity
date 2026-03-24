<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

$arActivityDescription = [
	'NAME' => GetMessage('BPCMAA_DESCR_NAME'),
	'DESCRIPTION' => GetMessage('BPCMAA_DESCR_DESCR'),
	'TYPE' => ['activity', 'robot_activity'],
	'CLASS' => 'CustomMailActivity',
	'JSCLASS' => 'BizProcActivity',
	'CATEGORY' => [
		'ID' => 'interaction',
	],
	'ROBOT_SETTINGS' => [
		'CATEGORY' => 'employee',
		'TITLE' => GetMessage('BPCMAA_DESCR_NAME'),
		'RESPONSIBLE_PROPERTY' => 'MailUserToArray',
		'GROUP' => ['informingEmployee'],
		'SORT' => 1000,
	],
];
