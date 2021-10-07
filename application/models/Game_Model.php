<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Game_Model extends CI_Model
	{
		public function submit()
		{
			$player1 = $this->input->post("player1name");
			$player2 = $this->input->post("player2name");
			var_dump($player2);
			if($this->input->post("player1name") != $this->input->post("player2name"))
			{
				$data = array(
					"player1name" => $this->input->post("player1name"),
					"player2name" => $this->input->post("player2name"),
					"winner" => $this->input->post("winner")
				);	

				$this->db->insert('results', $data);
			}
			else
			{
				$this->session->set_flashdata('error_msg', 'Problem With Entering Names');
				redirect(base_url('Main_Controller/index'));
				return false;
			}
		}

		public function getPlayerNames()
		{
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('results');

			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return false;
			}
		}

		public function saveResult()
		{
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);

			if($this->input->post('winner') == "")
			{
				$cancelled = "Cancelled game";
				$data = array(
					'winner' => $cancelled
				);

			}
			else
			{
				$data = array(
					'winner' => $this->input->post('winner')
				);	
			}
			
			$this->db->update('results', $data);
		}
		
		public function results_count()
		{
			return $this->db->count_all("results");
		}
		
		public function fetchResults($limit, $start)
		{
			$this->db->limit($limit, $start);
			$query = $this->db->get("results");

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row) 
				{
					$data[]=$row;
				}
				return $data;
			}
			else
			{
				return false;
			}
		}

		public function getLastFiveMatches()
		{
			$this->db->order_by('id', 'desc');
			$this->db->limit(5);
			$query = $this->db->get('results');

			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			else
			{
				return false;
			}
		}

		public function savePlayerVsComp()
		{
			$player1 = $this->input->post("player1name");
			$player2 = "Computer";
			
			$data = array(
				"player1name" => $this->input->post("player1name"),
				"player2name" => $player2
			);	

			$this->db->insert('results', $data);
		}
	}
?>