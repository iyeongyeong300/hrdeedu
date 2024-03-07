<?
class Page
{
    var $pg; //-- 현제 페이지
    var $tot_no; //--전체 게시물수
    var $page_size; //--한번에 보여줄 게시물수
    var $page_count; //--전체 페이지수
    var $page_start; //--게시물 시작위치
    var $page_uncount; //--게시물 번호
    
    var $block_size; //--한번에 보여줄 불럭수
    var $block_count; //--전체 불럭수
    var $block; //--현재 불럭수
    var $block_start; //--불럭시작수
    var $block_end; //--불럭 끝수
    
    var $block_list; //--불럭의 내용을 담을 변수
    var $script; //-- 페이지관련 자바스크립트
    
    
    
    function Page($class_pg,$class_tot_no,$class_page_size,$class_block_size){
        $this->pg = $class_pg;
        $this->tot_no = $class_tot_no;
        $this->page_size = $class_page_size;
        $this->block_size = $class_block_size;
        
        $this->page_count = ceil($this->tot_no/$this->page_size); //전체 페이지수
        $this->page_start = ($this->pg - 1) * $this->page_size; //게시물 시작위치
        $this->page_uncount = $this->tot_no - $this->page_start; //게시물 번호
        
        $this->block_count = ceil($this->page_count/$this->block_size);///////// 전체 불럭수
        $this->block = ceil($this->pg/$this->block_size); //////////////////////////// 현재 불럭수
        $this->block_start = (($this->block - 1) * $this->block_size) + 1; ///////// 불럭시작수
        $this->block_end = $this->block * $this->block_size; /////////////////////// 불럭 끝수
    }


    function blockList()
    {
        $b_start = $this->block_start;
        $block_str = '<div class="paginate"><ol class="page_list">';
        //-- 이전 블럭
        if($this->block != 1)
        {
            $temp = $this->block_start - 1;
            $block_str .= '<li class="page"><button type="button" class="button_pre" onclick="javascript:pageRun(' . $temp . ');"></button></li>';
        }
        else
        {
            $block_str .= '';
        }

        //--블럭 리스트
        $arrBlock = array();
        while($b_start <= $this->block_end && $b_start <= $this->page_count )
        {
            $arrBlock[] = 	$b_start++;
        }
        
        for($i = 0; $i < count($arrBlock); $i++)
        {
            if($this->pg != $arrBlock[$i])
            {
                $block_str .= '<li class="page"><button type="button" class="page_link" onclick="javascript:pageRun(' . $arrBlock[$i] . ');">'.$arrBlock[$i].'</button></li>';
            }
            else
            {
                $block_str .= '<li class="page"><button type="button" class="page_selected" onclick="javascript:pageRun(' . $arrBlock[$i] . ');">'.$arrBlock[$i].'</button></li>';
            }
            if($i < (count($arrBlock) - 1) ) $block_str .= "  ";
        }

        
        //다음 블럭
        if($this->block != $this->block_count && $this->tot_no != 0){
            $temp = $this->block_end + 1;
            $block_str .= '<li class="page"><button type="button" class="button_next" onclick="javascript:pageRun(' . $temp . ');"></button></li>';
        }
        else
        {
            $block_str .= '';
        }

        $block_str .= '</ol></div>';

        return $block_str;
    }
}
?>