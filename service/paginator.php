<?php
//code tham khảo mà chủ code code ngu qué, phải sửa lại rất mất thời gian 
class Paginator {
 
    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;
 


    public function __construct( $conn, $query ) {
        $this->_conn = $conn;
        $this->_query = $query;
        $rs= $this->_conn->query( $this->_query );
        $this->_total = $rs->num_rows; 
    }

    public function getData($page = 1, $limit = 3 ) {
        $last = ceil( $this->_total / $limit );
        $this->_limit = ($limit > $this->_total) ? $this->_total : $limit;
        $this->_page = ($page < $last) ? $page : $last;
        //echo "/pagination before page: $page, this->page $this->_page, limit: $limit, this->limit $this->_limit . last $last/";
        
    
        //echo "pagination after page: " . $page ."limit" . $limit;
        if ( $this->_limit == 'all' ) {
            $query = $this->_query;
        } else {
            $query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }
        $rs = $this->_conn->query( $query );
    
        while ( $row = $rs->fetch_assoc() ) {
            $results[] = $row;
        }
    
        $result = new stdClass();
        $result->page = $this->_page;
        $result->limit = $this->_limit;
        $result->total = $this->_total;
        $result->data = $results;
    
        return $result;
    }

    public function createLinks( $links, $list_class ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }
        $showing5Page = 5;
    
        $last = ceil( $this->_total / $this->_limit );
    
        $start = (($this->_page - $last) < 0 ) ? $this->_page : $last - ($showing5Page - 3);
        //echo "<h1>start:$start, page: $this->_page, last:  $last</h1>";
        $end  = (($start + $showing5Page) < $last ) ? ($start + $showing5Page) : $last;
    
        $html = '<ul class="' . $list_class . '">';
        
        //start
        $class = ($start == 1 ) ? "disabled" : "";
        $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
    
        if ( $start > 1 ) {
            $html .= '<li class"page-item"><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=1">1</a></li>';
            $html .= '<li class="disabled"><a class="page-link" href="#">...</a></li>';
        }
        
        //page
        for ( $i = $start - floor($showing5Page / 2) ; 0 < $i && $i <= $start; $i++ ) {
            $class = ( $this->_page == $i ) ? "active" : "";
            $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }
        
        for ( $i = $start + 1 ;$i <= $end && $i <= $start + floor($showing5Page / 2); $i++ ) {
            $class = ( $this->_page == $i ) ? "active" : "";
            $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
        }

        //next
        if ( $end < $last ) {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            $html .= '<li><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
        }
    
        $class = ( $end >= $last ) ? "disabled" : "";
        $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?' .$links. 'limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
    
        $html .= '</ul>';
    
        return $html;
    }
}
?>