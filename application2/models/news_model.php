<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
---------------------------------------------------------------
*	Class:			News_model extends Model defined in Core libraries
*	Author:			
*	Platform:		Codeigniter
*	Company:		Cogniter Technologies
*	Description:	Manage database functionality for news. 
---------------------------------------------------------------
*/

class News_model extends CI_Model {
	
	/**
     * method  get_news
     * Description function for for getting news list
     * @param page integer
     * @param per_page integer
     * @param count integer
    */
	function get_news($page, $per_page = 10,$count=false)
	{
		$this->db->from('news');
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);
		$this->db->where('status',1);

		if(strlen($this->input->get_post('s')) > 0)
		{
			$like = $this->input->get_post('s');
			$this->db->or_like('username',trim($like));
		}
		
		$news = $this->db->get();

		if($count === true) {
			$total = $this->db->count_all('news');
			//$total = $this->db->count();
			return $total;
		}
		else
		{
			if(count($news->result()) > 0)
			{
				return $news->result();
			} else
			{
				return false;
			}
		}
	}
	
	/**
     * method  get_newscount
     * Description 
     * @param $page (int), $per_page (int) ,$count (bool)
     */
	function get_newscount($page, $per_page = 10,$count=false)
	{
		$this->db->from('news');
		$this->db->order_by("id", "desc");
		$this->db->limit($per_page, $page);
		$this->db->where('status',1);
		
		$news = $this->db->get();

		if($count === true) 
		{
			$total = count($news->result());
			//$total = $this->db->count();
			return $total;
		}
		else
		{
			if(count($news->result()) > 0)
			{
				return $news->result();
			} else
			{
				return false;
			}
		}
	}
	/**
     * method  get_news_page
     * Description function for for getting news details
     * @param ID integer
    */
	function get_news_page($id='')
	{
		if(is_null($id)) {
				return false;			
			} else {
				$result = $this->db->get_where('news',array('id'=>$id,'status'=>1));
			}					
			if ( count($result->row()) > 0 )
			{
				return $result->row();
			}
			else{
				return false;
			}
	}
	/*
	 * method  get_consultantnews
	 * for getting consultant news
	 *  $store_id (int),$consultant_id (int) ,$per_page (int) ,$page (int) ,$count (bool)
	*/
	function get_consultantnews($store_id='',$consultant_id='',$per_page = 10,$page,$count=false){
		if($store_id && $consultant_id){
			$this->db->from('news') ;
			
			$this->db->where('status',1) ;
			$this->db->where('store_id',$store_id) ;
			$this->db->where('user_id',$consultant_id) ;

			

			if($count === true) 
			{
				$news= $this->db->get() ;
				$total = count($news->result());
				//$total = $this->db->count();
				return $total;
			}
			else
			{
				$this->db->order_by('id','desc') ;
				$this->db->limit($per_page,$page) ;
				$news= $this->db->get() ;

				if(count($news->result()) > 0)
				{
					
					return $news->result();
				} else
				{
					#echo $this->db->last_query() ;
					#die;
					return false;
				}
			}

		}else{
			return array();
		}
	}

	function get_storenews($store_id='',$consultant_id='',$per_page = 10,$page,$count=false){
		if($store_id ){
			$this->db->from('news') ;
			
			$this->db->where('status',1) ;
			$this->db->where('store_id',$store_id) ;
			$this->db->where('user_id', 0 ) ;

			

			if($count === true) 
			{
				$news= $this->db->get() ;
				$total = count($news->result());
				//$total = $this->db->count();
				return $total;
			}
			else
			{
				$this->db->order_by('id','desc') ;
				$this->db->limit($page,$per_page) ;
				$news= $this->db->get() ;
				if(count($news->result()) > 0)
				{
					#echo $this->db->last_query() ;
					#die;
					return $news->result();
				} else
				{
					#echo $this->db->last_query() ;
					#die;
					return false;
				}
			}

		}else{
			return array();
		}
	}

}
