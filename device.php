<?php
class DeviceComponent extends Object {
    var $_ua = '';
    public function __construct() {
        $this->_ua = $_SERVER['HTTP_USER_AGENT'];
    }
    public function get_user_agent() {
        return $this->_ua;
    }
    public function is_ios() {
        return ($this->is_ios_device()) ? true : false ;
    }
    public function is_android() {
        $matched = preg_match('/\bAndroid\s*\d+\.\d+/', $this->_ua);
        return $matched > 0;
    }
    public function is_windows_phone() {
        $matched = preg_match('/(\bWindows Phone OS|ZuneWP7)\b/', $this->_ua);
        return $matched > 0;
    }
    public function is_phone() {
        return ($this->is_ios_device() == 'iPhone') ? true : false ;
    }
    public function is_pad() {
        return ($this->is_ios_device() == 'iPad') ? true : false ;
    }
    public function is_pod() {
        return ($this->is_ios_device() == 'iPod') ? true : false ;
    }
    public function is_ios_device() {
        if ( preg_match('!^Mozilla/\S+\s+\((iPhone|iPod|iPad)\b!', $this->_ua, $m) ) {
            return $m[1];
        }
        return null;
    }
    public function is_smartphone() {
        return ($this->is_ios() || $this->is_android() || $this->is_windows_phone()) ? true : false ;
    }
}
