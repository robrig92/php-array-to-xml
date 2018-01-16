<?php

include_once './php-array-to-xml.php';

$myArray = [
	'root' => [
		'attribute1' => 'valAttr1',
		'attribute2' => 'valAttr2',
		'children1' => [
			'attribute1' => 'valAttr1',
			'sibling1' => [
				'attribute1' => 'valAttr1',
				0 => [
					'twinNode' => [
						'attribute1' => 'valAttr1'
					]
				],
				1 => [
					'twinNode' => [
						'attribute1' => 'valAttr1'
					]
				]
			],
			'sibling2' => [
				'attribute1' => 'valAttr1',
				'!nodeValue!' => 'Innet text value'
			]
		],
		'children2' => [
			'tacos' => 'pastor'
		]
	]
];

$dir = './';
$fileName = 'example';

generaXML($myArray, $dir, $fileName);

?>
