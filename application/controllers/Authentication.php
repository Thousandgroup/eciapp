<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

/**
 * Constructor
 *
 * Loads the form validation library
 *
 * @return	void
 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

/**
 * Loads the login view
 *
 * @return void
 */
	public function index()
	{
		$this->load->view('layouts/login');
	}

/**
 * Process login data and authenticate user
 *
 * @return void
 */
	public function process_login()
	{
		$employee_id = $this->input->post('employee_id');
		$password = $this->input->post('password');

		if ($this->_validate_input() == TRUE) {
			// proses autentikasi user
			$this->_login($employee_id, $password);
		} else {
			// tampilkan pesan error
			$this->session->set_flashdata('type', 'warning');
			$this->session->set_flashdata('message', validation_errors());
			redirect('login');
		}
	}

/**
 * Validate input for login process
 *
 * Validate input for employee_id and password
 * 
 * @return	bool True if input is valid, false otherwise
 */
	private function _validate_input()
	{
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			return false;
		} else {
			return true;
		}
	}

/**
 * Process login data and authenticate user
 *
 * Process login data, validate input, and authenticate user
 * 
 * @param string $employee_id Employee ID
 * @param string $password Password
 *
 * @return void
 */
	private function _login($employee_id, $password)
	{
		$employeeId = $this->security->xss_clean($employee_id);
		$password = $this->security->xss_clean($password);
		$ip = get_real_ip();

		$locked_minutes = $this->_is_locked_out($ip);

		if ($locked_minutes)
		{
			$this->session->set_flashdata('type', 'error');
			$this->session->set_flashdata('message', "Too many failed login attempts. Please try again in $locked_minutes minutes.");
			redirect('login');
			return;
		}

		$user = $this->db->get_where('user', ['nik' => $employeeId])->row_array();

		if ($user && $user['is_active'] == 1 && password_verify($password, $user['password'])) {
            $this->_clear_login_attempts($ip);
            $this->_update_last_login($user['nik'], $ip);
            $this->_record_login_history($user['nik'], $ip);

            $this->session->sess_regenerate(TRUE);
            $this->session->set_userdata([
                'name' => $user['name'],
                'nik' => $user['nik'],
                'dept_id' => $user['dept_id'],
                'level_id' => $user['level_id'],
                'role_id' => $user['role_id'],
                'logged_in' => TRUE
            ]);
            $this->session->set_userdata('test', 'abc');


            log_message('info', 'User ' . $user['nik'] . ' logged in from ' . $ip);

            redirect($user['role_id'] == 1 ? 'admin' : 'user');
        } else {
            $this->_record_failed_login_attempts($ip);
			$this->session->set_flashdata('type', 'warning');
            $this->session->set_flashdata('message', 'Invalid credentials. Please try again');
            redirect('login');
        }

	}

/**
 * Check if an IP address is currently locked out due to too many failed login attempts
 * 
 * @param string $ip IP address to check
 * 
 * @return int Number of minutes remaining until the lockout is lifted, or FALSE if not locked out
 */
	private function _is_locked_out($ip)
    {
        $lockout_time = 300; // 15 menit
        $max_attempts = 5;

        $attempt = $this->db->get_where('login_attempts', ['ip_address' => $ip])->row_array();

        if ($attempt && $attempt['attempts'] >= $max_attempts) {
            $elapsed = time() - strtotime($attempt['last_attempt']);

            if ($elapsed < $lockout_time) {
                // Hitung sisa waktu dalam menit
                $remaining_seconds = $lockout_time - $elapsed;
                $remaining_minutes = ceil($remaining_seconds / 60);
                return $remaining_minutes; // return menit tersisa
            } else {
                // Sudah lewat waktu lockout → reset data
                $this->db->delete('login_attempts', ['ip_address' => $ip]);
            }
        }
        return false;
    }

/**
 * Clears the login attempts record for a given IP address
 * 
 * @param string $ip IP address to clear the login attempts record for
 */
	private function _clear_login_attempts($ip)
    {
        $this->db->delete('login_attempts', ['ip_address' => $ip]);
    }

/**
 * Update the last login time for a given user
 * 
 * @param string $nik NIK of the user to update the last login time for
 * @param string $ip IP address to associate with the last login time
 */
	private function _update_last_login($nik, $ip)
    {
        // Simpan ke database saat login berhasil
        $this->db->set('ip_address', $ip)
            ->set('last_login', date('Y-m-d H:i:s'))
            ->where('nik', $nik)
            ->update('user');
    }

/**
 * Record a login history for a given user
 * 
 * Records a login history for a given user, including the user's NIK, IP address, user agent, and login time
 * 
 * @param string $nik NIK of the user to record the login history for
 * @param string $ip IP address to associate with the login history
 */
	private function _record_login_history($nik, $ip)
    {
        $user_agent = $this->input->user_agent();

        $this->db->insert('login_history', [
            'nik' => $nik,
            'ip_address' => $ip,
            'user_agent' => $user_agent,
            'login_time' => date('Y-m-d H:i:s')
        ]);
    }

/**
 * Record a failed login attempt for a given IP address
 * 
 * Records a failed login attempt for a given IP address, including the number of attempts and the time of the last attempt
 * 
 * @param string $ip IP address to associate with the failed login attempt
 */
	private function _record_failed_login_attempts($ip)
    {
        $query = $this->db->get_where('login_attempts', ['ip_address' => $ip]);
        if ($query->num_rows() > 0) {
            $this->db->set('attempts', 'attempts+1', FALSE);
            $this->db->set('last_attempt', date('Y-m-d H:i:s'));
            $this->db->where('ip_address', $ip);
            $this->db->update('login_attempts');
        } else {
            $this->db->insert('login_attempts', [
                'ip_address' => $ip,
                'attempts' => 1,
                'last_attempt' => date('Y-m-d H:i:s')
            ]);
        }
    }

/**
 * Displays the forgot password page
 * 
 * This function loads the forgot password view, which contains a form to
 * enter an employee ID and request a password reset link.
 * 
 * @return void
 */
    public function forgot_password()
    {
        $this->load->view('layouts/forgot_password');
    }

    public function send_reset_link()
    {
        $employee_id = $this->input->post('employee_id');
        //validate employee id
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required|numeric|min_length[10]|max_length[10]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('type', 'warning');
            $this->session->set_flashdata('message', validation_errors());
            redirect('forgot-password');
            return;
        }
        $user = $this->db->get_where('user', ['nik' => $employee_id, 'is_active' => 1])->row_array();

        if ($user) {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $user['email'],
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user_token', $user_token);
            $this->_send_email($token, $user['email'], 'forgot');

            $this->session->set_flashdata('alert', '<div class="alert alert-success" role="alert">
                Please check your email to reset your password!
            </div>');
            redirect('forgot-password');
        } else {
            $this->session->set_flashdata('type', 'warning');
            $this->session->set_flashdata('message', 'Employee ID not registered or activated.');
            redirect('forgot-password');
        }
    }

    private function _send_email($token, $email, $type)
    {
        // Load PHPMailer
        $this->load->library('PHPMailer_load');
        $mail = $this->phpmailer_load->load();

        try {
            $mail->clearAddresses();
            $mail->clearCCs();
            $mail->clearBCCs();

            // === Konfigurasi SMTP ===
            $mail->isSMTP();
            $mail->Host       = 'mail.samorausahamakmur.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'it.info@samorausahamakmur.com';
            $mail->Password   = 'SumEmail3903183'; //password server email
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // === Pengirim ===
            $mail->setFrom('noreply@samorausahamakmur.com', 'E-ci Platform Notification');
            $mail->addAddress($email);

            // === Isi Email ===
            if ($type == 'forgot') {
                $resetLink = base_url('reset-password?email=' . urlencode($email) . '&token=' . urlencode($token));

                $mail->Subject = 'Reset Your Password - E-ci Platform';
                $mail->msgHTML("
                <p>Halo,</p>
                <p>Kami menerima permintaan untuk mereset password akun Anda di <b>E-ci Platform</b>.</p>
                <p>Silakan klik tombol di bawah ini untuk mengatur ulang password Anda:</p>
                <p style='margin-left:10px 0 10px 10px'>
                    <a href='{$resetLink}' 
                        style='background-color:#4e73df; color:#fff; padding:10px 20px; text-decoration:none; border-radius:5px;'>
                        Reset Password
                    </a>
                </p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini. Link ini hanya berlaku selama <b>1 jam</b>.</p>
                <br>
                <p>Terima kasih,</p>
                <p><b>E-ci Platform Notification</b></p>
            ");
            }

            // === Kirim Email ===
            if (!$mail->send()) {
                log_message('error', 'Gagal mengirim email ke ' . $email . ' - ' . $mail->ErrorInfo);
                return false;
            } else {
                log_message('info', 'Email reset password dikirim ke ' . $email);
                return true;
            }
        } catch (Exception $e) {
            log_message('error', 'Mailer Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function reset_password()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        
        $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            
            if ($user_token) {

                $now = time();
                if ($user_token['date_created'] < $now - (60 * 60)) {
                    $this->db->delete('user_token', ['email' => $email]);
                    
                    $this->session->set_flashdata('type', 'warning');
                    $this->session->set_flashdata('message', 'Reset password failed! Token expired.');
                    redirect('login');
                }
                $this->session->set_userdata('reset_email', $email);
                $this->load->view('layouts/reset_password');
            } else {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('message', 'Reset password failed! Wrong token.');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('type', 'warning');
            $this->session->set_flashdata('message', 'Reset password failed! Wrong email.');
            redirect('login');
        }
    }

    public function process_reset_password()
    {
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirm', 'required|trim|min_length[6]|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/reset_password');
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password)
                ->where('email', $email)
                ->update('user');

            $this->db->delete('user_token', ['email' => $email]);

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Password has been reset! Please login.');
            redirect('login');
        }
    }

/**
 * Destroys the current user's session and logs them out.
 *
 *Sends a flash message of type 'info' with the message 'You have been logged out successfully.' and redirects the user to the login page.
 */
    public function logout()
    {
        $this->session->sess_destroy();

        $this->session->set_flashdata('type', 'info');
        $this->session->set_flashdata('message', 'You have been logged out successfully.');
        redirect('login');
    }
}
