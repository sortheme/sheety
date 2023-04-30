<?php 
namespace SorthSheetyApi ;

class api{

    private $base_url;
    private $project;
    private $sheet;
    private $authorization=false;

    function __construct(){

    }

    function get_time(){
        return date('c');
    }

    function set_base_url($url){
        $this->base_url = $url;
    }

    function set_project($project){
        $this->project = $project;
    }

    function set_sheet($sheet){
        $this->sheet = $sheet;
    }

    function set_authorization($authorization){
        $this->authorization = $authorization;
    }

    private function get_full_url(){
        return $this->base_url.'/'.$this->project.'/'.$this->sheet;
    }

    function get_sheet_data(){
        /** for getting data we dont need content-type header */
        $url = $this->get_full_url();
        $headers = array();
        $auth = !empty($this->authorization) ? $this->authorization : '';
        if($auth){
            $headers[] = $auth;
        }
        $data = $this->curl($url, 'GET', $headers, '');
        return $data;
    }

    function get_sheet_row($id){
        /** for getting data we dont need content-type header */
        $url = $this->get_full_url();
        $url .= '/'.$id;
        $headers = array();
        $auth = !empty($this->authorization) ? $this->authorization : '';
        if($auth){
            $headers[] = $auth;
        }
        $data = $this->curl($url, 'GET', $headers, '');
        return $data;
    }

    /** $filters should be an array of  'property' => 'value' */
    function filter_sheet_rows($filters){
        $s = array(
            'filter' => $filters
        );
        $url = $this->get_full_url().'?'.http_build_query( $s);
        $headers = array();
        $auth = !empty($this->authorization) ? $this->authorization : '';
        if($auth){
            $headers[] = $auth;
        }
        $data = $this->curl($url, 'GET', $headers, '');
        return $data;
    }

    function add_new_row_to_sheet($fields){
        $url = $this->get_full_url();
        $headers = array(
            'Content-Type: application/json'
        );
        $auth = !empty($this->authorization) ? $this->authorization : '';
        if($auth){
            $headers[] = $auth;
        }
        
        $data = $this->curl($url, 'POST', $headers, $fields);
        return $data;
    }

    function update_row_in_sheet($fields, $id){
        /** id is begining from 2 where id=2 is for first row (header is 1, so be carefull boy!) */
        $url = $this->get_full_url();
        $url .= '/'.$id;
        $headers = array(
            'Content-Type: application/json'
        );
        $auth = !empty($this->authorization) ? $this->authorization : '';
        if($auth){
            $headers[] = $auth;
        }
        
        $data = $this->curl($url, 'PUT', $headers, $fields);
        return $data;
    }

    private function curl($url, $type='POST', $headers=array(), $fields=''){
        $curl = curl_init();
        $args = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        );
        $args[CURLOPT_URL] = $url;
        $args[CURLOPT_HTTPHEADER] = $headers;
        $args[CURLOPT_CUSTOMREQUEST] = $type;
        $args[CURLOPT_POSTFIELDS] = json_encode($fields);
        curl_setopt_array($curl, $args);
        $response = curl_exec($curl);
        return $response;
    }





}