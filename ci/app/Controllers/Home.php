<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// echo view('index');
		return redirect()->to(base_url('access'));
	}
	public function quizcode()
	{
		$var = new \App\Models\Variables();
		$data = [
			'quizinput' => $var->where('key', 'quizinput')->find()[0]['value'],
		];
		echo view('header');
		echo view('access', $data);
		echo view('footer');
	}
	public function message($msg, $title = '')
	{
		$data = [
			'msg' => $msg,
			'title' => $title,
		];
		echo view('header');
		echo view('msg', $data);
		echo view('footer');
	}
	public function processcode()
	{
		$incoming = $this->request->getGet();
		// $code = $incoming['code'];
		$session = session();


		$quizlet = new \App\Models\Quiz();
		if (!empty($db = $quizlet->where($incoming)->find())) {
			$res = $db[0];

			$ses_data = [
				'quiz' => $res['id'],
				'code' => $res['code'],
				'title' => $res['title'],
				'description' => $res['description'],
				'published' => $res['published']
			];
			$session->set($ses_data);
			return redirect()->to(base_url('/login'));
		} else {
			$this->message('The Quiz code you entered is incorrect');
		}
	}

	public function login()
	{
		$session = session();
		if ($session->code == '') {
			return redirect()->to(base_url('/access'));
		} else {
			echo view('header');
			echo view('login');
			echo view('footer');
		}
	}

	public function questions()
	{
		$session = session();
		if ($session->Logged_in != true) {
			return redirect()->to(base_url('/login'));
		} else {
			$quizlet = new \App\Models\Quiz();
			$code = $session->code;

			$res = $quizlet->where('code', $code)->find()[0];
			echo view('question', $res);
		}
	}

	public function postquiz()
	{
		$session = session();
		$quizlet = new \App\Models\Quiz();
		$scoresheet = new \App\Models\Scoresheet();
		$code = $session->code;
		$incoming = $this->request->getPost();
		$numbs = range(0, 14);
		$score = 0;

        // var_dump($incoming);

		$res = $quizlet->where('code', $code)->find()[0]['answers'];
		foreach (json_decode($res) as $key => $ans) {
			if (!empty($incoming[$key . 'que' . $key])) {
				if ($incoming[$key . 'que' . $key] == strtolower($ans->ans)) {
					$score++;
				} else {
					$score = $score + 0;
				}
			} else {
				$score = $score + 0;
			}
		}
		// Push the score to the broadsheet

		if (!empty($db = $scoresheet->where(['user' => $session->user, 'quiz' => $session->quiz])->find())) {
			if ($score > $db[0]['score']) {
				$scoresheet->update($db[0]['id'], ['score' => $score, 'answers'=>json_encode($incoming)]);
			}
		} else {
			$data = ['user' => $session->user, 'quiz' => $session->quiz, 'score' => $score, 'sent' => $session->published, 'answers'=>json_encode($incoming)];
			$scoresheet->insert($data);
		}

		if ($session->published) {
			$this->message("Your score is " . $score);
		} else {
			$this->message("Your Quiz has been submitted. You will receive your score via email");
		}
	}

	public function test($code, $do)
	{
		if ($do) {
			$key = ' !u^e_%a#t@';
			$pos = str_split($code);
			$res = '';
			foreach ($pos as $ky => $ps) {
				$res = $res . str_split($key)[$ps];
			}
			return urlencode($res);
		} else {
			$key = ' !u^e_%a#t@';
			$pos = urldecode($code);
			$res = '';
			$pos = str_split($pos);
			$key = str_split($key);
			foreach ($pos as $k => $os) {
				foreach ($key as $ky => $ps) {
					if ($pos[$k] == $ps)
						$res = $res . $ky;
				}
			}
			return $res;
		}
	}

	public function solution($id)
	{

        $session = session();
        if ($session->Logged_in != true) {
            echo view('header');
            echo view('login2',['id'=>$id]);
            echo view('footer');
        } else {
            $id = $this->test($id, 0);

            echo ('<center>Solution for quiz '.$id.'</center><br>');
    		// echo ('<center>Solution for quiz '.$id.'</center><br>');
            $scoresheet = new \App\Models\Scoresheet();
    		$quizlet = new \App\Models\Quiz();
            $result = $quizlet->where('code', $id)->find();
            $res = $result[0]['answers'];
            $que = $result[0]['questions'];
            $id = $result[0]['id'];

            $uAns = [];
            $db = $scoresheet->where(['user' => $session->user, 'quiz' => $id])->find();
            if(!empty($db[0]['answers'])){
                $uAns = json_decode($db[0]['answers']);
                echo ('<center>You Scored <h2>'.$db[0]['score'].'</h2></center><br>');
            }else{
                echo ("<center>User's Answers not recorded</center><br>");
            }
    		// $id = md
            // var_dump($uAns);
    		foreach (json_decode($que) as $ky => $qus) {
    			echo ('('.($ky + 1) . ') ' . $qus->{0} . '<br>');
    			$option = [
    				'a' => $qus->{1},
    				'b' => $qus->{2},
    				'c' => $qus->{3},
    				'd' => $qus->{4},
    			];
    			foreach (json_decode($res) as $ke => $ans) {
    				if ($qus->id == $ans->id) {
    					foreach ($option as $key => $opt) {
    						echo ($key.') '.$opt);
                            $vl = $ke.'que'.$ke;

    						if ($ans->ans == $key) {
                                echo (' &#9989;');
                                // if($uAns->$vl == $key){
                                //     echo (' &#9989;');
                                // }
    						}else{
                               if($uAns->$vl == $key){
                                    echo (' &#10060;');
                                }
                            }
    						echo '<br>';
    					}
    					echo '<br>';
    				}
    			}
    		}
        }
	}


    public function postrlogin($id)
    {
        $Users = new \App\Models\Users();
        $Scoresheet = new \App\Models\Scoresheet();
        $session = session();
        $incoming = $this->request->getPost();
        $incoming['password'] = $incoming['password'];
        $incoming['clearance'] = 1;

        if (!empty($db = $Users->where($incoming)->find())) {
            $ses_data = [
                'email' => $db[0]['email'],
                'user' => $db[0]['id'],
                'Logged_in' => TRUE,
                'clearance' => $db[0]['clearance']
            ];
            $session->set($ses_data);
            return redirect()->to(base_url('/solution/'.$id));
        } else {
            $this->message('You are yet to take a quiz');
        }
    }

	public function postlogin()
	{
		$Users = new \App\Models\Users();
		$Scoresheet = new \App\Models\Scoresheet();
		$session = session();
		$incoming = $this->request->getPost();
		$incoming['password'] = $incoming['password'];
		$incoming['clearance'] = 1;

		if (!empty($db = $Users->where($incoming)->find())) {
			if ($res = $Scoresheet->where(['user' => $db[0]['id'], 'quiz' => $session->quiz])->find()) {
				$this->message('A score has been recorded for this user on this particular quiz');
			} else {
				$ses_data = [
					'email' => $db[0]['email'],
					'user' => $db[0]['id'],
					'Logged_in' => TRUE,
					'clearance' => $db[0]['clearance']
				];
				$session->set($ses_data);
				return redirect()->to(base_url('/questions'));
			}
		} else {
			try {
				$db_id = $Users->insert($incoming);
				$db = $Users->where('id', $db_id)->find();
				$ses_data = [
					'email' => $db[0]['email'],
					'user' => $db[0]['id'],
					'Logged_in' => TRUE,
					'clearance' => $db[0]['clearance']
				];
				$session->set($ses_data);
				return redirect()->to(base_url('/questions'));
			} catch (\Exception $e) {
				$this->message('Email has been used before with a different phone number');
			}
		}
	}

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

	//--------------------------------------------------------------------

}
