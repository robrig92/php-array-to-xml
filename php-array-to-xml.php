<?php

/**
 * Crea un XML desde una matriz con el formato
 * anidado de un XML comenzando con el nodo
 * raíz como un array que contiene todo
 * el árbol del XML.
 * I.E.
 *	'nodoRaiz' => [
 *		'atributo' => value,
 *		'nodoHijo' => [
 *			'atributo' => value,
 *			0 => [
 *				'nodoHijoNombreRepetido' => [
 *					...
 *				]
 * 			],
 *			1 => [
 *				'nodoHijoNombreRepetido' => [
 *					...
 *				]
 * 			]
 * 		],
 *		'nodoHijo2' => [
 *			...
 * 		]
 * 	]
 *
 * @param array $data
 * @param string $dir
 * @param string $fileName
 * @return void
 */
function generaXML($data, $dir, $fileName)
{
	$xml = new DomDocument('1.0', 'UTF-8');

	// LLamamos a la función por primera vez con el primer array
	// que viene siendo el nodo raíz del XML.
	$nodeRoot = createNode($xml, key($data));
	$xml->appendChild($nodeRoot);
	setAttributes($xml, $nodeRoot, $data[key($data)]);

	// Guardando XML
	$xml->formatOutput = true;
	$todo = $xml->savexml(); // con un echo se muestra en pantalla
	$xml->save($dir . $fileName . '.xml');
}

/**
 * Crea un nodo
 *
 * @param DomDocument $xml
 * @param string $key
 */
function createNode(&$xml, $key)
{
	return $xml->createElement($key);
}

/**
 * Itera un array nodo seteando los atributos en
 * caso de topar con otro array nodo lo crea.
 *
 * @param array $data
 */
function setAttributes(&$xml, $nodo, $data)
{
	foreach($data as $key => $value) {
		// echo 'Nodo: ' . $key . '<br>';
		if (!is_array($value)) {
			if (!is_null($value)) {
				$value = filterValue($value);
				$nodo->setAttribute($key, $value);
			}
		} else {
			// Si nos topamos con un array verificamos que
			// no sea un índice númerico, esto significa
			// que debe crearse otro nodo.
			if (!is_integer($key)) {
				$newNode = createNode($xml, $key, $value);
				$nodo->appendChild($newNode);
				setAttributes($xml, $newNode, $value);
			} else {
				// Si llega a ser un índice numérico significa
				// que son nodos hermanos para esto volvemos a
				// iterar en ese arreglo para crear el
				// verdadero nodo.
				setAttributes($xml, $nodo, $value);
			}
		}
	}
}
?>
