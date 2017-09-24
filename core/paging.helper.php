<?php
class PagingHelper{
	protected $pageIndex;
	protected $pageSize;
	protected $pageCount;
	protected $totalResults;
	protected $pageNumberArray;
	protected $currentPage;
	public $resultStart;
	protected $resultEnd;
	protected $numPageNumbersToDisplay = 20;
	protected $totalPageNumbersBeingDisplayed = 0;
	function __construct($pagingData){
		if(!is_array($pagingData)){
			throw Exception('Invalid paging data.');
		}
		$this->pageIndex = $pagingData['pageIndex'];
		$this->pageSize = $pagingData['pageSize'];
		$this->totalResults = $pagingData['totalResults'];
		if($this->totalResults > 0){
			$this->pageCount = ceil($this->totalResults/$this->pageSize);
		}
		$this->currentPage = $this->pageIndex+1;
		$this->resultStart = ($this->pageSize*$this->pageIndex)+1;
		if($this->resultStart+$this->pageSize < $this->totalResults){
			$this->resultEnd = ($this->currentPage*$this->pageSize);
		}else{
			$this->resultEnd = $this->totalResults;
		}
		// Build list of page numbers to display
		$this->pageNumberArray[1] = 1;
		for($i=$this->pageIndex,$j=$this->pageIndex+1;$this->totalPageNumbersBeingDisplayed<($this->numPageNumbersToDisplay-1) && ($i>1 || $j<$this->pageCount);$i--,$j++){
			if($j<$this->pageCount){
				$this->pageNumberArray[$j] = $j;
				$this->totalPageNumbersBeingDisplayed++;
			}
			if($i>1 && $this->totalPageNumbersBeingDisplayed < $this->numPageNumbersToDisplay-1){
				$this->pageNumberArray[$i] = $i;
				$this->totalPageNumbersBeingDisplayed++;
			}
		}
		ksort($this->pageNumberArray);
		$this->pageNumberArray[$this->pageCount] = $this->pageCount;
	}
	/**
	 * Getter for $resultStart
	 */
	public function getResultStart(){
		return $this->resultStart;
	}
	/**
	 * Display the current page number, and the last page number, and a list of clickable page numbers.
	 */
	public function displayPageNumberOverview(){ ?>
	<div class="pagination">
			<?php if($this->pageCount > 1){ ?>
			<span class="overview">Page <?php echo $this->currentPage; ?> of <?php echo $this->pageCount; ?> |</span>
			<?php foreach($this->pageNumberArray as $page){ ?><a class="page<?php if($page == $this->currentPage){ ?> selected<?php } ?>" href="#<?php echo $page; ?>"><?php echo $page; ?></a><?php } ?>
		<?php } ?>
		<?php $this->displayResultOverview(); ?>
	</div>
	<?php }
	/**
	 * Display the current range of results being displayed, and the total number of results.
	 */
	public function displayResultOverview(){ ?>
		<span class="right">Showing results <?php echo $this->resultStart; ?> - <?php echo $this->resultEnd; ?> of <?php echo $this->totalResults; ?></span><?php
	}
}
?>