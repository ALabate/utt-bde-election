<?php

return [
	// Informations en rapport avec le site etu
	'etuutt' => [
		'publicuri' => 'https://etu.utt.fr', // base uri used to redirect user
		'baseuri' => 'https://etu.utt.fr', // base uri used to connect to api
		'appid' => '',
		'appsecret' => ''
	],

	// Login et email de l'arbitre qui pourra voir les résultats
	// ainsi que modifier les listes
	'referer' => [
		'login' => '',
		'email' => ''
		],

	// Liste des login des personnes pouvant lire les résultats pendant
	// et après les elections sans pouvoir modifier les parametres
	'viewer' => [ '' ],

	// Date de début et de fin d'election
	'start' => new DateTime('2016-01-01 00:00:01', new DateTimeZone('Europe/Paris')),
	'end' => new DateTime('2016-02-01 23:59:59', new DateTimeZone('Europe/Paris')),

	// Seul les cotisants peuvent voter
	// Cette application prend en charge une liste de 'login' et une liste d''ID etu' en même temps.
	// Le mieux est d'utiliser la liste de 'login' car certaines personnes sont cotisantes sans être
	// 		à l'utt et n'ont donc pas de numero etu
	// Néanmoins, si vous utilisez le format 'ID etu', vous pourrez toujours rajouter les personnes
	// n'ayant pas de numero etu manuellement dans la liste de login
	'cotisants' => [
		'login' => [ 'example1', 'example2', 'example3' ],
		'id' => [ 1, 2, 3 ]
	],

];
