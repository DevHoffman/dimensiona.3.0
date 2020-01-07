<?php
Class Notify
{

    public function __construct()
    {
        $this->CI = &get_instance();


    }

    public function send($data){

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://nuvem54.hoteldaweb.com.br',
            'smtp_port' => 465,
            'smtp_user' => 'suporte@pharmanexo.com.br',
            'smtp_pass' => 'Pharma_TI_2019',
            'validate' => true,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'wordwrap' => true,
        );

        $this->CI->load->library('email', $config);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->set_crlf("\r\n");

        $this->CI->email->initialize($config);
        $this->CI->email->clear();
        $this->CI->email->from("no-reply@pharmanexo.com.br", 'Portal Pharmanexo');
        $this->CI->email->to($data['to']);

        $template = file_get_contents(base_url('/public/html/template_mail/notify_tmp.html'));

        $body = str_replace(['%body%', '%subject%', '%greeting%'], [$data['message'], $data['subject'], $data['greeting']], $template);

        $this->CI->email->subject($data['subject']);
        $this->CI->email->message($body);

        return  $this->CI->email->send();

    }

    public function alert($data){

        if (isset($data['id_usuario']) && isset($data['id_fornecedor']) && isset($data['message'])){
            if (!empty($data['id_usuario']) && !empty($data['id_fornecedor']) && !empty($data['message'])){

                $this->CI->db->insert("notifications", $data);

            }
        } else {

            $this->CI->db->insert("notifications", $data);
        }

    }


}