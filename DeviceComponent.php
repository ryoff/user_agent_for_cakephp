<?php
// cakephp 2.x
class DeviceComponent extends Component {
    var $_ua = '';
    var $_pc_browser = '';
    var $_pc_version = '';
    public function __construct() {
        $this->_ua = $_SERVER['HTTP_USER_AGENT'];

        // マイナー
        if (preg_match('/(Iron|Sleipnir|Maxthon|Lunascape|SeaMonkey|Camino|PaleMoon|Waterfox|Cyberfox)\/([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = $matches[1];
            $this->_pc_version = $matches[2];
        // 主要
        } elseif (preg_match('/(^Opera|OPR).*\/([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = 'Opera';
            $this->_pc_version = $matches[2];
        } elseif (preg_match('/Chrome\/([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = 'Chrome';
            $this->_pc_version = $matches[1]; 
        } elseif (preg_match('/Firefox\/([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = 'Firefox';
            $this->_pc_version = $matches[1];
        } elseif (preg_match('/(MSIE\s|Trident.*rv:)([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = 'IE';
            $this->_pc_version = $matches[2];
        } elseif (preg_match('/\/([0-9\.]+)(\sMobile\/[A-Z0-9]{6})?\sSafari/', $this->_ua, $matches)) {
            $this->_pc_browser = 'Safari';
            $this->_pc_version = $matches[1];
        // ゲーム機
        } elseif (preg_match('/Nintendo (3DS|WiiU))/', $this->_ua, $matches)) {
            $this->_pc_browser = 'Nintendo';
            $this->_pc_version = $matches[1];
        } elseif (preg_match('/PLAYSTATION (3|Vita))/', $this->_ua, $matches)) {
            $this->_pc_browser = 'PLAYSTATION';
            $this->_pc_version = $matches[1];
        // BOT
        } elseif (preg_match('/(Googlebot|bingbot)\/([0-9\.]+)/', $this->_ua, $matches)) {
            $this->_pc_browser = $matches[1];
            $this->_pc_version = $matches[2];
        } else {
            $this->_pc_browser = 'unidentified';
            $this->_pc_version = 'unidentified';
        }
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

    // {{{ smart phone 以外
    public function is_pc() {
        return !$this->is_smartphone();
    }
    public function is_pc_opera() {
        return $this->_pc_browser == 'Opera';
    }
    public function is_pc_chrome() {
        return $this->_pc_browser == 'Chrome';
    }
    public function is_pc_firefox() {
        return $this->_pc_browser == 'Firefox';
    }
    public function is_pc_ie() {
        return $this->_pc_browser == 'IE';
    }
    public function is_pc_safari() {
        return $this->_pc_browser == 'Safari';
    }
    public function is_pc_nintendo() {
        return $this->_pc_browser == 'Nintendo';
    }
    public function is_pc_playstation() {
        return $this->_pc_browser == 'PLAYSTATION';
    }
    public function is_game_device() {
        return ($this->is_pc_nintendo() || $this->is_pc_playstation()) ? true : false;
    }
    public function is_pc_googlebot() {
        return $this->_pc_browser == 'Googlebot';
    }
    public function is_pc_bingbot() {
        return $this->_pc_browser == 'bingbot';
    }
    public function is_bot() {
        return ($this->is_pc_googlebot() || $this->is_pc_bingbot()) ? true : false;
    }
    // }}}
}
