<?php namespace App\Controllers;

use App\Models\SimpleModel;
use App\Models\WordModel;
use App\Models\ExpModel;

class Home extends BaseController
{
	public function index()
	{
		$WM = new WordModel();
		$EM = new ExpModel();
		$SM = new SimpleModel();
		
		$data = array(
			'LowSeeWords'=> $WM->GetLowSeeWords(),
			'TotalExp' => $EM->GetTotalExp(),
		);
		
		// print_r($data);die();

		echo view('Header');
		echo view('Home',$data);
		echo view('Footer');
	}
	/// GET StrChildViewed : word1_word2_word3, _ split
	public function word($word='empty',$Parent = "")
	{
		$WM = new WordModel();
		$EM = new ExpModel();

		$wordObj =  $WM->GetWord($word);
		$len = strlen($wordObj->word);
		$classWordSize = 'w3-jumbo';
		if($len>=7) $classWordSize = 'w3-xxxlarge';
		if($len>=10) $classWordSize = 'w3-xxlarge';
		if($len>=13) $classWordSize = 'w3-xlarge';
		
		$IsChildPage = strlen($Parent) > 0;
		$classWordColor = $IsChildPage ? "w3-text-green" : 'w3-text-blue';
		// list child viewed		
		$ListChildViewed = array();
		$StrChildViewed = "";
		if(isset($_GET['StrChildViewed'])) 
			$StrChildViewed = $_GET['StrChildViewed'];
		if(strlen($StrChildViewed)>0)
			$ListChildViewed = explode("_",$StrChildViewed);
		if($IsChildPage && !in_array($word,$ListChildViewed)){
			array_push($ListChildViewed,$word);
		}
		$StrChildViewedNew = implode("_",$ListChildViewed);		
		// process viewed (parent page)	
		$meanArrayStatusNEW = array();
		foreach($wordObj->meanArrayStatus as $WordMeanStatus){
			$WordMeanStatus->IsViewed = FALSE;
			if(in_array($WordMeanStatus->word,$ListChildViewed)){
				$WordMeanStatus->IsViewed = TRUE;
			}
			array_push($meanArrayStatusNEW,$WordMeanStatus);
		}
		$wordObj->meanArrayStatus = $meanArrayStatusNEW;
		// percent viewed / exp
			// unique word
		$ArrayMeanStatusExistUnique = array();
		foreach($wordObj->meanArrayStatus as $WordMeanStatus){
			$ArrayUniqueTemp = array_column($ArrayMeanStatusExistUnique,"word");
			if(!in_array($WordMeanStatus->word,$ArrayUniqueTemp)){
                array_push($ArrayMeanStatusExistUnique,$WordMeanStatus);
			}
		}
			// calculate percent
		$CountChildExist=0;
		$Percent = 0;
		foreach($ArrayMeanStatusExistUnique as $WordMeanStatus){
			if($WordMeanStatus->isExist) $CountChildExist++;
		}
		if($CountChildExist>0){
			$Percent = round(count($ListChildViewed)/$CountChildExist*100,0);
		}
			// override Percent for child page
		$Percent = $IsChildPage ? $_GET['Percent'] : $Percent;
			// exp
		$Exp = count($ListChildViewed) * RATE_VIEW_WORD_EXP;
		$IsLearnSucess = !$IsChildPage && (int) $Percent === 100;
		if($IsLearnSucess){
			$EM->Add((object)array(
				'wordId'=> $wordObj->id,
				'exp'=> $Exp,
			));
		}
		//
		$data= array(
			'wordObj'=> $wordObj,
			'classWordSize'=> $classWordSize,
			'IsChildPage' => $IsChildPage,
			'Parent' => $Parent,
			'classWordColor'=> $classWordColor,
			'StrChildViewedNew' => $StrChildViewedNew,
			'Percent' => $Percent,
						// skip calculate Percent child page
			'IsLearnSucess' => $IsLearnSucess,
			'Exp' => $Exp,
		);
		//	

		// var_dump($data);die();
		
		echo view('Header');
		echo view('Word',$data);
		echo view('Footer');
	}
	
}
