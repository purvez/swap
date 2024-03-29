<?php


// Free this line for a test
// test();

function array2texttable($data) {
	require "array2texttable.php";

	echo "<pre>";
	$renderer = new ArrayToTextTable($data);
	$renderer->showHeaders(true);
	$renderer->render();
	echo "</pre>";
}

function test() {
	$data = array(
	array('company'=>'AIG', 'id'=>1, 'balance'=> '-$99,999,999,999.00'),
	array('company'=>'Wachovia', 'id'=>2, 'balance'=> '-$10,000,000.00'),
	array('company'=>'HP', 'id'=>3, 'balance'=> '$555,000.000.00'),
	array('company'=>'IBM', 'id'=>4, 'balance'=> '$12,000.00')
	);

	echo "<pre>";
	$renderer = new ArrayToTextTable($data);
	$renderer->showHeaders(true);
	$renderer->render();
	echo "</pre>";
}

?>
