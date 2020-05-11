<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Home extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();

		// Words
		$Amount = 3;
		$ListLowSeeWords = $SM->Query("select Word,Count from Word 
        where Count = (select min(Count) from Word)
        ORDER BY RAND() limit $Amount")
        ->getResult();

		// Exp
		$TotalExp = $SM->Query("select sum(Exp) as Total from Exp")
		->getRow(1)->Total;

		$Data = array(
			'LowSeeWords'=> $ListLowSeeWords,
			'TotalExp' => $TotalExp,
		);
		
		// print_r($Data);die();

		echo view('Header');
		echo view('Home',$Data);
		echo view('Footer');
	}
}
