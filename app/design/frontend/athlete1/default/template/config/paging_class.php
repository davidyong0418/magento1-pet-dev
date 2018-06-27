<?php
Class Pager {
	function findStart( $limit ) {
		if ( ( !isset( $_GET['page'] ) ) || ( $_GET['page'] == "1" ) ) {
			$start        = 0;
			$_GET['page'] = 1;
		} else {
			$start = ( $_GET['page'] - 1 ) * $limit;
		}
		return $start;
	}
	function findPages( $count, $limit ) {
		$pages = ( ( $count % $limit ) == 0 ) ? $count / $limit : floor( $count / $limit ) + 1;
		return $pages;
	}
	function pageList( $curpage, $pages ) {
		$page_list = "";
		if ( ( $curpage != 1 ) && ( $curpage ) ) {
			$page_list .= "  <li><a href=\"" . $_SERVER['PHP_SELF'] . "?page=1&mode=".$_GET['mode']."\" title=\"First Page\"><<</a></li> ";
		}
		if ( ( $curpage - 1 ) > 0 ) {
			$page_list .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ( $curpage - 1 ) . "&mode=".$_GET['mode']."\" title=\"Previous Page\"><</a></li> ";
		}
		for ( $i = 1; $i <= $pages; $i++ ) {
			if ( $i == $curpage ) {
				$page_list .= "<li  ><a style='background-color:#999;color:#000'>" . $i . "</a></li>";
			} else {
				$page_list .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $i . "&mode=".$_GET['mode']."\" title=\"Page " . $i . "\">" . $i . "</a></li>";
			}
			$page_list .= " ";
		}
		if ( ( $curpage + 1 ) <= $pages ) {
			$page_list .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ( $curpage + 1 ) . "&mode=".$_GET['mode']."\" title=\"Next Page\">></a></li> ";
		}
		if ( ( $curpage != $pages ) && ( $pages != 0 ) ) {
			$page_list .= "<li><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $pages . "&mode=".$_GET['mode']."\" title=\"Last Page\">>></a><li> ";
		}
		$page_list .= "</td>\n";
		return $page_list;
	}
	function nextPrev( $curpage, $pages ) {
		$next_prev = "";
		if ( ( $curpage - 1 ) <= 0 ) {
			$next_prev .= "Previous";
		} else {
			$next_prev .= "<li class='prev'><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ( $curpage - 1 ) . "&mode=".$_GET['mode']."\">Previous</a></li>";
		}
		$next_prev .= " | ";
		if ( ( $curpage + 1 ) > $pages ) {
			$next_prev .= "Next";
		} else {
			$next_prev .= "<li class='next'><a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ( $curpage + 1 ) . "&mode=".$_GET['mode']."\">Next</a></li>";
		}
		return $next_prev;
	}
}
?>