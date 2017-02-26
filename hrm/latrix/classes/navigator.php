<?php

class	Navigator {

	var	$page;
	var	$count;
	var	$max_page;
	var	$isVisible;

	public function __construct(&$page,$count){
		$this->page = $page;
		$this->count = $count;
		if ($count % $this->page->company['page_size'] == 0) {
			$this->max_page = $count/$this->page->company['page_size'];
		} else {
			$this->max_page = floor($count/$this->page->company['page_size'])+1;
		}
		$this->isVisible = true;
	}
	
	public function setVisible($value){
		if ($value) {
			$this->isVisible = true;
		} else {
			$this->isVisible = false;
		}
	}
	
	public function build4pages() {

	$out = "";
	$curpage = $this->page->ctrl['page'];
	if ($curpage - 1 > 0) {
		$out2 = "\t\t\t<a href=\"#\" class=\"nav-bar\" onclick=\"SetPage(".($curpage - 1).",'show');\"";
		$out2 .= " title=\"Move to previous page\">";
		$out2 .= "-1</a> | \n";
		$out = $out2.$out;
	}
	if ($curpage < $this->max_page) {
		$out2 = "\t\t\t<a href=\"#\" class=\"nav-bar\" onclick=\"SetPage(".($curpage + 1).",'show');\"";
		$out2 .= " title=\"Move to next page\">";
		$out2 .= "+1</a> | \n";
		$out = $out.$out2;
	}
	$factor = 2;
	do {
		if ($curpage - $factor > 0) {
			$out2 = "\t\t\t<a href=\"#\" class=\"nav-bar\" onclick=\"SetPage(".($curpage - $factor).",'show');\"";
			$out2 .= " title=\"Move ".$factor." pages back\">";
			$out2 .= "-".$factor."</a> | \n";
			$out = $out2.$out;
			}
		if ($curpage + $factor < $this->max_page) {
			$out2 = "\t\t\t<a href=\"#\" class=\"nav-bar\" onclick=\"SetPage(".($curpage + $factor).",'show');\"";
			$out2 .= " title=\"Move ".$factor." pages forward\">";
			$out2 .= "+".$factor."</a> | \n";
			$out = $out.$out2;
			}
		$factor = $factor * $factor;
		} while ($factor < $this->max_page);

	$out2 = "<div class=\"nav-bar\"><b>Nav:</b> Page ".$curpage;
	if ($this->max_page > 1) {
		$out2 .= " of ".$this->max_page." pages.\n";
		} else {
		$out2 .= "</div>\n";
		return $out2;
		}
	$out2 .= "\t\t\t | <a href=\"#\" class=\"nav-bar\" title=\"Move to first page\" onclick=\"SetPage(1,'show');\">";
	$out2 .= "First</a> | \n";
	$out = $out2.$out;
	$out .= "\t\t\t<a href=\"#\" class=\"nav-bar\" title=\"Move to last page\" onclick=\"SetPage(".$this->max_page.",'show');\">";
	$out .= "Last</a> | \n";
	$out .= " Move to page <input type=text id='newpage' name='newpage' class=\"nav-bar\" size=2 >";
	$out .= "<a href=\"#\" class=\"nav-bar\" onclick=\"GoToPage();\">Go!</a>\n\t\t</div>\n";
	return $out;
	}
	
	public function build4records(&$view) {
	
	/*	We need a special trick here. Due to the fact that we store details for multiple companies, the record IDs are not the same as what 
		the normal user might expect (straight numbering from 1 to max).
		We will do this by using a display ID. This is derived from the table view (where it can be calculated based on the position in the grid and 
		the page value). From there it just moves with the record.
	*/
	
	if ($this->isVisible == false) {return;}
	$out = "<div class=\"nav-bar\">Record ".$view->page->ctrl['display'];
	if ($this->count > 1) {
		$out .= " of ".$this->count.".\n";
		} else {
		return $out;
		}
	$out .= "\t\t\t | <a href=\"#\" class=\"nav-bar\" title=\"Move to first record\" onclick=\"SetAction('".$view->item->firstrecord."','1','move');\">First</a> | \n";
	if ($view->page->ctrl['display'] - 1 > 0) {
		$out .= "\t\t\t<a href=\"#\" class=\"nav-bar\" title=\"Move to previous record\" onclick=\"SetAction('".$view->item->prevrecord;
		$out .= "','".($view->page->ctrl['display'] - 1)."','move');\">-1</a> | \n";
		}
	if ($view->page->ctrl['display'] + 1 < $this->count) {
		$out .= "\t\t\t<a href=\"#\" class=\"nav-bar\" title=\"Move to next record\" onclick=\"SetAction('".$view->item->nextrecord;
		$out .= "','".($view->page->ctrl['display'] + 1)."','move');\">+1</a> | \n"; 
		}
	$out .= "\t\t\t<a href=\"#\" class=\"nav-bar\" title=\"Move to last record\" onclick=\"SetAction('".$view->item->lastrecord;
	$out .= "','".$this->count."','move');\">Last</a>\n\t\t</div>\n";
	return $out;
	}
}

?>