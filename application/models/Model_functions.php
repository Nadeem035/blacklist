<?php
class Model_functions extends CI_Model {

	public function get_results($sql){
		$res = $this->db->query($sql);
		if ($res->num_rows() > 0)
		{
			return $res->result_array();
		}
		else
		{
			return false;
		}
	}
	public function get_row($sql){
		$res = $this->db->query($sql);
		if ($res->num_rows() > 0)
		{
			$resp = $res->result_array();
			return $resp[0];
		}
		else
		{
			return false;
		}
	}
	public function check_email($email = '')
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if(is_string($email))
			{
				return (bool)$this->get_row("SELECT * FROM `user` WHERE `email` = '$email' LIMIT 1");
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	public function login($username, $password, $check = FALSE)
	{
		$username = $this->db->escape(strtolower($username));
		if(!$check){$password = md5($this->db->escape($password));}
		return $this->db->get_row("SELECT * FROM `user` WHERE `username` = \"$username\" AND `password` = \"$password\";");
	}
	public function setting($id)
	{
		return $this->get_row("SELECT * FROM `setting` WHERE `setting_id` = '$id';");
	}
	public function get_user_blacklist($id)
	{
		return $this->get_results("SELECT * FROM `blacklist` WHERE `user_id` = '$id';");
	}
	public function get_blacklist_byid($id)
	{
		return $this->get_row("SELECT * FROM `blacklist` WHERE `blacklist_id` = '$id';");
	}
	public function get_blacklist_record($search)
	{
		$result = $this->get_results("SELECT * FROM `blacklist` WHERE `name` Like '%$search%' OR `phone` = '$search';");
		if ($result) {
			$html = '<div class="product-explorer-main-offerings">
						<div class="product-display">';
			foreach ($result as $key => $record) { 
				$html .='<div class="product-display__tile-wrapper">
		                    <div class="product-display__tile">
		                        <div class="product-display__name-chevron align-items-center" >
		                            <img src="'.UPLOADS.$record['image0'].'" alt="">
		                        </div>
		                    </div>
		                </div>
		                <div class="product-detail" style="grid-row-start: 2;">
		                    <div class="product-detail__header-outer-wrapper">
		                        <div class="product-detail__header-inner-wrapper">
		                            <h2 class="product-detail__category-name">'.$record["name"].'</h2>
		                        </div>
		                    </div>
		                    <div class="product-detail__product">
		                        <div class="basicInfo">
		                            <ul>
		                                <li class="mb-1"><strong>Added date: </strong><span>'.date("Y-m-d", strtotime($record["at"])).'</span></li>
				                        <li class="mb-1"><strong>Email: </strong><span>'.$record["email"].'</span></li>
				                        <li class="mb-1"><strong>Phone: </strong><span>'.$record["phone"].'</span></li>
				                        <li class="mb-1"><strong>Type: </strong><span>'.$record["type"].'</span></li>
				                        <li class="mb-1"><strong>Person/Company: </strong><span>'.$record["company_or_person"].'</span></li>
		                            </ul>
		                            <strong>Detail:</strong>
		                            <p>'.$record["detail"].'</p>
		                        </div>
		                        <div class="basicImages">';
			                        if ($record['image0'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image0'].'" alt="">
					                            </div>';
			                        }
			                        if ($record['image1'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image1'].'" alt="">
					                            </div>';
			                        }
			                        if ($record['image2'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image2'].'" alt="">
					                            </div>';
			                        }
			                        if ($record['image3'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image3'].'" alt="">
					                            </div>';
			                        }
			                        if ($record['image4'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image4'].'" alt="">
					                            </div>';
			                        }
			                        if ($record['image5'] !== '') {
			                            $html .='<div class="imageWrap">
					                                <img src="'.UPLOADS.$record['image5'].'" alt="">
					                            </div>';
			                        }
		                        $html .='</div>
		                    </div>
                		</div>';    
			}
            $html .= '</div>
            	</div>';
			return $html;
		}else{
			return false;
		}
	}

}