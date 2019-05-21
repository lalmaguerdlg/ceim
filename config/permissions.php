<?php

return [
	'scopes' => [
		'users-create' => 'Crear usuarios',
		'users-read' => 'Consultar usuarios',
		'cursos-write' => 'Crear y Editar cursos',
		'cursos-teach' => 'Poder ser registrado como maestro de un curso',
		'cursos-read' => 'Leer cursos',
		'cursos-register' => 'Poder inscribirse a cursos',
	],
	'roles' => [
		'admin' => '*',
		'maestro' => [
			'users-read', 'cursos-teach', 'cursos-read'
		],
		'alumno' => [
			'users-read', 'cursos-teach', 'cursos-read'
		]
	]
];