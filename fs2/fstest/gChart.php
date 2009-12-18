<?php
	class gChart{
		private $baseUrl = "http://chart.apis.google.com/chart?";
		
		public $types = array ("lc","lxy","bhs","bvs","bhg","bvg","p","p3","v","s");
		public $type = 1;
		public $dataEncodingType = "t";
		public $values = Array();
		public $valueLabels = Array();
		public $width = 200;
		public $height = 200;
		
		private function encodeData($data, $encoding, $separator){
			switch ($this->dataEncodingType){
				case "s":
					return $this->simpleEncodeData();
				case "e":
					return $this->extendedEncodeData();
				default:
					return $this->textEncodeData($data, $separator);
			}
		}
		
		private function textEncodeData($data, $separator){
			$retStr = "";
			foreach($data as $currValue)
				$retStr .= $currValue.$separator;
				
			$retStr = trim($retStr, $separator);
			$data = null;
			$separator = null;
			return $retStr;
		}
		
		private function simpleEncodeData(){
			return "";
		}
		
		private function extendedEncodeData(){
			return "";
		}
		
		public function getUrl(){
			$fullUrl .= $this->baseUrl;
			$fullUrl .= "cht=".$this->types[$this->type];
			$fullUrl .= "&chs=".$this->width."x".$this->height;
			$fullUrl .= "&chd=".$this->dataEncodingType.":".$this->encodeData($this->values,"" ,",");
			$fullUrl .= "&chl=".$this->encodeData($this->valueLabels,"", "|");
			return $fullUrl;
		}
	}
?>