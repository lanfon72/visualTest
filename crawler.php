<?php

class wikiCrawler {
	public function main()
	{
		for($i = 1;$i <1330;$i ++)
		{
			$result= $this->getData($i);
			if(!$result) echo json_encode($i."\n",JSON_UNESCAPED_UNICODE);
			else echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
	}

	public function getData($page) {
		$url = 'http://zh.pad.wikia.com/wiki/' . $page . '?variant=zh-hant';
		$curl = curl_init($url);
		error_log($url);

		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		$ret = curl_exec($curl);

		$doc = new DOMDocument;
		@$doc -> loadHTML($ret);

		$table_doms = $doc -> getElementsByTagName('table');
		foreach ($table_doms as $table_dom)
		{
			if($table_dom -> getAttribute('class') == 'wikitable' && 
				$table_dom -> getAttribute('style') == "text-align:center; width: 100%")
				break;
		}
		if(!$table_dom) return null;
		$td_doms = $table_dom -> getElementsByTagName('td');
		$results = new StdClass;
		$results -> name = $td_doms ->item(1) -> nodeValue;
		$results -> attr = $td_doms ->item(2) -> nodeValue;
		$results -> type = $td_doms ->item(3) -> nodeValue;
		$results -> count = $td_doms ->item(4) -> nodeValue;
		$results -> star = $td_doms ->item(5) -> nodeValue;
		$results -> maxexp = $td_doms ->item(6) -> nodeValue;
		$results -> style = $td_doms ->item(7) -> nodeValue;
		$results -> cost = $td_doms ->item(9) -> nodeValue;
		$results -> Mlv = $td_doms -> item(10) -> nodeValue;
		$results -> sell = $td_doms -> item(11) -> nodeValue;
		$results -> feed = $td_doms -> item(12) -> nodeValue;
		$results -> hp = $td_doms -> item(13) -> nodeValue;
		$results -> atk = $td_doms -> item(14) -> nodeValue;
		$results -> rec = $td_doms -> item(15) -> nodeValue;
		$results -> score = $td_doms -> item(16) -> nodeValue;
		$results -> mp = $td_doms -> item(17) -> nodeValue;
		$results -> matk = $td_doms -> item(18) -> nodeValue;
		$results -> mrec = $td_doms -> item(19) -> nodeValue;
		$results -> msc = $td_doms -> item(20) -> nodeValue;
		$results -> hpgw = $td_doms -> item(21) -> nodeValue;
		$results -> atkgw = $td_doms -> item(22) -> nodeValue;
		$results -> recgw = $td_doms -> item(23) -> nodeValue;
		$results -> exptype = $td_doms -> item(24) -> nodeValue;

		return $results;
	}
}
$c = new wikiCrawler;
$c->main();
?>